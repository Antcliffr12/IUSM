<?php

add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { ?>
<h3><?php _e("Extra profile information", ""); ?></h3>

<table class="form-table">
    <tr>
        <th><label for="job_title"><?php _e("Position"); ?></label></th>
        <td>
            <input type="text" name="job_title" id="job_title" value="<?php echo esc_attr( get_the_author_meta( 'job_title', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter your title."); ?></span>
        </td>
    </tr>
    <tr>
        <th><label for="iu_personal_id"><?php _e("Personal ID"); ?></label></th>
        <td>
            <input type="text" name="iu_personal_id" id="iu_personal_id" value="<?php echo esc_attr( get_the_author_meta( 'iu_personal_id', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter your Personal ID."); ?></span>
        </td>
    </tr>
</table>
<?php }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }

    update_user_meta( $user_id, 'job_title', $_POST['job_title'] );
    update_user_meta( $user_id, 'iu_personal_id', $_POST['iu_personal_id'] );

}