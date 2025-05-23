<?php
/**
 * Custom post type providers
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Register 'Providers' (now termed 'Associates') custom post type
function register_provider_post_type() {

    $args = array(
        'public'              => true,
        'label'               => 'Providers',
        'menu_position'       => 2,
        'supports'            => array('title', 'editor', 'custom-fields'),
        'map_meta_cap'        => true,
        'menu_icon'           => 'dashicons-location-alt',
        'show_in_rest'        => true, 
        'has_archive'         => false,
        'rewrite'             => array(
            'slug' => 'providers', 
            'with_front' => false, 
        ),
    );

    register_post_type('providers', $args);
}

add_action('init', 'register_provider_post_type');