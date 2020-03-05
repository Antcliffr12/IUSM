<?php
/**
 * Custom Walker
 *
 * @access      public
 * @since       1.0
 * @return      void
 */
class split_walker extends Walker_Nav_Menu
{

    public function start_lvl(&$output, $depth = 0, $args = array() ) {

        $output .= '<ul class="submenu-'.$depth.'" ><span class="close"><i class="fa fa-times"></i></span>';
    }


    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        global $wp_query;

        if( !isset( $this->current_menu ) )
            $this->current_menu = wp_get_nav_menu_object( $args->menu );

        if( !isset( $this->break_point ) )
            $this->break_point = ceil( $this->current_menu->count / 2 ) + 1;

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'cheese menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        if( $this->break_point == $item->menu_order )
            $output .= $indent . '</li></ul><ul class="menu"><li' . $id . $value . $class_names .'>';
        else
            $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

}
