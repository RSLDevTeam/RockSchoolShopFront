<?php

/**
 * Register REST API endpoint for user info.
 *
 * @return user
 */
register_rest_route('/api/v1', '/provider/(?P<franscape_id>[\w\-]+)', [
    'methods'  => 'GET',
    'callback' => 'get_provider_by_franchise_id',
]);

function rest_user_info_api_callback($request) {
    $params = $request->get_params();
    $headers = $request->get_headers();
    $endpoint = $request->get_route();
    $custom_auth_check = rest_custom_check_jwt($headers);
    $body = json_encode($params);

    if (is_wp_error($custom_auth_check)) {
        return $custom_auth_check;
    }
    
    if (!isset($params['email'])) {
        $email = $custom_auth_check['email'];
    } else {
        $email = $params['email'];
    }

    $user_details = get_user_details($email);
    if (is_wp_error($user_details)) {
        return $user_details;
    }

    $status = 200;
    rest_log_api_call($endpoint, $body, $user_details, $status);

    return rest_custom_json_response($user_details, $status);
}
