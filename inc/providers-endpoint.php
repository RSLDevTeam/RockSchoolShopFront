<?php 
// providers endpoint
add_action('wp_ajax_nopriv_get_providers', 'get_providers_json');
add_action('wp_ajax_get_providers', 'get_providers_json');

function get_providers_json() {

    $args = [
        'post_type' => 'providers',
        'posts_per_page' => -1,
        'post_status' => ['publish', 'pending']
    ];

    if (!empty($_GET['type'])) {
        $args['meta_query'] = [
            [
                'key' => 'type',
                'value' => sanitize_text_field($_GET['type']),
                'compare' => '='
            ]
        ];
    }

    if (!empty($_GET['instrument'])) {
        $args['meta_query'] = [
            [
                'key' => 'instruments',
                'value' => sanitize_text_field($_GET['instrument']),
                'compare' => 'LIKE'
            ]
        ];
    }
    $user_lat = isset($_GET['lat']) ? floatval($_GET['lat']) : 51.5;
    $user_lng = isset($_GET['lng']) ? floatval($_GET['lng']) : -0.1;
    $user_distance = isset($_GET['distance']) ? $_GET['distance'] : null;

    $query = new WP_Query($args);

    $results = [];

    foreach ($query->posts as $post) {


        $location = get_field('location', $post->ID);
        $published_content = get_last_published_provider_content($post->ID);
        $display_title = get_the_title($post->ID);
        
        if ($post->post_status == 'pending') {
            if (isset($published_content->post_title) && $published_content->post_title !== '') {
                $display_title = $published_content->post_title;
            }
        }
        if (!$location) continue;

        $provider_lat = floatval($location['lat']);
        $provider_lng = floatval($location['lng']);
        $distance = null;

        if ($user_lat !== null && $user_lng !== null) {
            $distance = haversine_distance($user_lat, $user_lng, $provider_lat, $provider_lng);
        }

        // if ($distance === null || $distance <= $user_distance) {
            $results[] = [
                'id'        => $post->ID,
                'title'     => $display_title,
                'lat'       => $location['lat'],
                'lng'       => $location['lng'],
                'address'   => $location['address'],
                'type'      => get_field('type', $post->ID),
                'instrument'=> get_field('instruments', $post->ID),
                'photo'     => get_field('photo', $post->ID)['sizes']['square'] ?? '',
                'permalink' => get_permalink($post->ID),
                'distance'   => $distance, // distance in miles
            ];
        // }

    }

    wp_send_json($results);
}

function haversine_distance($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 3958.8; // in miles

    $lat1 = deg2rad($lat1);
    $lat2 = deg2rad($lat2);
    $lon1 = deg2rad($lon1);
    $lon2 = deg2rad($lon2);

    $delta_lat = $lat2 - $lat1;
    $delta_lon = $lon2 - $lon1;

    $a = sin($delta_lat / 2) * sin($delta_lat / 2) +
         cos($lat1) * cos($lat2) *
         sin($delta_lon / 2) * sin($delta_lon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earth_radius * $c;
}