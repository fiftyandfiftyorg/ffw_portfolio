<?php
/**
 * Post Type Functions
 *
 * @package     FFW
 * @subpackage  Functions
 * @copyright   Copyright (c) 2013, Fifty and Fifty
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers and sets up the Downloads custom post type
 *
 * @since 1.0
 * @return void
 */
function setup_ffw_port_post_types() {
    global $ffw_port_settings;

    //$archives = isset( $ffw_port_settings['disable_archive'] ) ? false : true;
    

    if( !isset( $ffw_port_settings['disable_archive'] ) ) {
        $archives = true;
    }else{
        $archives = false;
    }

    $exclude_from_search = isset( $ffw_port_settings['exclude_from_search'] ) ? true : false;



    //Check to see if anything is set in the settings area.
    if( !empty( $ffw_port_settings['port_slug'] ) ) {
        $slug = defined( 'FFW_PORT_SLUG' ) ? FFW_PORT_SLUG : $ffw_port_settings['port_slug'];
    } else {
        $slug = defined( 'FFW_PORT_SLUG' ) ? FFW_PORT_SLUG : 'portfolio';
    }

    $dashicon = isset( $ffw_port_settings['dash_icons'] ) ? $ffw_port_settings['dash_icons'] : 'dashicons-portfolio';
    
    $rewrite  = defined( 'FFW_PORT_DISABLE_REWRITE' ) && FFW_PORT_DISABLE_REWRITE ? false : array('slug' => $slug, 'with_front' => false);

    $port_labels =  apply_filters( 'ffw_port_port_labels', array(
        'name'               => '%2$s',
        'singular_name'      => '%1$s',
        'add_new'            => __( 'Add New', 'ffw_port' ),
        'add_new_item'       => __( 'Add New %1$s', 'ffw_port' ),
        'edit_item'          => __( 'Edit %1$s', 'ffw_port' ),
        'new_item'           => __( 'New %1$s', 'ffw_port' ),
        'all_items'          => __( 'All %2$s', 'ffw_port' ),
        'view_item'          => __( 'View %1$s', 'ffw_port' ),
        'search_items'       => __( 'Search %2$s', 'ffw_port' ),
        'not_found'          => __( 'No %2$s found', 'ffw_port' ),
        'not_found_in_trash' => __( 'No %2$s found in Trash', 'ffw_port' ),
        'parent_item_colon'  => '',
        'menu_name'          => __( '%2$s', 'ffw_port' )
    ) );

    foreach ( $port_labels as $key => $value ) {
       $port_labels[ $key ] = sprintf( $value, ffw_port_get_label_singular(), ffw_port_get_label_plural() );
    }

    $port_args = array(
        'labels'              => $port_labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'exclude_from_search' => $exclude_from_search,
        'menu_position'       => '34.2',
        'menu_icon'           => $dashicon,
        'query_var'           => true,
        'rewrite'             => $rewrite,
        'map_meta_cap'        => true,
        'has_archive'         => $archives,
        'show_in_nav_menus'   => true,
        'hierarchical'        => false,
        'supports'            => apply_filters( 'ffw_port_supports', array( 'title', 'editor', 'thumbnail', 'excerpt' ) ),
    );
    register_post_type( 'ffw_portfolio', apply_filters( 'ffw_port_post_type_args', $port_args ) );
    
}
add_action( 'init', 'setup_ffw_port_post_types', 1 );

/**
 * Get Default Labels
 *
 * @since 1.0.8.3
 * @return array $defaults Default labels
 */
function ffw_port_get_default_labels() {
    global $ffw_port_settings;

    if( !empty( $ffw_port_settings['port_label_plural'] ) || !empty( $ffw_port_settings['port_label_singular'] ) ) {
        $defaults = array(
           'singular' => $ffw_port_settings['port_label_singular'],
           'plural' => $ffw_port_settings['port_label_plural']
        );
     } else {
        $defaults = array(
           'singular' => __( 'Portfolio', 'ffw_port' ),
           'plural' => __( 'Portfolios', 'ffw_port')
        );
    }
    
    return apply_filters( 'ffw_port_default_name', $defaults );

}

/**
 * Get Singular Label
 *
 * @since 1.0.8.3
 * @return string $defaults['singular'] Singular label
 */
function ffw_port_get_label_singular( $lowercase = false ) {
    $defaults = ffw_port_get_default_labels();
    return ($lowercase) ? strtolower( $defaults['singular'] ) : $defaults['singular'];
}

/**
 * Get Plural Label
 *
 * @since 1.0.8.3
 * @return string $defaults['plural'] Plural label
 */
function ffw_port_get_label_plural( $lowercase = false ) {
    $defaults = ffw_port_get_default_labels();
    return ( $lowercase ) ? strtolower( $defaults['plural'] ) : $defaults['plural'];
}

/**
 * Change default "Enter title here" input
 *
 * @since 1.4.0.2
 * @param string $title Default title placeholder text
 * @return string $title New placeholder text
 */
function ffw_port_change_default_title( $title ) {
     $screen = get_current_screen();

     if  ( 'ffw_port' == $screen->post_type ) {
        $label = ffw_port_get_label_singular();
        $title = sprintf( __( 'Enter %s title here', 'ffw_port' ), $label );
     }

     return $title;
}
add_filter( 'enter_title_here', 'ffw_port_change_default_title' );

/**
 * Registers the custom taxonomies for the downloads custom post type
 *
 * @since 1.0
 * @return void
*/
function ffw_port_setup_taxonomies() {

    $slug     = defined( 'FFW_PORT_SLUG' ) ? FFW_PORT_SLUG : 'port';

    /** Categories */
    $category_labels = array(
        'name'              => sprintf( _x( '%s Categories', 'taxonomy general name', 'ffw_port' ), ffw_port_get_label_singular() ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name', 'ffw_port' ),
        'search_items'      => __( 'Search Categories', 'ffw_port'  ),
        'all_items'         => __( 'All Categories', 'ffw_port'  ),
        'parent_item'       => __( 'Parent Category', 'ffw_port'  ),
        'parent_item_colon' => __( 'Parent Category:', 'ffw_port'  ),
        'edit_item'         => __( 'Edit Category', 'ffw_port'  ),
        'update_item'       => __( 'Update Category', 'ffw_port'  ),
        'add_new_item'      => __( 'Add New Category', 'ffw_port'  ),
        'new_item_name'     => __( 'New Category Name', 'ffw_port'  ),
        'menu_name'         => __( 'Categories', 'ffw_port'  ),
    );

    $category_args = apply_filters( 'ffw_port_category_args', array(
            'hierarchical'      => true,
            'labels'            => apply_filters('ffw_port_category_labels', $category_labels),
            'show_ui'           => true,
            'query_var'         => 'port_category',
            'rewrite'           => array('slug' => $slug . '/category', 'with_front' => false, 'hierarchical' => true ),
            'capabilities'      => array( 'manage_terms','edit_terms', 'assign_terms', 'delete_terms' ),
            'show_admin_column' => true
        )
    );
    register_taxonomy( 'port_category', array('ffw_port'), $category_args );
    register_taxonomy_for_object_type( 'port_category', 'ffw_port' );

}
add_action( 'init', 'ffw_port_setup_taxonomies', 0 );



/**
 * Updated Messages
 *
 * Returns an array of with all updated messages.
 *
 * @since 1.0
 * @param array $messages Post updated message
 * @return array $messages New post updated messages
 */
function ffw_port_updated_messages( $messages ) {
    global $post, $post_ID;

    $url1 = '<a href="' . get_permalink( $post_ID ) . '">';
    $url2 = ffw_port_get_label_singular();
    $url3 = '</a>';

    $messages['ffw_port'] = array(
        1 => sprintf( __( '%2$s updated. %1$sView %2$s%3$s.', 'ffw_port' ), $url1, $url2, $url3 ),
        4 => sprintf( __( '%2$s updated. %1$sView %2$s%3$s.', 'ffw_port' ), $url1, $url2, $url3 ),
        6 => sprintf( __( '%2$s published. %1$sView %2$s%3$s.', 'ffw_port' ), $url1, $url2, $url3 ),
        7 => sprintf( __( '%2$s saved. %1$sView %2$s%3$s.', 'ffw_port' ), $url1, $url2, $url3 ),
        8 => sprintf( __( '%2$s submitted. %1$sView %2$s%3$s.', 'ffw_port' ), $url1, $url2, $url3 )
    );

    return $messages;
}
add_filter( 'post_updated_messages', 'ffw_port_updated_messages' );
