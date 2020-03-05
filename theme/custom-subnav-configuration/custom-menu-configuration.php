<?php
/**
 * Adds support to add WordPress menus as menu items.
 * Class CustomMenuAdmin
 */

// restrictions
// you cannot have more that one reference to a menu ever in the tree it will favor the first one and delete the other
// you cannot "nest" a nav menu under another in the same menu. You can into the parent menu and add the next menu there.
// menu items will only show if the path matches correctly 

class CustomSubNavConfiguration{

    public $current_page_url;
    public $unset_map = [];
    public function __construct()
    {
        add_action('init', [$this, 'init']);
    }

    public function init(){
        add_filter( 'wp_nav_menu_objects', [$this, 'my_wp_nav_menu_objects_sub_menu'], 10, 2 );
    }

    function my_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {

          if ( isset( $args->sub_menu ) ) {
            $subnav_root_path = isset($args->subnav_root_path) && !empty($args->subnav_root_path) ? $args->subnav_root_path : null;

            if (empty($post)){
                $current_path = get_page_uri((int)url_to_postid($_SERVER['REQUEST_URI']));
            } else {
                $current_path = get_page_uri((int)$post->ID);
            }
            
            $site_url = get_site_url();
            $this->current_page_url = $site_url . '/' . $current_path . '/';

            if (empty($root_id)){
                $root_id = url_to_postid($_SERVER['REQUEST_URI']);
            }

            $activeParentKey = $this->getActiveParentKey($sorted_menu_items, $post, $subnav_root_path);
            $rootParent = $sorted_menu_items[$activeParentKey]->ID;
            $sorted_menu_items = $this->populateNavMenus($rootParent, $sorted_menu_items);

            foreach ( $sorted_menu_items as $menu_item ) {
              if ( $subnav_root_path . '/' == parse_url($menu_item->url, PHP_URL_PATH)) {
                $root_id =  $menu_item->ID;
                break;
              }
            }

            
            $menu_item_parents = array();

            foreach ( $sorted_menu_items as $key => $item ) {
              // init menu_item_parents
              if ( $item->ID == $root_id ) {
                $menu_item_parents[] = $item->ID;
              } 
              if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
                // part of sub-tree: keep!
                $menu_item_parents[] = $item->ID;
              } else if ( ! ( isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents ) ) ) {
                // not part of sub-tree: away with it!
                unset( $sorted_menu_items[$key] );
              }
            }

    
            $sorted_menu_items = $this->setMenuItemsToKeyVals($sorted_menu_items);
            $sorted_menu_items = $this->unsetNavMenus($sorted_menu_items);
              
            $this->setCurrentActiveMenu($this->getCurrentMenuItem($sorted_menu_items),$sorted_menu_items,true);

            $this->childrenOnly($sorted_menu_items, $root_id ,$args->children_only);

            $this->itemClasses($sorted_menu_items,$args->li_item_classes);


            return $sorted_menu_items;
          } else {
            return $sorted_menu_items;
          }
        }

    private function loadSubMenus($menuItem) {
        $renderedMenuItems = [];
        $is_nav_menu = self::GetSimpleQueryVar($menuItem->url, 'nav_menu');
        if(!is_null($is_nav_menu)){
            $termQueryVar = self::GetSimpleQueryVar($menuItem->url, 'term');
            $submenuID = !is_null($termQueryVar) ? $termQueryVar : null;
            if(!is_null($submenuID)) {
                $menuItem->status = 'menu_of_menus';
                $items = wp_get_nav_menu_items($submenuID);
                if($items !== false) {
                    foreach ($items as $key => $value) {
                        $item_url = rtrim($value->url, "/");
                        $value->current = rtrim($this->current_page_url, '/') === $item_url ? true : false;
                        $value->current_item_ancestor = false;
                        $value->current_item_parent = false;

                        $value_is_nav_menu = self::GetSimpleQueryVar($value->url, 'nav_menu');

                        if($value->menu_item_parent == 0){
                            $value->menu_item_parent = $menuItem->menu_item_parent;
                        }

                        if ($value->current){
                            $value->classes = ['current-menu-item'];
                        }
                        array_push($renderedMenuItems, $value);
                    }
                }
            }
        } 
        if (count($renderedMenuItems) > 0){
            return $this->populateNavMenus($menuItem->ID , $renderedMenuItems);
        }
    }


    private function getActiveParentKey($sorted_menu_items, $post, $subnav_root_path){
        $activeParentKey = null;
        $site_url = get_site_url();

        foreach ($sorted_menu_items as $menu_item_key=>$menu_item) {

            $url_items = explode($site_url, rtrim($menu_item->url, '/'));
            if(count($url_items) <= 1)
                continue;

            $url_item = isset($url_items[1]) ? $url_items[1] : null;
            if($url_item === $subnav_root_path)
                $activeParentKey = $menu_item_key;

        }
        return $activeParentKey;
    }

    private function GetSimpleQueryVar($url, $var){
        $parts = parse_url($url);
        if(isset($parts['query'])){
            parse_str($parts['query'], $query);
            return isset($query[$var]) ? $query[$var] : '';
        }else{
            return null;
        }
    }

    private function populateNavMenus($root_id, $menu_items){
        $menu_items = $this->setMenuItemsToKeyVals($menu_items);
        foreach ($menu_items as $id => $menu_item) {
            if (self::loadSubMenus($menu_item)){
                $this->unset_map[] = $id; 
                $menu_items = array_merge($menu_items, self::loadSubMenus($menu_item));
            } 
        }
        return $menu_items;
    }

    private function getCurrentMenuItem($menu_items){
        foreach ($menu_items as $menu_item) {
            if($menu_item->current){
                return $menu_item->ID;
            }
        }
        return -1;
    }   

    // id starts with the current menu item then works its way backward adding classes to ancestors
    // start just indicates if its the first time thru or not
    private function setCurrentActiveMenu($id, &$menu_items, $start = false){
        foreach ($menu_items as $item) {
            if ($item->ID == $id){
                if ($start && !in_array('current-menu-item',$item->classes)){
                    $item->classes[] = 'current-menu-item';
                } else if (!in_array('current-menu-ancestor', $item->classes)){
                    $item->classes[] = 'current-menu-ancestor';
                }
                $this->SetCurrentActiveMenu($item->menu_item_parent, $menu_items);
            }
        }
    }

    public function childrenOnly(&$menu_items, $root_id ,$children_only = false){
        if ($children_only){
            foreach ($menu_items as $key => $menu_item) {
                if ($menu_item->menu_item_parent != $root_id){
                    unset($menu_items[$key]);
                }
            }
        }
    }

    public function itemClasses(&$menu_items,$classes = false){
        if ($classes){
            foreach ($menu_items as $key => $menu_item) {
                $menu_item->classes[] = $classes;
            }
        }
    }

    public function setMenuItemsToKeyVals($menu_items){
        $new_menu_items = [];
        foreach ($menu_items as $menu_item) {
            $new_menu_items[$menu_item->ID] = $menu_item;
        }
        return $new_menu_items;
    }

    public function unsetNavMenus($menu_items){
        foreach ($this->unset_map as $key) {
           unset($menu_items[$key]);
        }
        return $menu_items;
    }
}
new CustomSubNavConfiguration();