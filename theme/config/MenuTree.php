<?php
class MenuTree {
	var $menu_id = null;
	var $items = array();
	var $current_branch = array();
	var $current_ancestors = array();
	var $max_depth = 10;

	function __construct($menu_id = 'main', $path = '/') {
		global $post, $current_path;
		$this->menu_id = $menu_id;
		$this->max_depth = 10;
		$this->items = wp_get_nav_menu_items($this->menu_id);
		$this->current_ancestors = get_post_ancestors($post);
		// Convert the flattened array into a keyed tree
		$this->buildTree($this->items, 0);

		if ($path !== '/') {
			$this->setScope($path);
		} else {
			$this->setScope(0);
		}
		return $this;
	}

	function setMaxDepth($depth) {
		$this->max_depth = $depth;
		return $this;
	}

	/**
	 * @param $id A string path or the object ID for the page serving as the menu root
	 */
	function getScope($id) {
		$oid = is_int($id) ? $id : url_to_postid(WP_SITEURL . $id);
		if ($oid !== 0) {
			foreach ($this->items as $item) {
				if ($item->object_id == $oid) {
					return [$item];
				}
			}
		}
		return [];
	}

	/**
	 * Stores the result of a getScope() operation as the current branch
	 * @param $id A string path or the object ID for the page serving as the menu root
	 */
	function setScope($id) {
		$items = $this->getScope($id);
		$this->current_branch = $items;
		return $this;
	}

	private function buildTree(array &$elements, $parentId = 0) {
		$branch = array();
		foreach ($elements as &$element)
		{
			if ($element->menu_item_parent == $parentId) {
				$children = $this->buildTree($elements, $element->ID);
				if ($children) {
					$element->wpse_children = $children;
				}
				$branch[$element->ID] = $element;
				unset($element);
			}
		}
		return $branch;
	}

	function render($options) {
		$skip_root = false;
		$items = false;
		$depth = 0;
		extract($options);
		global $current_path, $post;
		if ($depth > $this->max_depth) {
			return '';
		}
		if (!$items) {
			$items = $this->current_branch;
		}
		if (count($items) === 0) {
			return '';
		}
		if ($skip_root) {
			$root = array_shift($items);
			return $this->render(['items' => $root->wpse_children]);
		}
		$classes = [];
		if ($depth === 0) {
			$classes[] = 'menu';
			if (isset($root_menu_classes)) {
				$classes[] = $root_menu_classes;
			}
		} else {
			$classes[] = 'sub-menu';
		}
		$markup = '<ul class="'.implode(' ', $classes).'" data-menudepth="'.$depth.'">'.PHP_EOL;
		foreach ($items as $id => $item) {

			if (isset($exclude_by_title) && in_array($item->title, $exclude_by_title)) {
				$exclude_by_title = array_filter($exclude_by_title, function($k, $v){
					return $v != $item->title;
				});
				continue;
			}
			if (isset($include_by_title) && !in_array($item->post_title, $include_by_title)) {
				$include_by_title = array_filter($include_by_title, function($k, $v){
					return $v != $item->title;
				});
				continue;
			}

			$item->classes[] = 'menu-item';
			if ($current_path == $item->url) {
				$item->classes[] = 'current-menu-item';
			} else if (stripos($current_path, $item->url) === 0) {
				$item->classes[] = 'current-menu-ancestor';
			}

			$markup .= '<li class="'. trim(implode(' ', $item->classes)) .'" data-itemid="'. $id .'"><a rel="page" href="'. $item->url .'">'. $item->title .'</a>';
			if (isset($item->wpse_children) && count($item->wpse_children) > 0) {
				$markup .= PHP_EOL . $this->render(['items' => $item->wpse_children, 'depth' => $depth + 1]);
			}
			$markup .= '</li>'.PHP_EOL;
		}
		$markup .= '</ul>'.PHP_EOL;
		return $markup;
	}

}
