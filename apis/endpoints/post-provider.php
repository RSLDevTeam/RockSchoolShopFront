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
	//Array to include all params
	//$_POST is used to get the request body
	if (empty($_POST)) {
			return rest_custom_json_response(['error' => 'No data provided'], 400);
	}
	
	$provider_id = $_POST['provider_id'] ?? '';
	$title = $_POST['title'] ?? '';
	$content = $_POST['content'] ?? '';
	$location = $_POST['location'] ?? [];
	$instruments = $_POST['instruments'] ?? '';
	$user_type = $_POST['user_type'] ?? '';
	$inquire_email = $_POST['inquire_email'] ?? '';
	$profile_picture = $_FILES['profile_picture'] ?? '';

	if($profile_picture) {
		// Handle file upload if provided
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');

		$upload = wp_handle_upload($profile_picture, ['test_form' => false]);
		if (!isset($upload['error'])) {
				$filetype = wp_check_filetype($upload['file']);
				$attachment = [
						'post_mime_type' => $filetype['type'],
						'post_title'     => sanitize_file_name($upload['file']),
						'post_content'   => '',
						'post_status'    => 'inherit',
				];
				$profile_picture_id = wp_insert_attachment($attachment, $upload['file']);
				//wp_die('Profile picture ID: ' . $profile_picture_id);
				wp_update_attachment_metadata($profile_picture_id, wp_generate_attachment_metadata($profile_picture_id, $upload['file']));
		}
		
	} else {
		$profile_picture_id = null;
	}

	//validate if any is empty then throw required error
	if (empty($title) || empty($content) || empty($location) || empty($instruments) || empty($user_type)) {
			return rest_custom_json_response(['error' => 'All fields are required'], 400);
	}

	if (empty($user_type) || !in_array($user_type, ['Associate Teacher', 'Associate School'])) {
			return rest_custom_json_response(['error' => 'Invalid user type'], 400);
	}


	if ($provider_id) {
			$query = new WP_Query([
				'post_type'      => 'providers',
				'p'              => $provider_id, // post ID instead of meta_value
				'post_status'    => ['publish', 'draft', 'pending'],
				'posts_per_page' => 1
			]);

			if (!$query->have_posts()) {
				return rest_custom_json_response(['error' => 'Provider not found'], 404);
			}
			$post_id = $query->posts[0]->ID;
			$post_data = [
					'ID'           => $post_id,
					'post_title'   => $title,
					'post_content' => $content,
					'post_status'  => 'draft', 
			];
			$post_id = wp_update_post($post_data);
			$message = 'Provider updated';
	} else {
			$post_id = wp_insert_post([
					'post_type'   => 'providers',
					'post_status' => 'pending',
					'post_title'  => $title,
					'post_content' => $content,
			]);

			if (is_wp_error($post_id)) {
					return new WP_Error('create_failed', 'Failed to create provider', ['status' => 500]);
			}

			$message = 'Provider created';
	}

	// Update ACF fields
	$acf_map_value = [
    'address' => $location['address'] ?? '',
    'lat'     => $location['lat'] ?? '',
		'lng'     => $location['lng'] ?? ''
	];
	if (!empty($profile_picture_id)) {
		update_field('photo', $profile_picture_id, $post_id);
	}
	update_field('location', $acf_map_value, $post_id);
	$instruments_array = array_map('trim', explode(',', $instruments));
	update_field('instruments', $instruments_array, $post_id);

	update_field('inquire_email', $inquire_email, $post_id);
	update_field('type', $user_type, $post_id);

	//Get updated post object
	$post = get_post($post_id);
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
		'slug' => $post->slug,
		'user_type' => get_field('type', $post->ID),
		'link' => get_permalink($post),
		'inquire_email'=> get_field('inquire_email', $post->ID),
		'provider_id' => $post->ID,
		'location' => get_field('location', $post->ID),
		'instruments' => get_field('instruments', $post->ID),
		'profile_picture' => $profile_picture
];
$post['code'] = 'successful';

return rest_custom_json_response($post, 200);

}

