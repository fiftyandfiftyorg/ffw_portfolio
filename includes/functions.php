<?php
/**
 * Admin Plugins
 *
 * @package     Donately
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