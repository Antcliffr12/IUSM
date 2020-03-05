<?php

class Mega_Menu_API extends WP_REST_Controller{

    private $auth = false;

    public function register_routes()
    {
        $version = '1';
        $namespace = 'iusm/v' . $version;
        $base = 'route';
        register_rest_route( $namespace, '/' . $base . '/mega-menu', array(
            [
                'methods'  => 'GET',
                'callback' => array( $this, 'get_mega_menu' ),
            ],
        ) );
    }

    public function get_mega_menu(){
        try {
            $data = [
                'about' => file_get_contents(__DIR__ . '/../../assets/components/site-bar/megamenu-about.inc', FILE_USE_INCLUDE_PATH),
                'campus' => file_get_contents(__DIR__ . '/../../assets/components/site-bar/megamenu-campus.inc', FILE_USE_INCLUDE_PATH),
                'departments' => file_get_contents(__DIR__ . '/../../assets/components/site-bar/megamenu-departments.inc', FILE_USE_INCLUDE_PATH),
                'education' => file_get_contents(__DIR__ . '/../../assets/components/site-bar/megamenu-education.inc', FILE_USE_INCLUDE_PATH),
                'expertise' => file_get_contents(__DIR__ . '/../../assets/components/site-bar/megamenu-expertise.inc', FILE_USE_INCLUDE_PATH),
                'give' => file_get_contents(__DIR__ . '/../../assets/components/site-bar/megamenu-give.inc', FILE_USE_INCLUDE_PATH),
                'research' => file_get_contents(__DIR__ . '/../../assets/components/site-bar/megamenu-research.inc', FILE_USE_INCLUDE_PATH),
                'news' => file_get_contents(__DIR__ . '/../../assets/components/site-bar/megamenu-news.inc', FILE_USE_INCLUDE_PATH),
            ];

            return new WP_REST_Response( $data, 200 );
        }catch(\Exception $exception){
            return new WP_Error('code', __($exception->getMessage(), 'iusm'));
        }
    }


}
$megaMenu = new Mega_Menu_API();
$megaMenu->register_routes();
