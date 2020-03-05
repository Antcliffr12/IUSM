<?php
/**
 * Template Name:Twice

 */
get_header();
get_template_part('partials/header-content');
?>
<style>
html{
  margin-top:0px !important;
}
#site-bar .main-menu ul{
  display: none !important;
}
</style>

  <div class="container">
    <div id="login">

      <?php
        $args = array(
            'echo'           => true,
            'remember'       => true,
            'redirect' => site_url( '/?wp_cassify_bypass=bypass' ),
            'form_id'        => 'loginform',
            'id_username'    => 'user_login',
            'id_password'    => 'user_pass',
            'id_remember'    => 'rememberme',
            'id_submit'      => 'wp-submit',
            'label_username' => __( 'Username' ),
            'label_password' => __( 'Password' ),
            'label_remember' => __( 'Remember Me' ),
            'label_log_in'   => __( 'Log In' ),
            'value_username' => '',
            'value_remember' => false
        );

        wp_login_form( $args );
      ?>

    </div>
  </div><!-- container -->
