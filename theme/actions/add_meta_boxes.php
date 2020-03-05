<?php

abstract class IUSM_Metaboxes{
    public function __construct()
    {
        add_action( 'add_meta_boxes', [$this, 'add_metabox'], 10, 2 );
        add_action( 'save_post', [$this, 'save_metabox'] );
    }

    abstract public function add_metabox();
    abstract public function output_box($post);
    abstract public function save_metabox($post_id);
}

abstract class MediaContact{
  public function __construct()
  {
    add_action('add_tag_form_fields', [$this, 'add_tag_form_fields']);
    add_action('edit_tag_form_fields', [$this, 'edit_form_fields']);
    add_action('edit_term', [$this, 'save_termmeta_tag']);
  }

  abstract public function edit_form_fields($term);
  abstract public function save_termmeta_tag($term_id);

}

class GetMediaContacts extends MediaContact{

  public function edit_form_fields($term){
    $name = get_term_meta( $term->term_id, '_contact-name', true);
    $name = (!empty($name)) ? $name : 'IU School of Medicine';

    $campus = get_term_meta( $term->term_id, '_contact-campus', true);
    $campus = (!isset($campus) || empty($campus)) ? 'Indianapolis' : $campus;


    $email = get_term_meta( $term->term_id, '_contact-email', true);
    $email = (!empty($email)) ? $email : 'iusm@iu.edu';

    $phone = get_term_meta( $term->term_id, '_contact-phone', true);
    $phone = (!empty($phone)) ? $phone : '3172748157';

    $formatted_number = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $phone);

    ?>
    <tr class="form-field term-contacts-wrap">
      <th scope="row">
        <label for="term-name">Name</label>
      </th>
      <td>
        <input type="text" name="_contact-name" value="<?= $name ?>" class="term-contacts" id="term-name" />
      </td>
    </tr>

    <tr class="form-field term-contacts-wrap">
      <th scope="row">
        <label for="term-campus">Campus</label>
      </th>
      <td>
        <select name="_contact-campus" id="term-campus">
            <?php
                $get_campus = $this->Campuses();
                foreach($get_campus as $key=>$value){
                    $selected = $campus === $value ? ' selected="selected"' : '';
                    ?>
                        <option value="<?= $value ?>"<?= $selected ?>><?= $key ?></option>
                    <?php
                }
            ?>
        </select>
       </td>
    </tr>

    <tr class="form-field term-contacts-wrap">
      <th scope="row">
        <label for="term-email">Email</label>
      </th>
      <td>
        <input type="text" name="_contact-email" value="<?= $email ?>" class="term-contacts" id="term-email" />
      </td>
    </tr>

    <tr class="form-field term-contacts-wrap">
      <th scope="row">
        <label for="term-phone">Phone</label>
      </th>
      <td>
        <input type="text" name="_contact-phone" value="<?= $formatted_number ?>" class="term-contacts" id="term-phone" />
      </td>
    </tr>


    <?php
  }
  public function save_termmeta_tag($term_id){

    if(isset($_POST['_contact-name']) && !empty($_POST['_contact-name'])){
      update_term_meta($term_id, '_contact-name', sanitize_text_field( $_POST['_contact-name']));
    }else{
      delete_term_meta($term_id, '_contact-name');
    }

    if(isset($_POST['_contact-campus']) && !empty($_POST['_contact-campus'])){
      update_term_meta($term_id, '_contact-campus', sanitize_text_field( $_POST['_contact-campus']));
    }else{
      delete_term_meta($term_id, '_contact-campus');
    }

    if(isset($_POST['_contact-email']) && !empty($_POST['_contact-email'])){
      update_term_meta($term_id, '_contact-email', sanitize_text_field( $_POST['_contact-email']));
    }else{
      delete_term_meta($term_id, '_contact-email');
    }

    if(isset($_POST['_contact-phone']) && !empty($_POST['_contact-phone'])){
      update_term_meta($term_id, '_contact-phone', sanitize_text_field( $_POST['_contact-phone']));
    }else{
      delete_term_meta($term_id, '_contact-phone');
    }


  }

  private function Campuses(){
    return [
      __('None', '') => '',
      __('Bloomington', '') => 'Bloomington',
      __('Evansville', '') => 'Evansville',
      __('Fort Wayne', '') => 'Fort Wayne',
      __('Gary', '') => 'Gary',
      __('Indianapolis', '') => 'Indianapolis',
      __('Muncie', '') => 'Muncie',
      __('South Bend', '') => 'South Bend',
      __('Terre Haute', '') => 'Terre Haute',
      __('West Lafayette', '') => 'West Lafayette',
    ];
  }
}
new GetMediaContacts();


class ContactMediaBox extends IUSM_Metaboxes {
  private $postType = [ 'post'];

  public function add_metabox(){
      foreach($this->postType as $type) {
        add_meta_box('media-contact-metabox', __('Media Contact', ''), [$this, 'output_box'], $type, 'normal', 'high');
      }
  }

  public function output_box($post){
    wp_nonce_field( 'media_contact_save_metabox_data', 'media_contact_metabox_nonce' );

    $name = get_post_meta( $post->ID, '_contact-name', true);
    $name = (!empty($name)) ? $name : 'IU School of Medicine';

    $campus = get_post_meta( $post->ID, '_contact-campus', true);
    $campus = (!isset($campus) || empty($campus)) ? 'Indianapolis' : $campus;


    $email = get_post_meta( $post->ID, '_contact-email', true);
    $email = (!empty($email)) ? $email : 'iusm@iu.edu';

    $phone = get_post_meta( $post->ID, '_contact-phone', true);
    $phone = (!empty($phone)) ? $phone : '3172748157';

    $formatted_number = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $phone);

      ob_start();
      ?>

      <tr class="form-field term-contacts-wrap">
        <th scope="row">
          <label for="term-name">Name</label>
        </th>
        <td>
          <input type="text" name="_contact-name" value="<?= $name ?>" class="term-contacts" id="term-name" />
        </td>
      </tr>

      <tr class="form-field term-contacts-wrap">
        <th scope="row">
          <label for="term-campus">Campus</label>
        </th>
        <td>
          <select name="_contact-campus" id="term-campus">
              <?php
                  $get_campus = $this->Campuses();
                  foreach($get_campus as $key=>$value){
                      $selected = $campus === $value ? ' selected="selected"' : '';
                      ?>
                          <option value="<?= $value ?>"<?= $selected ?>><?= $key ?></option>
                      <?php
                  }
              ?>
          </select>
         </td>
      </tr>

      <tr class="form-field term-contacts-wrap">
        <th scope="row">
          <label for="term-email">Email</label>
        </th>
        <td>
          <input type="text" name="_contact-email" value="<?= $email ?>" class="term-contacts" id="term-email" />
        </td>
      </tr>

      <tr class="form-field term-contacts-wrap">
        <th scope="row">
          <label for="term-phone">Phone</label>
        </th>
        <td>
          <input type="text" name="_contact-phone" value="<?= $formatted_number ?>" class="term-contacts" id="term-phone" />
        </td>
      </tr>
      <?php
      ob_end_flush();
  }

  public function save_metabox($post_id){
    if ( ! isset( $_POST['media_contact_metabox_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['media_contact_metabox_nonce'], 'media_contact_save_metabox_data' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( isset( $_POST['post_type'] ) && $this->postType == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }
    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }


    if(isset($_POST['_contact-name']) && !empty($_POST['_contact-name'])){
      update_post_meta($post_id, '_contact-name', sanitize_text_field( $_POST['_contact-name']));
    }


    if(isset($_POST['_contact-campus']) && !empty($_POST['_contact-campus'])){
      update_post_meta($post_id, '_contact-campus', sanitize_text_field( $_POST['_contact-campus']));
    }

    if(isset($_POST['_contact-email']) && !empty($_POST['_contact-email'])){
      update_post_meta($post_id, '_contact-email', sanitize_text_field( $_POST['_contact-email']));
    }

    if(isset($_POST['_contact-phone']) && !empty($_POST['_contact-phone'])){
      update_post_meta($post_id, '_contact-phone', sanitize_text_field( $_POST['_contact-phone']));
    }


  }

  private function Campuses(){
    return [
      __('None', '') => '',
      __('Bloomington', '') => 'Bloomington',
      __('Evansville', '') => 'Evansville',
      __('Fort Wayne', '') => 'Fort Wayne',
      __('Gary', '') => 'Gary',
      __('Indianapolis', '') => 'Indianapolis',
      __('Muncie', '') => 'Muncie',
      __('South Bend', '') => 'South Bend',
      __('Terre Haute', '') => 'Terre Haute',
      __('West Lafayette', '') => 'West Lafayette',
    ];
  }

}

new ContactMediaBox();

class SectionLevelBanner extends  IUSM_Metaboxes {

    private $postType = ['page','post'];

    public function add_metabox(){
        foreach($this->postType as $type) {
	        add_meta_box('section-level-metabox', __('Section Banner', ''), [$this, 'output_box'], $type, 'normal', 'high');
        }
    }

    private function Background_Colors(){
        return [
            __('None', '') => '',
            __('White', '') => 'bg-white',
            __('IU Dark Crimson', '') => 'bg-iu-dark-crimson',
            __('IU Crimson', '') => 'bg-iu-crimson',
            __('IU Cream', '') => 'bg-iu-cream',
            __('IU Dark Gold', '') => 'bg-iu-dark-gold',
            __('IU Gold', '') => 'bg-iu-gold',
            __('IU Dark Mint', '') => 'bg-iu-dark-mint',
            __('IU Mint', '') => 'bg-iu-mint',
            __('IU Dark Midnight', '') => 'bg-iu-dark-midnight',
            __('IU Midnight', '') => 'bg-iu-midnight',
            __('IU Dark Majestic', '') => 'bg-iu-dark-majestic',
            __('IU Majestic', '') => 'bg-iu-majestic',
            __('IU Dark Limestone', '') => 'bg-iu-dark-limestone',
            __('IU Limestone', '') => 'bg-iu-limestone',
            __('IU Black', '') => 'bg-iu-black',
            __('IU Mahogany', '') => 'bg-iu-mahogany',
        ];
    }

    private function Font_Colors(){
        return [
	        __('None', '') => '',
	        __('White', '') => 'color-white',
	        __('IU Dark Crimson', '') => 'color-iu-dark-crimson',
	        __('IU Crimson', '') => 'color-iu-crimson',
	        __('IU Cream', '') => 'color-iu-cream',
	        __('IU Dark Gold', '') => 'color-iu-dark-gold',
	        __('IU Gold', '') => 'color-iu-gold',
	        __('IU Dark Mint', '') => 'color-iu-dark-mint',
	        __('IU Mint', '') => 'color-iu-mint',
	        __('IU Dark Midnight', '') => 'color-iu-dark-midnight',
	        __('IU Midnight', '') => 'color-iu-midnight',
	        __('IU Dark Majestic', '') => 'color-iu-dark-majestic',
	        __('IU Majestic', '') => 'color-iu-majestic',
	        __('IU Dark Limestone', '') => 'color-iu-dark-limestone',
	        __('IU Limestone', '') => 'color-iu-limestone',
	        __('IU Black', '') => 'color-iu-black',
	        __('IU Mahogany', '') => 'color-iu-mahogany',
        ];
    }

    public function output_box($post){
        wp_nonce_field( 'sb_save_metabox_data', 'sb_metabox_nonce' );
        $bannerText = get_post_meta( $post->ID, 'sb_section_level_banner', true );
        $bannerTitleDisplay = get_post_meta( $post->ID, 'sb_title_display', true );
        $bannerBg = get_post_meta( $post->ID, 'sb_section_level_bg_color', true );
	    $bannerImage = get_post_meta( $post->ID, 'meta-image', true );
        $bannerBg = (!isset($bannerBg) || empty($bannerBg)) ? 'bg-iu-crimson' : $bannerBg;

	    $fontColor = get_post_meta( $post->ID, 'sb_section_level_font_color', true );
	    $fontColor = (!isset($fontColor) || empty($fontColor)) ? 'color-white' : $fontColor;

        ob_start();
        ?>
        <div style="float:none;clear:both;">
            <div id="section-level-banner-title" style="float:left; margin-right:25px;">
                <label for="sb_section_level_banner" style="font-weight:bold;">Banner Text:</label><br />
                <input type="text" id="sb_section_level_banner" name="sb_section_level_banner" value="<?= esc_attr( $bannerText ) ?>" size="55" />
            </div>
            <div id="section-banner-title-display" style="float:left; margin-right:25px;">
                <?php

                if(empty($bannerTitleDisplay)){
                    $bannerTitleDisplay = get_post_type() == 'post' ? 'post' : 'normal';
                }

                ?>
                <label data-display="<?= $bannerTitleDisplay ?>" style="font-weight:bold;display:block;">Title Display:</label><br />
                <input type="radio" name="sb_title_display" value="normal" <?php if($bannerTitleDisplay == 'normal') echo 'checked="checked"'; ?>/>Normal
                <input style="margin-left:15px;" type="radio" name="sb_title_display" value="post" <?php if($bannerTitleDisplay == 'post') echo 'checked="checked"'; ?>/>Post Title
            </div>
        </div>

        <div style="clear:both"></div>
        <div style="float:left; margin-right:25px;margin-top:12px;">
            <label for="sb_section_level_font_color" style="font-weight:bold;">Text Color:</label><br />
            <select name="sb_section_level_font_color">
			    <?php
			    $colors = $this->Font_Colors();
			    foreach($colors as $key=>$value){
				    $selected = $fontColor === $value ? ' selected="selected"' : '';
				    ?>
                    <option value="<?= $value ?>"<?= $selected ?>><?= $key ?></option>
				    <?php
			    }
			    ?>
            </select>
        </div>
        <div style="float:left; margin-right:25px;margin-top:12px;">
            <label for="sb_section_level_bg_color" style="font-weight:bold;">Background Color:</label><br />
            <select name="sb_section_level_bg_color">
                <?php
                    $bgColors = $this->Background_Colors();
                    foreach($bgColors as $key=>$value){
                        $selected = $bannerBg === $value ? ' selected="selected"' : '';
                        ?>
                            <option value="<?= $value ?>"<?= $selected ?>><?= $key ?></option>
                        <?php
                    }
                ?>
            </select>
        </div>
        <div class="meta-image-cont" style="clear:both; margin:20px 0; float:left;">
            <label for="meta-image" style="font-weight:bold;display:block;"><?php _e( 'Image File Upload:', '' )?></label>
            <input type="text" name="meta-image" id="meta-image" class="meta-image" value="<?= $bannerImage ?>" />
            <input type="button" class="button meta-image-button" value="<?php _e( 'Choose or Upload an Image', '' )?>" />
        </div>
        <div style="clear:both;"></div>
        <span style="margin-left:5px">Adds a Banner above the breadcrumbs and below any banner slider.</span>

        <?php
        ob_end_flush();
    }

    public function save_metabox($post_id){

        if ( ! isset( $_POST['sb_metabox_nonce'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['sb_metabox_nonce'], 'sb_save_metabox_data' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST['post_type'] ) && $this->postType == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            }
        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        $bannerText = sanitize_text_field( $_POST['sb_section_level_banner'] );
        $bannerTitleDisplay = sanitize_text_field( $_POST['sb_title_display'] );
        $bannerBackground = sanitize_text_field( $_POST['sb_section_level_bg_color']);
	    $bannerFontColor = sanitize_text_field( $_POST['sb_section_level_font_color']);
	    $bannerImage = sanitize_text_field( $_POST['meta-image']);
            update_post_meta( $post_id, 'sb_section_level_banner', $bannerText );
            update_post_meta( $post_id, 'sb_title_display', $bannerTitleDisplay);
            update_post_meta( $post_id, 'sb_section_level_bg_color', $bannerBackground );
            update_post_meta( $post_id, 'sb_section_level_font_color', $bannerFontColor);
	        update_post_meta( $post_id, 'meta-image', $bannerImage);
    }
}
new SectionLevelBanner();


class DisplayBreadcrumbs extends  IUSM_Metaboxes{

    private $postType = 'page';

    public function add_metabox(){
        add_meta_box('display-breadcrumbs',__( 'Breadcrumb Display', '' ),[$this, 'output_box'],$this->postType, 'side', 'high');
    }

    public function output_box($post){
        wp_nonce_field( 'bc_save_metabox_data', 'bc_metabox_nonce' );
        $value = get_post_meta( $post->ID, 'hide_breadcrumb', true );
        $default = (!empty($value) && $value === 'on') ? ' checked' : '';
            $output = '<div id="breadcrumbBox">';
            $output .= '<input name="hide_breadcrumb" type="checkbox" style="margin-top:1px;"'. $default .' />';
            $output .= '<label for="hide_breadcrumb" style="margin-left:3px;">Hide breadcrumb for page.</label>';
            $output .= '</div>';

            echo $output;
    }

    public function save_metabox($post_id){

        if ( ! isset( $_POST['bc_metabox_nonce'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['bc_metabox_nonce'], 'bc_save_metabox_data' ) ) {
            return;
        }


        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }


        if ( isset( $_POST['post_type'] ) && $this->postType == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            }
        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        $bannerText = sanitize_text_field( $_POST['hide_breadcrumb'] );
        update_post_meta( $post_id, 'hide_breadcrumb', $bannerText );
    }
}
new DisplayBreadcrumbs();


class FeaturedPosts extends IUSM_Metaboxes{

	private $postType = 'post';

	public function add_metabox()
	{
    if(current_user_can(('contentpublisher'))){
      add_meta_box('featured-posts',__( 'Add as Featured Post', '' ),[$this, 'output_box'],$this->postType, 'side', 'default');
    }
	}

	public function output_box($post)
	{
		wp_nonce_field( 'featured_save_metabox_data', 'featured_metabox_nonce' );
		$value = get_post_meta( $post->ID, 'featured_checkbox', true );
		$default = (!empty($value) && $value === 'on') ? ' checked' : '';
		$output = '<div id="featuredBox">';
		$output .= '<input name="featured_checkbox" type="checkbox" style="margin-top:1px;"'. $default .' />';
		$output .= '<label for="featured_checkbox" style="margin-left:3px;">Featured Post</label>';
		$output .= '</div>';
		echo $output;
	}

	public function save_metabox($post_id)
	{
		if ( ! isset( $_POST['featured_metabox_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['featured_metabox_nonce'], 'featured_save_metabox_data' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}


		if ( isset( $_POST['post_type'] ) && $this->postType == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		$featured_checkbox = sanitize_text_field( $_POST['featured_checkbox'] );
		update_post_meta( $post_id, 'featured_checkbox', $featured_checkbox );
	}
}
new FeaturedPosts();
