<?php

/**
 * Register REST API endpoint for get provider.
 *
 * @return post provider by franchise ID
 */
register_rest_route('api/v1', '/provider', [
    'methods'  => 'GET',
    'callback' => 'get_provider_by_franchise_id'
]);

function get_provider_by_franchise_id($request) {
    $params = $request->get_params();
    $headers = $request->get_headers();
    $endpoint = $request->get_route();
    $custom_auth_check = rest_custom_check_jwt($headers);

    $provider_id = sanitize_text_field($request->get_param('provider_id'));

    if (is_wp_error($custom_auth_check)) {
        return $custom_auth_check;
    }

    
    if (empty($provider_id) || !is_numeric($provider_id)) {
        return rest_custom_json_response(['error' => 'Provider ID is required'], 400);
    }

    $query = new WP_Query([
        'post_type'      => 'providers',
        'p'              => $provider_id, // post ID instead of meta_value
        'post_status'    => ['publish', 'draft', 'pending'],
        'posts_per_page' => 1
    ]);
    if (!$query->have_posts()) {
        return rest_custom_json_response(['error' => 'Provider not found'], 404);
    }
    $post = $query->posts[0];

    $photo = get_field('photo', $post->ID);
    if ($photo && is_array($photo)) {
        $profile_picture = $photo['url'] ?? '';
    } else {
        $profile_picture = '';
    }
    
    $post = [
        'id' => $post->ID,
        'title' => $post->post_title,
        'content' => $post->post_content,
        'excerpt' => $post->post_excerpt,
        'date' => $post->post_date,
        'modified' => $post->post_modified,
        'status' => $post->post_status,
        'slug' => $post->post_name,
        'inquire_email'=> get_field('inquire_email', $post->ID),
        'user_type' => get_field('user_type', $post->ID),
        'link' => get_permalink($post),
        'provider_id' => $post->ID,
        'location' => get_field('location', $post->ID),
        'instruments' => get_field('instruments', $post->ID),
        'profile_picture' => $profile_picture
    ];
    $post['code'] = 'successful';

    return rest_custom_json_response($post, 200);
}
