<?php
/**
 * Admin Plugins
 *
 * @package     Portfolio
 * @subpackage  Admin/Plugins
 * @copyright   Copyright (c) 2013, Fifty and Fifty
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.8
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add a URL to the Plugin Actions menu
 * 
 * @param array $links already defined action links
 * @param string $file plugin file path and name being processed
 * @return [array] a new settings link
 */
function ffw_port_plugin_action_links( $links, $file ) {
    $settings_link = '<a href="' . admin_url( 'admin.php?page=ffw-port-settings' ) . '">' . esc_html__( 'Settings', 'dntly' ) . '</a>';
    if ( $file == 'ffw-portfolio/ffw-portfolio.php' )
        array_unshift( $links, $settings_link );

    return $links;
}
add_filter( 'plugin_action_links', 'ffw_port_plugin_action_links', 10, 2 );



function ffw_port_disable_link()
{
    global $ffw_port_settings;

   $ffw_port_disable = isset( $ffw_port_settings['port_disable_link_to_single'] ) ? true : false;

   return $ffw_port_disable;
    
}


/**
 * Allow the ability to set posts_per_page on the archive template from the admin area. BOOM!
 * 
 * @param  [type] $query [description]
 * @return [type]        [description]
 */
function ffw_port_adjust_posts_per_page( $query ) {
    
    global $ffw_port_settings;

    if ( is_admin() || ! $query->is_main_query() )
        return;

    if ( is_post_type_archive( 'ffw_portfolio' ) ) {
        // Display 50 posts for a custom post type called 'movie'
        
        $ffw_port_posts_per_page = isset( $ffw_port_settings['port_posts_per_page'] ) ? $ffw_port_settings['port_posts_per_page'] : 100;
        
        $query->set( 'posts_per_page', $ffw_port_posts_per_page );
        
        return;
    }
}
add_action( 'pre_get_posts', 'ffw_port_adjust_posts_per_page', 1 );