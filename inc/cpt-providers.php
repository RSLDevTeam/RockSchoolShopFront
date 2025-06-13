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
 * Track the published revision of provider posts
 */
function track_published_revision($post_id, $post) {
    // Skip if not a provider post or not published
    if ($post->post_type !== 'providers' || $post->post_status !== 'publish') {
        return;
    }

    // Skip autosaves and revisions
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return;
    }

    $revisions = wp_get_post_revisions($post_id);
    
    if (!empty($revisions)) {
        $latest_revision = reset($revisions);
        
        // Store the published post ID in the revision
        update_post_meta($latest_revision->ID, 'published_version', $post_id);
        
        // Also store the revision ID in the published post
        update_post_meta($post_id, 'latest_revision_id', $latest_revision->ID);
        
        // Add context
        update_post_meta($latest_revision->ID, 'publish_timestamp', current_time('mysql'));
        update_post_meta($latest_revision->ID, 'published_by', get_current_user_id());
    }
}
add_action('save_post', 'track_published_revision', 20, 2);


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
 * Get the published version of a provider post
 */
function get_published_provider_version($post) {
    // If this is already a published post, return it
    if ($post->post_status === 'publish') {
        return $post;
    }
    
    // Check if this is a revision with a published version
    if (wp_is_post_revision($post->ID)) {
        $published_id = get_post_meta($post->ID, 'published_version', true);
        if ($published_id) {
            return get_post($published_id);
        }
    }
    
    // For other cases (drafts, pending), try to find the published version
    $published_post = get_posts([
        'post_type' => 'providers',
        'post_status' => 'publish',
        'meta_key' => 'franscape_id',
        'meta_value' => get_field('franscape_id', $post->ID),
        'posts_per_page' => 1
    ]);
    
    return $published_post ? $published_post[0] : $post;
}
