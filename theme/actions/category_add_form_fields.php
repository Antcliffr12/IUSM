<?php

add_action ( 'category_add_form_fields', 'extra_category_fields_add_new_meta_field', 10, 2);

function extra_category_fields_add_new_meta_field() {

    wp_nonce_field( 'category_banner_image_data', 'category_banner_nonce' );
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="cat_banner_image"><?php _e('Category Banner Image'); ?></label></th>
        <td>
            <input type="text" name="cat_banner_image" id="cat_banner_image" class="meta-image"><br />
            <input type="button" id="" class="button meta-image-button" value="<?php _e( 'Choose or Upload an Image', '' )?>" /><br />
            <span class="description"><?php _e('Banner Image for category '); ?></span>
        </td>
    </tr>
    <?php
}



add_action( 'category_edit_form_fields', 'extra_category_fields_edit_meta_field', 10, 2 );

function extra_category_fields_edit_meta_field( $tag ) {

    wp_nonce_field( 'category_banner_image_data', 'category_banner_nonce' );

    $t_id = $tag->term_id;
    $cat_image = get_option( "category_banner_image_$t_id");
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="cat_banner_image"><?php _e('Category Banner Image'); ?></label></th>
        <td>
            <input type="text" name="cat_banner_image" id="cat_banner_image" class="meta-image" value="<?php echo $cat_image ? $cat_image : ''; ?>">
            <input type="button" class="button meta-image-button" value="<?php _e( 'Choose or Upload an Image', '' )?>" />
            <input type="button" class="meta-image-remove-image button" value="<?php _e( 'Remove Image', '')?>" />
            <br /><span class="description"><?php _e('Banner Image for category '); ?></span>
        </td>
    </tr>
    <?php
}



add_action( 'edited_category', 'save_extra_category_fields', 10, 2 );
add_action( 'create_category', 'save_extra_category_fields', 10, 2 );


function save_extra_category_fields( $term_id ) {


    if ( ! isset( $_POST['category_banner_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['category_banner_nonce'], 'category_banner_image_data' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_page', $term_id ) ) {
        return;
    }


    if( isset($_POST['cat_banner_image'])) {

        $t_id = $term_id;
        $cat_image = get_option("category_banner_image_$t_id");

        $cat_image = $_POST['cat_banner_image'];

        //save the option array
        update_option("category_banner_image_$t_id", $cat_image);
    }

}
