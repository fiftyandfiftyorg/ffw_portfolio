<?php
/**
 * Thickbox
 *
 * @package     EDD
 * @subpackage  Admin
 * @copyright   Copyright (c) 2013, Pippin Williamson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function ffw_staff_media_button() {
    global $pagenow, $typenow, $wp_version;
    $output = '';

    /** Only run in post/page creation and edit screens */
    if ( in_array( $pagenow, array( 'admin.php', 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
        /* check current WP version */
        if ( version_compare( $wp_version, '3.5', '<' ) ) {
            $img = '<img src="' . FFW_STAFF_PLUGIN_URL . 'assets/images/ffw_staff-media.png" alt="' . __( 'Insert Image', 'ffw_staff' ) . '"/>';
            $output = '<a href="#TB_inline?width=640&inlineId=choose-download" class="thickbox" title="' . __( 'Insert Media', 'ffw_staff' ) . '">' . $img . '</a>';
        } else {
            $img = '<span class="wp-media-buttons-icon" id="edd-media-button"></span>';
            $output = '<a href="#TB_inline?width=640&inlineId=choose-download" class="thickbox button" title="' . __( 'Insert Media', 'ffw_staff' ) . '" style="padding-left: .4em;">' . $img . __( 'Insert Media', 'fw_staff' ) . '</a>';
        }
    }
    echo $output;
}
add_action( 'media_buttons', 'ffw_staff_media_button', 11 );