<?php
/**
 * Plugin Name: Admin Dashboard Last Edits
 * Plugin URI: http://wpdoc.de/plugins/
 * Description: Easy and lightweight solution for showing the last edited posts and pages on the admin dashboard.
 * Version: 1.1 
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
 * @todo Add option to show only posts or pages   
 */ 
  
  if ( $posts ) {
    $date_format = get_option( 'date_format' );
    echo '<ul>';
    foreach ( $posts as $post ) {
      printf( __( '<li><a href="%1$s" title="Edit %3$s"><span class="dashicons dashicons-edit"></span></a> <a href="%2$s" title="View %3$s on website">%3$s</a> <small>%4$s</small>', 'admin-dashboard-last-edits' ), esc_html( get_edit_post_link( $post->ID ) ), esc_html( get_permalink( $post->ID ) ), esc_html( $post->post_title ), esc_html( get_post_modified_time( $date_format, false, $post->ID, true )) ); 
    }
    echo '</ul>';
  }
  
  else {
    printf( __( 'No edits found. <a href="%1$s">Write a new post</a>.', 'admin-dashboard-last-edits' ), esc_url( admin_url( 'post-new.php' ) ) );
  }
  
}

?>