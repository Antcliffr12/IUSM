<?php
/** Custom Tag Metabox based on USER Role */

class CustomPostTagMetabox
{

    private $postType = ['post'];

    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_metabox'], 10, 2);
    }

    public function add_metabox()
    {
        add_meta_box('custom-post_tag',__( 'Tags', '' ),[$this, 'output_box'],$this->postType, 'side', 'default');
    }

    public function output_box($post)
    {

        $tags = get_terms( array('taxonomy' => 'post_tag', 'hide_empty' => 0) );
        $tags_of_post = get_the_terms( $post->ID, 'post_tag' );

        // Build array of all tags assigned to post
        $ids = array();
        if ( $tags_of_post ) {
            foreach ($tags_of_post as $tag ) {
                array_push($ids, $tag->term_id);
            }
        }

//        wp_die('<pre>'.print_r($tags_of_post, 1).'</pre>');

        $index = (int)count($tags_of_post) - 1;


        echo '<div id="taxonomy-post_tag" class="categorydiv">';
        echo '<input type="hidden" name="tax_input[post_tag][]" value="0" />';

        echo '<div class="tag-select-container">';
        echo '<select class="tag-selector">';
        echo '<option value="0">Select</option>';
        foreach($tags as $tag){
            if(!in_array($tag->term_id, $ids)) {
                echo '<option value="' . $tag->name . '">' . $tag->name . '</option>';
            }
        }
        echo '</select>';
        echo '</div>';
        echo '<input type="button" class="tag-selector-add button tagadd" value="Add"/>';

        echo '<div class="tagchecklist" data-index="'.$index.'" style="margin-top:9px;">';
        if(!empty($tags_of_post)) {
            foreach ($tags_of_post as $key => $value) {
                echo '<span>';
                echo '<button data-tag-value="' . $value->name . '" type="button" id="post_tag-check-num-' . $key . '" class="ntdelbutton">';
                echo '<span class="remove-tag-icon" aria-hidden="true"></span>';
                echo '<span class="screen-reader-text">Remove term: ' . $value->name . '</span>';
                echo '</button>';
                echo '&nbsp;' . $value->name;
                echo '</span>';
            }
        }
        echo '</div>';


        echo '<div class="tagInputFields">';
        if(!empty($tags_of_post)) {
            foreach ($tags_of_post as $key => $value) {
                echo '<input name="tax_input[post_tag][]" type="hidden" value="'.$value->name.'" />';
            }
        }
        echo '</div>';

        echo '</div>';

    }

}




function rudr_post_tags_meta_box_remove() {
    $id = 'tagsdiv-post_tag'; // you can find it in a page source code (Ctrl+U)
    $post_type = 'post'; // remove only from post edit screen
    $position = 'side';
    remove_meta_box( $id, $post_type, $position );
}
add_action( 'admin_menu', 'rudr_post_tags_meta_box_remove');
new CustomPostTagMetabox();

if (!current_user_can('administrator')) {
    add_filter( 'post_row_actions', 'my_disable_quick_edit', 10, 2 );
    function my_disable_quick_edit( $actions = array(), $post = null ) {
        // Remove the Quick Edit link
        if ( isset( $actions['inline hide-if-no-js'] ) ) {
            unset( $actions['inline hide-if-no-js'] );
        }
        // Return the set of links without Quick Edit
        return $actions;
    }
}