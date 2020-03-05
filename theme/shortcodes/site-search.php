<?php

namespace IUSM;

class SiteSearch{

    public function __construct()
    {
        add_shortcode( 'site-search', array( $this , 'ShortCode') );
    }

    public function ShortCode($atts)
    {

        $url = get_home_url();

        $class = !empty($atts['class']) ? 'class="' . $atts['class'] . '"' : '';
        $placeholder = !empty($atts['placeholder']) ? 'placeholder="' . $atts['placeholder'] . '"' : '';
        $result = '';
        if(! is_admin()){

            $result .= '<form role="search" method="get" action="'.$url.'">';
            $result .= '<label for="q" class="hidden">Enter Your Search Text</label>';
            $result .= '<input type="text" '.$placeholder.' value="" name="q" id="q">';
            $result .= '<span class="search-submit"><input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" '.$class.'></span>';
            $result .= '</form>';

        }
        echo $result;

    }

}

new SiteSearch();
