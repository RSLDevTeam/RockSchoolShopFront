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
        'supports'            => array('title', 'editor', 'custom-fields', 'revisions'),
        'map_meta_cap'        => true,
        'menu_icon'           => 'dashicons-location-alt',
        'show_in_rest'        => true, 
        'has_archive'         => false,
        'rewrite'             => array(
            'slug' => 'providers', 
            'with_front' => false, 
        ),
        'capability_type'     => 'post',
    );

    register_post_type('providers', $args);
}

add_action('init', 'register_provider_post_type');


// Enable Revision box for Providers
function add_provider_revisions_metabox() {
    add_meta_box(
        'revisionsdiv',
        __('Revisions'),
        'post_revisions_meta_box',
        'providers',
        'normal',
        'core'
    );
}
add_action('add_meta_boxes', 'add_provider_revisions_metabox');


//Add Revisions Link to Custom Post Type in Admin Table
function add_revisions_column_to_providers( $columns ) {
    $columns['revisions_count'] = 'Revisions';
    return $columns;
}
add_filter( 'manage_providers_posts_columns', 'add_revisions_column_to_providers' );

function show_revisions_column_content( $column, $post_id ) {
    if ( $column === 'revisions_count' ) {
        $revisions = wp_get_post_revisions( $post_id );
        $count = count( $revisions );
        if ( $count > 0 ) {
            $link = get_edit_post_link( $post_id ) . '#revisions';
            echo '<a href="' . esc_url( $link ) . '">' . sprintf( __( '%d Revisions' ), $count ) . '</a>';
        } else {
            echo '–';
        }
    }
}
add_action( 'manage_providers_posts_custom_column', 'show_revisions_column_content', 10, 2 );

/**
 * Track when provider posts are published
 */
function track_provider_publication($new_status, $old_status, $post) {
    if ($post->post_type !== 'providers' || $new_status !== 'publish') {
        return;
    }

    // Get the most recent revision before this publish action
    $revisions = wp_get_post_revisions($post->ID, [
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC'
    ]);
    
    if (!empty($revisions)) {
        $latest_revision = reset($revisions);
        
        // Mark this revision as the published version
        update_post_meta($latest_revision->ID, 'is_published_revision', '1');
        update_post_meta($latest_revision->ID, 'published_post_id', $post->ID);
        update_post_meta($latest_revision->ID, 'published_at', current_time('mysql'));
        
        // Also store revision ID in the published post
        update_post_meta($post->ID, 'last_published_revision', $latest_revision->ID);
    }
}
add_action('transition_post_status', 'track_provider_publication', 10, 3);


/**
 * Allow access to pending provider posts
 */
function allow_access_to_pending_providers($query) {
    if (
        !is_admin() &&
        $query->is_main_query() &&
        isset($query->query_vars['post_type']) &&
        $query->query_vars['post_type'] === 'providers'
    ) {
        $query->set('post_status', ['publish', 'pending']);
    }
    //wp_die(print_r($query));
}
add_action('pre_get_posts', 'allow_access_to_pending_providers');


/**
 * Get the last published content for a provider
 */
function get_last_published_provider_content($post_id) {
    // Check if we have a direct published revision reference
    $last_pub_rev_id = get_post_meta($post_id, 'last_published_revision', true);
    
    if ($last_pub_rev_id) {
        $revision = get_post($last_pub_rev_id);
        if ($revision) {
            return $revision;
        }
    }
    
    // Fallback: Find the most recent published revision
    $revisions = wp_get_post_revisions($post_id, [
        'meta_key' => 'is_published_revision',
        'meta_value' => '1',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC'
    ]);
    
    if (!empty($revisions)) {
        return reset($revisions);
    }
    
    // Final fallback: return the current post
    return get_post($post_id);
}