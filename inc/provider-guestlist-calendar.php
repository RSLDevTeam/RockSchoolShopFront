<?php
/**
 * Guestlist calendar data for provider pages and flexible content modules.
 */

function rsl_shopfront_get_guestlist_url(): string {
    $guestlist_url = function_exists('get_field')
        ? trim((string) get_field('guestlist_url', 'option'))
        : '';

    return rtrim($guestlist_url ?: 'https://guestlist.rockschool.io', '/');
}

function rsl_shopfront_guestlist_price($amount, string $currency = 'gbp'): string {
    if (!is_numeric($amount)) {
        return __('Call', 'rockschool');
    }

    $symbols = [
        'aud' => 'A$',
        'cad' => 'C$',
        'eur' => '€',
        'gbp' => '£',
        'nzd' => 'NZ$',
        'usd' => '$',
    ];
    $currency = strtolower($currency);
    $symbol = $symbols[$currency] ?? strtoupper($currency) . ' ';

    return $symbol . number_format((float) $amount, 2);
}

function rsl_shopfront_normalize_guestlist_item(array $item, string $type, string $guestlist_url): array {
    $is_lesson = 'lesson' === $type;
    $class = $is_lesson && is_array($item['course_class'] ?? null) ? $item['course_class'] : $item;
    $discipline = $item['discipline_name'] ?? ($class['discipline_name'] ?? ($class['discipline']['name'] ?? ''));
    $instructor = is_array($item['instructor'] ?? null) ? ($item['instructor']['name'] ?? '') : '';
    $date = $is_lesson ? ($item['lesson_date'] ?? '') : ($item['start_date'] ?? '');
    $date = is_string($date) ? substr($date, 0, 10) : '';
    $currency = strtolower((string) ($class['currency'] ?? 'gbp'));
    $price_amount = $is_lesson
        ? ($item['current_base_price'] ?? null)
        : (!empty($class['fixed_price_enabled']) ? ($class['full_class_price'] ?? null) : ($class['current_base_price'] ?? null));

    return [
        'type'            => $type,
        'id'              => absint($item['id'] ?? 0),
        'name'            => sanitize_text_field($is_lesson ? ($item['topic'] ?? ($class['name'] ?? '')) : ($item['name'] ?? '')),
        'description'     => sanitize_text_field($class['description'] ?? ''),
        'discipline'      => sanitize_text_field($discipline),
        'date'            => $date,
        'start_time'      => sanitize_text_field($item['start_time'] ?? ''),
        'end_time'        => sanitize_text_field($item['end_time'] ?? ''),
        'instructor'      => sanitize_text_field($instructor),
        'price_formatted' => rsl_shopfront_guestlist_price($price_amount, $currency),
        'recurrence'      => sanitize_text_field($class['recurrence_description'] ?? ''),
        'book_url'        => add_query_arg(
            [
                'type' => $type,
                'id'   => absint($item['id'] ?? 0),
            ],
            $guestlist_url . '/book'
        ),
    ];
}

function rsl_shopfront_get_guestlist_calendar_data(int $backstage_franchise_id) {
    if ($backstage_franchise_id <= 0) {
        return new WP_Error('missing_backstage_franchise_id', __('Missing Backstage franchise ID.', 'rockschool'));
    }

    $guestlist_url = rsl_shopfront_get_guestlist_url();
    $cache_key = 'rsl_guestlist_calendar_' . md5($guestlist_url . '|' . $backstage_franchise_id);
    $cached = get_transient($cache_key);
    if (is_array($cached)) {
        return $cached;
    }

    $endpoint = add_query_arg(
        'backstage_franchise_id',
        $backstage_franchise_id,
        $guestlist_url . '/api/classes'
    );
    $response = wp_remote_get($endpoint, [
        'headers' => ['Accept' => 'application/json'],
        'timeout' => 12,
    ]);

    if (is_wp_error($response)) {
        return $response;
    }

    $status_code = (int) wp_remote_retrieve_response_code($response);
    $decoded = json_decode(wp_remote_retrieve_body($response), true);
    if (200 !== $status_code || !is_array($decoded) || 'success' !== ($decoded['status'] ?? '') || !is_array($decoded['data'] ?? null)) {
        return new WP_Error('guestlist_response_error', __('Guestlist calendar data is unavailable.', 'rockschool'));
    }

    $raw = $decoded['data'];
    $franchise = is_array($raw['franchise'] ?? null) ? $raw['franchise'] : [];
    $classes = array_map(
        fn(array $item): array => rsl_shopfront_normalize_guestlist_item($item, 'class', $guestlist_url),
        array_values(array_filter($raw['classes'] ?? [], 'is_array'))
    );
    $lessons = array_map(
        fn(array $item): array => rsl_shopfront_normalize_guestlist_item($item, 'lesson', $guestlist_url),
        array_values(array_filter($raw['lessons'] ?? [], 'is_array'))
    );

    $sort_items = static function (array &$items): void {
        usort($items, static fn(array $a, array $b): int => strcmp(
            ($a['date'] ?? '') . ' ' . ($a['start_time'] ?? ''),
            ($b['date'] ?? '') . ' ' . ($b['start_time'] ?? '')
        ));
    };
    $sort_items($classes);
    $sort_items($lessons);

    $disciplines = array_values(array_unique(array_filter(array_merge(
        array_column($classes, 'discipline'),
        array_column($lessons, 'discipline')
    ))));
    natcasesort($disciplines);
    $disciplines = array_values($disciplines);

    $calendar = [
        'franchise_name' => sanitize_text_field($franchise['name'] ?? ''),
        'disciplines'    => $disciplines,
        'classes'        => $classes,
        'lessons'        => $lessons,
    ];

    set_transient($cache_key, $calendar, 5 * MINUTE_IN_SECONDS);

    return $calendar;
}

function rsl_shopfront_normalize_guestlist_embed_item(array $item, string $type): array {
    $date = is_string($item['date'] ?? null) ? substr($item['date'], 0, 10) : '';

    return [
        'type'            => $type,
        'id'              => absint($item['id'] ?? 0),
        'name'            => sanitize_text_field($item['name'] ?? ''),
        'description'     => sanitize_text_field($item['description'] ?? ''),
        'discipline'      => sanitize_text_field($item['discipline'] ?? ''),
        'date'            => $date,
        'start_time'      => sanitize_text_field($item['start_time'] ?? ''),
        'end_time'        => sanitize_text_field($item['end_time'] ?? ''),
        'instructor'      => sanitize_text_field($item['instructor'] ?? ''),
        'price_formatted' => sanitize_text_field($item['price_formatted'] ?? __('Call', 'rockschool')),
        'recurrence'      => sanitize_text_field($item['recurrence'] ?? ''),
        'book_url'        => esc_url_raw($item['book_url'] ?? ''),
    ];
}

function rsl_shopfront_get_guestlist_calendar_data_by_embed_key(string $embed_key) {
    $embed_key = trim(sanitize_text_field($embed_key));
    if ('' === $embed_key) {
        return new WP_Error('missing_guestlist_embed_key', __('Missing Guestlist embed key.', 'rockschool'));
    }

    $guestlist_url = rsl_shopfront_get_guestlist_url();
    $cache_key = 'rsl_guestlist_embed_' . md5($guestlist_url . '|' . $embed_key);
    $cached = get_transient($cache_key);
    if (is_array($cached)) {
        return $cached;
    }

    $response = wp_remote_get(
        $guestlist_url . '/embed/franchises/' . rawurlencode($embed_key) . '/data',
        [
            'headers' => ['Accept' => 'application/json'],
            'timeout' => 12,
        ]
    );
    if (is_wp_error($response)) {
        return $response;
    }

    $status_code = (int) wp_remote_retrieve_response_code($response);
    $decoded = json_decode(wp_remote_retrieve_body($response), true);
    if (200 !== $status_code || !is_array($decoded) || 'success' !== ($decoded['status'] ?? '') || !is_array($decoded['data'] ?? null)) {
        return new WP_Error('guestlist_embed_response_error', __('Guestlist calendar data is unavailable.', 'rockschool'));
    }

    $payload = $decoded['data'];
    $classes = array_map(
        fn(array $item): array => rsl_shopfront_normalize_guestlist_embed_item($item, 'class'),
        array_values(array_filter($payload['classes'] ?? [], 'is_array'))
    );
    $lessons = array_map(
        fn(array $item): array => rsl_shopfront_normalize_guestlist_embed_item($item, 'lesson'),
        array_values(array_filter($payload['lessons'] ?? [], 'is_array'))
    );
    $disciplines = array_values(array_unique(array_filter(array_merge(
        array_column($classes, 'discipline'),
        array_column($lessons, 'discipline')
    ))));
    natcasesort($disciplines);

    $calendar = [
        'franchise_name' => sanitize_text_field($payload['franchise']['name'] ?? ''),
        'disciplines'    => array_values($disciplines),
        'classes'        => $classes,
        'lessons'        => $lessons,
    ];
    set_transient($cache_key, $calendar, 5 * MINUTE_IN_SECONDS);

    return $calendar;
}

function rsl_shopfront_enqueue_provider_calendar_assets(): void {
    $post_id = get_queried_object_id();
    $has_provider_calendar = is_singular('providers') && rsl_shopfront_get_backstage_franchise_id($post_id);
    $has_flexible_calendar = false;
    $flexible_elements = function_exists('get_field') ? get_field('flexible_elements', $post_id) : [];
    foreach ((array) $flexible_elements as $element) {
        if (is_array($element) && 'iframe' === ($element['acf_fc_layout'] ?? '')) {
            $has_flexible_calendar = true;
            break;
        }
    }

    if (!$has_provider_calendar && !$has_flexible_calendar) {
        return;
    }

    $css_path = get_stylesheet_directory() . '/css/guestlist-calendar.css';
    $js_path = get_stylesheet_directory() . '/js/guestlist-calendar.js';
    wp_enqueue_style(
        'rsl-guestlist-calendar',
        get_stylesheet_directory_uri() . '/css/guestlist-calendar.css',
        ['output'],
        file_exists($css_path) ? filemtime($css_path) : null
    );
    wp_enqueue_script(
        'rsl-guestlist-calendar',
        get_stylesheet_directory_uri() . '/js/guestlist-calendar.js',
        [],
        file_exists($js_path) ? filemtime($js_path) : null,
        true
    );
}
add_action('wp_enqueue_scripts', 'rsl_shopfront_enqueue_provider_calendar_assets', 20);
