<?php 
// providers endpoint
add_action('wp_ajax_nopriv_get_providers', 'get_providers_json');
add_action('wp_ajax_get_providers', 'get_providers_json');

function get_providers_json() {
    $args = [
        'post_type' => 'providers',
        'posts_per_page' => -1,
        'post_status' => 'publish',
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

    $query = new WP_Query($args);

    $results = [];

    foreach ($query->posts as $post) {
        $location = get_field('location', $post->ID);
        if (!$location) continue;

        $results[] = [
            'id'       => $post->ID,
            'title'    => get_the_title($post->ID),
            'lat'      => $location['lat'],
            'lng'      => $location['lng'],
            'address'  => $location['address'],
            'type'     => get_field('type', $post->ID),
            'photo'    => get_field('photo', $post->ID)['sizes']['thumbnail'] ?? '',
            'permalink' => get_permalink($post->ID),
        ];
    }

    wp_send_json($results);
}