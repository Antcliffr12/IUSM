<?php

/**
 * ReduxFramework Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if ( ! class_exists( 'ReduxFrameworkConfig' ) ) {

    class ReduxFrameworkConfig {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if ( ! class_exists( 'ReduxFramework' ) ) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
            }

        }

        public function initSettings() {

            // Disable tracking if not set
            $redux_tracking = get_option('redux-framework-tracking');
            if ($redux_tracking != 'no') {
                $redux_tracking['allow_tracking'] = 'no';
                update_option('redux-framework-tracking', $redux_tracking);
            }

            // Get the user
            $this->_current_user = wp_get_current_user();

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
        }

        /**
        Filter hook for filtering the args.
        Good for child themes to override or add to the args array. Can also be used in other functions.
         **/
        function change_arguments($args){
            $args['dev_mode'] = false;

            return $args;
        }

        /**
        Filter hook for filtering the default value of any given field. Very useful in development mode.
         **/
        function change_defaults($defaults){
            $defaults['str_replace'] = "Testing filter hook!";

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }

        public function setSections() {
            global $wpdb;
            /**
            Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             **/

            ob_start();

            $ct = wp_get_theme();
            $this->theme = $ct;
            $item_name = $this->theme->get('Name');
            $tags = $this->theme->Tags;
            $screenshot = $this->theme->get_screenshot();
            $class = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;','iusm' ), $this->theme->display('Name') );

            ?>
            <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                <?php if ( $screenshot ) : ?>
                    <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
                            <img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
                        </a>
                    <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
                <?php endif; ?>

                <h4>
                    <?php echo $this->theme->display('Name'); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf( __('By %s','iusm'), $this->theme->display('Author') ); ?></li>
                        <li><?php printf( __('Version %s','iusm'), $this->theme->display('Version') ); ?></li>
                        <li><?php echo '<strong>'.__('Tags', 'iusm').':</strong> '; ?><?php printf( $this->theme->display('Tags') ); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
                    <?php if ( $this->theme->parent() ) {
                        printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
                            __( 'http://codex.wordpress.org/Child_Themes','iusm' ),
                            $this->theme->parent()->display( 'Name' ) );
                    } ?>

                </div>

            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();




            // General Settings
            $this->sections[] = [
                'icon' => 'el-icon-cogs',
                'title' => __('General Settings', 'iusm'),
                'id' => 'general-settings',
            ];
            $this->sections[] = [
                'title'      => __('Tracking Code', 'iusm'),
                'id'         => 'tracking-code',
                'subsection' => true,
                'desc'       => '',
                'fields'     => array(
                    array(
                        'id'=>'tracking-code-field',
                        'type' => 'textarea',
                        'title' => __('Tracking Code', 'iusm'),
                        'subtitle' => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'iusm'),
                    ),
                )
            ];
            $this->sections[] = [
                'title'      => __('Javascript Code', 'iusm'),
                'id'         => 'javascript-code',
                'subsection' => true,
                'desc'       => '',
                'fields'     => array(
                    array(
                        'id'=>'javascript-code-field',
                        'type' => 'textarea',
                        'title' => __('Javascript Code', 'iusm'),
                        'subtitle' => __('Paste any extra JS code here.', 'iusm'),
                    ),
                )
            ];
            $this->sections[] = [
                'title'      => __('Css Code', 'iusm'),
                'id'         => 'css-code',
                'subsection' => true,
                'desc'       => '',
                'fields'     => array(
                    array(
                        'id'=>'css-code-field',
                        'type' => 'textarea',
                        'title' => __('CSS Code', 'iusm'),
                        'subtitle' => __('Paste your CSS code here.', 'iusm'),
                    ),
                )
            ];



            // Footer
            $this->sections[] = [
                'title' => __('Footer', 'iusm'),
                'id' => 'footer-settings',
            ];
            $this->sections[] = [
                'title'      => __('About Content', 'iusm'),
                'id'         => 'about-section',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'=>'about-section-title',
                        'type' => 'text',
                        'title' => __('Title', 'iusm'),
                        'subtitle' => __('Add title for section.', 'iusm'),
                    ),
                    array(
                        'id'=>'about-section-content',
                        'type' => 'textarea',
                        'title' => __('Content', 'iusm'),
                        'subtitle' => __('Add about description for footer.', 'iusm'),
                    ),
                )
            ];
            $this->sections[] = [
                'title'      => __('Footer Menu Title', 'iusm'),
                'id'         => 'menu-title',
                'subsection' => true,
                'desc'       => __('Provides a title for the menu in the footer.','iusm'),
                'fields'     => array(
                    array(
                        'id'=>'footer-menu-title',
                        'type' => 'text',
                        'title' => __('Title', 'iusm'),
                        'subtitle' => __('Add title for menu.', 'iusm'),
                        'default'  => __('Popular Resources', 'iusm'),
                    ),
                )
            ];
            $this->sections[] = [
                'title'      => __('Contact Information', 'iusm'),
                'id'         => 'contact-info',
                'subsection' => true,
                'desc'       => '',
                'fields'     => array(
                    array(
                        'id'=>'contact-info-title',
                        'type' => 'text',
                        'title' => __('Title', 'iusm'),
                        'subtitle' => __('Add title for section.', 'iusm'),
                        'default' => __('Contact & Support', 'iusm'),
                    ),
                    array(
                        'id'=>'button-label',
                        'type' => 'text',
                        'title' => __('Button Label', 'iusm'),
                        'desc' => __('Label that appears for the Button Link if link is available.','iusm'),
                        'default' => __('Support Form','iusm'),
                    ),
                    array(
                        'id'=>'button-link',
                        'type' => 'text',
                        'title' => __('Button Link', 'iusm'),
                        'desc' => __('Link for Button below contact information. If left empty button does not appear.','iusm'),
                    ),
                    array(
                        'id'=>'address-one',
                        'type' => 'text',
                        'title' => __('Address One', 'iusm'),
                    ),
                    array(
                        'id'=>'address-two',
                        'type' => 'text',
                        'title' => __('Address Two', 'iusm'),
                    ),
                    array(
                        'id'=>'address-three',
                        'type' => 'text',
                        'title' => __('Address Three', 'iusm'),
                    ),
                    array(
                        'id'=>'address-four',
                        'type' => 'text',
                        'title' => __('Address Four', 'iusm'),
                    ),
                    array(
                        'id'=>'city',
                        'type' => 'text',
                        'title' => __('City', 'iusm'),
                    ),
                    array(
                        'id'=>'state',
                        'type' => 'text',
                        'title' => __('State', 'iusm'),
                    ),
                    array(
                        'id'=>'zip',
                        'type' => 'text',
                        'title' => __('Zip Code', 'iusm'),
                    ),
                    array(
                        'id'=>'phone',
                        'type' => 'text',
                        'title' => __('Phone', 'iusm'),
                    ),
                    array(
                        'id'=>'email',
                        'type' => 'text',
                        'title' => __('Email', 'iusm'),
                    ),

                )
            ];
            $this->sections[] = [
                'title'      => __('Social Media', 'iusm'),
                'id'         => 'social-media',
                'subsection' => true,
                'desc'       => __('Fields for adding social media items to footer. If item left blank, it will not appear.','iusm'),
                'fields'     => array(
                    array(
                        'id'=> __('social-media-title', 'iusm'),
                        'type' => 'text',
                        'title' => __('Social Media Title', 'iusm'),
                        'subtitle' => __('Add title for section.', 'iusm'),
                        'default' => 'Connect with Us!',
                    ),
                    array(
                        'id'=>'facebook-link',
                        'type' => 'text',
                        'title' => __('Facebook:', 'iusm'),
                        'default' => '',
                    ),
                    array(
                        'id'=>'linkedIn-link',
                        'type' => 'text',
                        'title' => __('LinkedIn:', 'iusm'),
                        'default' => '',
                    ),
                    array(
                        'id'=>'twitter-link',
                        'type' => 'text',
                        'title' => __('Twitter:', 'iusm'),
                        'default' => '',
                    ),
                    array(
                        'id'=>'instagram-link',
                        'type' => 'text',
                        'title' => __('Instagram:', 'iusm'),
                        'default' => '',
                    ),
                )
            ];




            $theme_info = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'shcreate').'<a href="'.$this->theme->get('ThemeURI').'" target="_blank">'.$this->theme->get('ThemeURI').'</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'shcreate').$this->theme->get('Author').'</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'shcreate').$this->theme->get('Version').'</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">'.$this->theme->get('Description').'</p>';
            $tabs = $this->theme->get('Tags');
            if ( !empty( $tabs ) ) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'shcreate').implode(', ', $tabs ).'</p>';
            }
            $theme_info .= '</div>';

            if(file_exists(dirname(__FILE__).'/README.md')){
                $this->sections['theme_docs'] = array(
                    'icon' => ReduxFramework::$_url.'assets/img/glyphicons/glyphicons_071_book.png',
                    'title' => __('Documentation', 'shcreate'),
                    'fields' => array(
                        array(
                            'id'=>'17',
                            'type' => 'raw',
                            'content' => file_get_contents(dirname(__FILE__).'/README.md')
                        ),
                    ),

                );
            }

            $this->sections[] = array(
                'icon' => 'el-icon-info-sign',
                'title' => __('Theme Information', 'iusm'),
                'fields' => array(
                    array(
                        'id'=>'raw_new_info',
                        'type' => 'raw',
                        'content' => $item_info,
                    )
                ),
            );

            $this->sections[] = array(
                'type' => 'divide',
            );
        }

        public function setHelpTabs() {
            //This intentionally left empty
        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'             => 'iusm_config',
                'display_name'         => $theme->get( 'Name' ),
                'display_version'      => $theme->get( 'Version' ),
                'menu_type'            => 'menu',
                'allow_sub_menu'       => true,
                'menu_title'           => __( 'Theme Settings', 'iusm' ),
                'page_title'           => __( 'Theme Settings', 'iusm' ),
                'google_api_key'       => '',
                'google_update_weekly' => false,
                'async_typography'     => true,
                'admin_bar'            => true,
                'admin_bar_icon'     => 'dashicons-portfolio',
                'admin_bar_priority' => 40,
                'global_variable'      => '',
                'dev_mode'             => false,
                'update_notice'        => false,

                // OPTIONAL -> Give you extra features
                'page_priority'        => null,
                'page_parent'          => 'themes.php',
                'page_permissions'     => 'manage_options',
                'menu_icon'            => '',
                'last_tab'             => '',
                'page_icon'            => 'icon-themes',
                'page_slug'            => '_options',
                'save_defaults'        => true,
                'default_show'         => false,
                'default_mark'         => '',
                'show_import_export'   => true,

                // CAREFUL -> These options are for advanced use only
                'transient_time'       => 60 * MINUTE_IN_SECONDS,
                'output'               => true,
                'output_tag'           => true,
                'footer_credit'     => '',// Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'customizer'         	=> false, // Enable customizer support
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false,
                'disable_tracking'      => true,
                'help_tabs'          	=> array(),
                'help_sidebar'       	=> '',
                'network_admin' => true,
                'network_sites' => true
            );
        }
    }

    global $reduxConfig;
    $reduxConfig = new ReduxFrameworkConfig();
} else {
    echo "The class named Redux_Framework_sample_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
}