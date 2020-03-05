<?php


class Utilities {


    public function DropDownList($name,$idName) {

            global $post;
            //$args = array( 'post_type' => 'event','taxonomy_name' => $name );

            $args = array(
            'numberposts' => -1, // we want to retrieve all of the posts
            'post_type' => 'event',
            'orderby'   => 'ID',
             'order'     => 'ASC',
            'suppress_filters' => false, // this argument is required for CPT-onomies
            'tax_query' => array(
               array(
            'taxonomy' => 'events',
         	 'field'    => 'slug',
         	 'terms'    => array( $name )
               )
            ));

            $arrayLocation = [];

            $text = get_the_title();
            $newtext = wordwrap($text, 50, "<br />\n");
            $content = '<select name="' . $name . '" id="' . $idName . '">'.
                            '<option value="0">Select</option>';

                            $myposts = get_posts( $args );
                            foreach ( $myposts as $post ) : setup_postdata( $post );

                                $content.= '<option value="'. esc_url( get_post_meta( get_the_ID(), 'url', true ) ) .'">'. get_the_title() .'</option>';

                            endforeach;
            wp_reset_postdata();

            $content.= '</select>';

            return $content;
    }

    public function Audience($name,$idName){


      $content = '<select name="' . $name . '" id="' . $idName . '">'.
      '<option value="0">Select</option>';
      $content .= '<option value="Alumni">
      Alumni
      </option>';
      $content .= '<option value="Donors">
      Donors
      </option>';
      $content .= '<option value="Faculty">
      Faculty
      </option>';
      $content .= '<option value="Media">
      Media
      </option>';
      $content .= '<option value="Staff">
      Staff
      </option>';
      $content .= '<option value="Undergraduate Student">
      Undergraduate Student
      </option>';
      $content .= '<option value="Postdoctoral Student">
      Postdoctoral Student
      </option>';
      $content .= '<option value="House Staff">
      House Staff
      </option>';
      $content .= '<option value="Graduate Students">
      Graduate Students
      </option>';
      $content .= '<option value="Medical Students">
      Medical Students
      </option>';

      $content.= '</select>';

      return $content;

    }


}

?>
