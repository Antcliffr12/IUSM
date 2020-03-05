<?php
/**
 * Custom Walker for  BLOG MENU. Detected if the item->title equals home. if so then it checks for category and sets the home link to that.
 *
 * @access      public
 * @since       1.0
 * @return      void
 */
class blog_menu_walker extends Walker_Nav_Menu
{

    public function start_lvl(&$output, $depth = 0, $args = array() ) {

      //  $output .= '<ul class="submenu-'.$depth.'" ><span class="close"><i class="fa fa-times"></i></span>';
    }


    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';


        $_URL = esc_attr( $item->url );

        $page_type = 'regular';
        $is_home_link = false;
        $title = strtolower(trim($item->title));
        // if(is_category()){
        //     $page_type = 'category';
        //     $term_id = get_the_category()[0]->term_id;
        //     $term_id = isset($term_id) && !empty($term_id) ? $term_id : null;
        //     $is_home_link = $title === 'home' ? true : false;
        //     if($is_home_link) {
        //         $_URL = !is_null($term_id) ? get_term_link($term_id) : $_URL;
        //     }
        // }

        // if(is_single()){
        //     $page_type = 'post';
        //     global $post;
        //     $term_id = get_the_category( $post->ID )[0]->term_id;
        //     $term_id = isset($term_id) && !empty($term_id) ? $term_id : null;
        //     $is_home_link = $title === 'home' ? true : false;
        //     if($is_home_link) {
        //         $_URL = !is_null($term_id) ? get_term_link($term_id) : $_URL;
        //     }
        // }

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

            $output .= $indent . '<li data-menuid="'. $item->ID . '"' . $value . $class_names .' ">';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $_URL )        ? ' href="'   . $_URL .'"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .' data-type="'.$page_type.'">';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}
