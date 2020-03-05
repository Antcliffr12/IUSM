<?php
/**
 * Adds support to add WordPress menus as menu items.
 * Class CustomMenuAdmin
 */

class CustomMenuAdmin{

    public function __construct()
    {
        add_filter( 'nav_menu_meta_box_object', [$this,'custom_add_menu_meta_box'], 10, 1);
    }

    function custom_add_menu_meta_box( $object ) {
        add_meta_box( 'custom-menu-metabox', __( 'Menus' ), [$this,'custom_menu_meta_box'], 'nav-menus', 'side', 'default' );
        return $object;
    }

    function custom_menu_meta_box(){
        global $nav_menu_selected_id;
        $walker = new Walker_Nav_Menu_Checklist();
        $current_tab = 'all';
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
        $removed_args = array( 'action', 'customlink-tab', 'edit-menu-item', 'menu-item', 'page-tab', '_wpnonce' );
        ?>
        <div id="menulist" class="categorydiv">

            <div id="tabs-panel-menulist-all" class="tabs-panel tabs-panel-view-all <?php echo ( 'all' == $current_tab ? 'tabs-panel-active' : 'tabs-panel-inactive' ); ?>">
                <ul id="menulist-checklist-all" class="categorychecklist form-no-clear">
                    <?php
                    echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $menus), 0, (object) array( 'walker' => $walker) );
                    ?>
                </ul>
            </div><!-- /.tabs-panel -->

            <p class="button-controls wp-clearfix">
			<span class="list-controls">
				<a href="<?php echo esc_url( add_query_arg( array( 'menulist-tab' => 'all', 'selectall' => 1, ), remove_query_arg( $removed_args ) )); ?>#menulist" class="select-all"><?php _e('Select All'); ?></a>
			</span>
                <span class="add-to-menu">
				<input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-menulist-menu-item" id="submit-menulist" />
				<span class="spinner"></span>
			</span>
            </p>

        </div><!-- /.categorydiv -->
        <?php
    }
}
new CustomMenuAdmin();