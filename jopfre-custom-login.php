<?php
/*
Plugin Name: Jopfre Custom Login
Plugin URI: 
Description: 
Version: 
Author: jopfre
Author 
License: 
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function jcl_stylesheet() {
  $plugin_url = plugin_dir_url( __FILE__ );
  wp_enqueue_style( 'jcl-login', $plugin_url . 'jcl-login.min.css' );
  // wp_enqueue_script( 'jcl-login-script', $plugin_url . 'jcl-login.js', array(''), '1', true );
}
add_action( 'login_enqueue_scripts', 'jcl_stylesheet' );

function jcl_login_head() {
  function jcl_username_label( $translated_text, $text, $domain ) {
    if ( 'Lost your password?' === $text ) {
      $translated_text = __( 'Forgot your password?' , 'jcl-theme' );
    }
    return $translated_text;
  }
  add_filter( 'gettext', 'jcl_username_label', 20, 3 );
  
  $plugin_url = plugin_dir_url( __FILE__ );
  echo '<img id="vodafone-logo" src="'.$plugin_url.'img/vodafone-logo.svg">';
}
add_action( 'login_head', 'jcl_login_head' );

function jcl_login_logo_url() {
  return home_url();
}
add_filter( 'login_headerurl', 'jcl_login_logo_url' );

function jcl_login_logo_url_title() {
  return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'jcl_login_logo_url_title' );

function jcl_login_footer() {
  the_custom_logo();
  echo '<script>
    document.querySelector("#user_login").placeholder="Username/Email";
    document.querySelector("#user_pass").placeholder="Password";
  </script>';
//   get_template_part( 'template-parts/footer'); 
//   get_template_part( 'template-parts/modals/reset-pass'); 
}
add_action('login_footer', 'jcl_login_footer');


function redirect_non_admin_users() {
  if ( ! current_user_can( 'edit_posts' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
    wp_redirect( home_url() );
    exit;
  }
}
add_action( 'admin_init', 'redirect_non_admin_users' );
?>