<?php

/**
 * Create Update REST API endpoint for post provider.
 *
 * @return post provider by franchise ID
 */
register_rest_route('api/v1', '/provider', [
	'methods'  => 'POST',
	'callback' => 'create_update_provider_api_callback'
]);

function create_update_provider_api_callback($request) {
	$headers = $request->get_headers();
	//get request body 
	$custom_auth_check = rest_custom_check_jwt($headers);

	if (is_wp_error($custom_auth_check)) {
			return $custom_auth_check;
	}

	$params = $request->get_json_params();
	$franscape_id = sanitize_text_field($params['franscape_id'] ?? '');
	$title = sanitize_text_field($params['title'] ?? '');
	$content = sanitize_textarea_field($params['content'] ?? '');
	$location = $params['location'] ?? [];
	$instruments = sanitize_text_field($params['instruments'] ?? '');
	$user_type = sanitize_text_field($params['user_type'] ?? '');

	//wp_die('Title: ' . $title . ', Content: ' . $content . ', Location: ' . print_r($location, true) . ', Instruments: ' . $instruments . ', User Type: ' . $user_type);
	//validate if any is empty then throw required error
	if (empty($title) || empty($content) || empty($location) || empty($instruments) || empty($user_type)) {
			return rest_custom_json_response(['error' => 'All fields are required'], 400);
	}

	if (empty($user_type) || !in_array($user_type, ['Associate Teacher', 'Associate School'])) {
			return rest_custom_json_response(['error' => 'Invalid user type'], 400);
	}

	if (empty($franscape_id)) {
			return rest_custom_json_response(['error' => 'franscape_id is required'], 400);
	}

	$query = new WP_Query([
			'post_type'  => 'providers',
			'meta_key'   => 'franscape_id',
			'meta_value' => $franscape_id,
			'posts_per_page' => 1
	]);

	if ($query->have_posts()) {
			$post_id = $query->posts[0]->ID;
			$message = 'Provider updated';
	} else {
			$post_id = wp_insert_post([
					'post_type'   => 'providers',
					'post_status' => 'publish',
					'post_title'  => $title,
					'post_content' => $content,
			]);

			if (is_wp_error($post_id)) {
					return new WP_Error('create_failed', 'Failed to create provider', ['status' => 500]);
			}

			update_field('franscape_id', $franscape_id, $post_id);
			$message = 'Provider created';
	}

	// Update ACF fields
	$acf_map_value = [
    'address' => $location['address'] ?? '',
    'lat'     => $location['lat'] ?? '',
		'lng'     => $location['lng'] ?? ''
	];

	update_field('location', $acf_map_value, $post_id);
	$instruments_array = array_map('trim', explode(',', $instruments));
	update_field('instruments', $instruments_array, $post_id);

	//Get updated post object
	$post = get_post($post_id);
	$post = [
		'id' => $post->ID,
		'title' => $post->post_title,
		'content' => $post->post_content,
		'excerpt' => $post->post_excerpt,
		'date' => $post->post_date,
		'modified' => $post->post_modified,
		'status' => $post->post_status,
		'slug' => $post->post_name,
		'user_type' => get_field('user_type', $post->ID),
		'link' => get_permalink($post),
		'franscape_id' => get_field('franscape_id', $post->ID),
		'location' => get_field('location', $post->ID),
		'instruments' => get_field('instruments', $post->ID),
];
$post['code'] = 'successful';

return rest_custom_json_response($post, 200);

}

