<?php
/*
Plugin Name: Event Manager
Description: A WordPress plugin for managing events.
Version: 1.0
Author: Kanchana Fernando
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * List of JavaScript / CSS files for admin
 */
 
add_action('admin_init', 'em_scripts');
add_action('init', 'em_register_post_type');

	
/**
 * List of JavaScript / CSS files for admin
 */

if (!function_exists('em_scripts')) {
    function em_scripts() {
        if (is_admin()) {
			wp_register_style('admin.display.css', plugin_dir_url( __FILE__ ) . '/css/admin.display.css');
			wp_enqueue_style('admin.display.css');
		 
			wp_enqueue_script('jquery');
			
			wp_register_script('admin.script.js', plugin_dir_url( __FILE__ ) . '/js/admin.script.js');
			wp_enqueue_script('admin.script.js');

            // Enqueue jQuery UI Datepicker
            wp_enqueue_script( 'jquery-ui-datepicker' );
            wp_enqueue_style( 'jquery-ui-datepicker-style', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
        }
    }
}


//Adding stylesheet for front-end display

add_action('wp_enqueue_scripts', 'em_styles');
function em_styles() {
    wp_register_style('events-display', plugin_dir_url( __FILE__ ) . 'css/display-events.css');
	wp_register_style('em-layout', plugin_dir_url( __FILE__ ) . 'css/em-layout.css');
	wp_enqueue_style('events-display');
	wp_enqueue_style('em-layout');
}


/**
 * Activation Hook for Events Display
 */

function em_activation() {
}
register_activation_hook(__FILE__, 'em_activation');


/**
 * Deactivation Hook for Events Display
 */
 
function em_deactivation() {
}
register_deactivation_hook(__FILE__, 'em_deactivation');

/**
 * Creating event Custom Post Type
 */

function em_register_post_type() {
    $labels = array(
        'name'               => 'Events',
        'singular_name'      => 'Event',
        'menu_name'          => 'Event Manager',
        'name_admin_bar'     => 'Event',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Event',
        'edit_item'          => 'Edit Event',
        'view_item'          => 'View Event',
        'all_items'          => 'All Events',
        'search_items'       => 'Search Events',
        'parent_item_colon'  => 'Parent Events:',
        'not_found'          => 'No events found.',
        'not_found_in_trash' => 'No events found in Trash.'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'event' ),
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array( 'title', 'editor' , 'custom-fields','thumbnail'),
        'menu_icon'           => 'dashicons-calendar-alt'
    );

    register_post_type( 'event', $args );
}

/**
 * Include front-end shortcode functionality
 */
require_once plugin_dir_path( __FILE__ ) . '/em-shortcode.php';

// Include admin functionality
require_once plugin_dir_path( __FILE__ ) . '/em-admin.php';





