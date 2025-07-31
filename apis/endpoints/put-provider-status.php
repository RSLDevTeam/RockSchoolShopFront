<?php

/**
 * Update provider status by franchise ID.
 */
register_rest_route('api/v1', '/(?P<franchise_id>\d+)/provider', [
    'methods'  => 'PUT',
    'callback' => 'update_provider_status_api_callback'
]);

function update_provider_status_api_callback($request) {
    $headers = $request->get_headers();
    $custom_auth_check = rest_custom_check_jwt($headers);

    if (is_wp_error($custom_auth_check)) {
        return $custom_auth_check;
    }

    $params = json_decode($request->get_body(), true);
    $franchise_id = $params['franchise_id'] ?? '';
    $status       = $params['status'] ?? '';

    // Validate required fields
    if (empty($franchise_id) || empty($status)) {
        return rest_custom_json_response(['error' => 'franchise_id, status are required'], 400);
    }

    //if status is not valid then throw error
    $valid_statuses = ['publish', 'draft', 'pending', 'private'];
    if (!in_array($status, $valid_statuses)) {
        return rest_custom_json_response(['error' => 'Invalid status provided'], 400);
    }

    // Find provider post by franchise_id
    $query = new WP_Query([
        'post_type'      => 'providers',
        'meta_key'       => 'franscape_id',
        'meta_value'     => $franchise_id,
        'posts_per_page' => 1,
    ]);

    if (!$query->have_posts()) {
        return rest_custom_json_response(['error' => 'Provider not found'], 404);
    }

    $post_id = $query->posts[0]->ID;

    // Update the post status
    $updated_post = [
        'ID'          => $post_id,
        'post_status' => sanitize_text_field($status),
    ];
    wp_update_post($updated_post);

    return rest_custom_json_response([
        'code'          => 'successful',
        'message'       => 'Provider status updated successfully',
        'franchise_id'  => $franchise_id,
        'status'        => $status,
        'post_id'       => $post_id,
    ], 200);
}