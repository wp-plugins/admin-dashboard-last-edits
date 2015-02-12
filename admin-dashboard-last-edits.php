<?php
/**
 * Plugin Name: Admin Dashboard Last Edits
 * Plugin URI: http://wpdoc.de/plugins/
 * Description: Easy and lightweight solution for showing the last edited posts on the admin dashboard.
 * Version: 1.0 
 * Author: Johannes Ries
 * Author URI: http://wpdoc.de
 * Text Domain: admin-dashboard-last-edits
 * License: GPL-2.0 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

/**
 * Avoid direct calls
*/
defined('ABSPATH') or die("No direct requests for security reasons."); 

/**
 * Localization
*/
load_plugin_textdomain( 'admin-dashboard-last-edits', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 

/**
 * Register Admin Widget
*/ 

add_action( 'wp_dashboard_setup', 'admin_dashboard_last_edits_register' );

function admin_dashboard_last_edits_register() {
  wp_add_dashboard_widget(
  __FUNCTION__, __( 'Recently edited posts', 'admin-dashboard-last-edits' ), 'admin_dashboard_last_edits_dashboard_widget');
}

function admin_dashboard_last_edits_dashboard_widget() { 
  $posts = get_posts(
  array (
    'numberposts' => 10, 
    'post_type' => array ( 'post', 'page' ), 
    'orderby' => 'modified')
    );

/**
 * @todo Icons for post formats
 * @todo Add option to configure how many posts should be shown 
 */ 
  
  if ( $posts ) {
    echo '<ul>';
    foreach ( $posts as $post ) { 
      printf('<li>&raquo; <a href="%1$s">%2$s</a></li>', esc_html( get_permalink( $post->ID )), esc_html( $post->post_title )); 
    }
    echo '</ul>';
  }
  
  else {
    printf( __( 'No edits found. <a href="%1$s">Write a new post</a>.', 'admin-dashboard-last-edits' ), esc_url( admin_url( 'post-new.php' ) ) );
  }
  
}

?>