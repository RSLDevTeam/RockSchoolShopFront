<?php
function rest_custom_json_response($data, $status = 200) {
    $code = isset($data['code']) ? $data['code'] : 'successful';
    $message = isset($data['message']) ? $data['message'] : 'OK';

    // Unset the keys from the $data array
    unset($data['code'], $data['message']);

    return new WP_REST_Response([
        'code' => $code,
        'message' => $message,
        'status' => $status,
        'success' => $status >= 200 && $status < 300,
        'data' => $data,
    ], $status);
}
