<?php
$guestlist_embed_key = trim((string) get_sub_field('guestlist_embed_key'));
$backstage_franchise_id = absint(get_sub_field('backstage_franchise_id'));

if ('' !== $guestlist_embed_key) {
    $calendar = rsl_shopfront_get_guestlist_calendar_data_by_embed_key($guestlist_embed_key);
} elseif ($backstage_franchise_id > 0) {
    $calendar = rsl_shopfront_get_guestlist_calendar_data($backstage_franchise_id);
} else {
    return;
}

if (is_wp_error($calendar)) {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Guestlist flexible calendar: ' . $calendar->get_error_message());
    }
    return;
}
?>
<section class="guestlist-calendar-module module-<?php echo esc_attr($flex_index); ?>">
    <div class="container mx-auto p-2.5 max-w-[1440px] z-1 w-[85%] px-4 py-10">
        <?php get_template_part('snippets/snippet', 'guestlist-calendar', ['calendar' => $calendar]); ?>
    </div>
</section>
