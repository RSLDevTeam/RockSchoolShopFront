<?php
$guestlist_embed_key = trim((string) get_sub_field('guestlist_embed_key'));
$guestlist_url = rtrim((string) get_field('guestlist_url', 'option'), '/');

if ($guestlist_url === '') {
    $guestlist_url = 'https://guestlist.rockschool.io';
}

if ($guestlist_embed_key === '') {
    return;
}
?>
<link rel="stylesheet" href="<?php echo esc_url($guestlist_url . '/assets/css/guestlist-widget-base.css'); ?>" data-guestlist-widget-css="<?php echo esc_attr($guestlist_url . '/assets/css/guestlist-widget-base.css'); ?>">
<link rel="stylesheet" href="<?php echo esc_url($guestlist_url . '/assets/css/guestlist-widget-theme.css'); ?>" data-guestlist-widget-css="<?php echo esc_attr($guestlist_url . '/assets/css/guestlist-widget-theme.css'); ?>">
<style>
    /* Keep global Rockschool typography rules from altering the embedded widget. */
    .guestlist-widget {
        font-family: var(--gl-font-family, system-ui, sans-serif);
        font-size: 16px;
        font-weight: 400;
        line-height: 1.5;
    }

    .guestlist-widget :is(h1, h2, h3, h4, h5, h6) {
        clear: none;
        font-family: inherit !important;
        letter-spacing: normal !important;
        text-transform: none !important;
    }

    .guestlist-widget p {
        line-height: 1.5;
    }
</style>
<section class="guestlist-widget-section module-<?php echo esc_attr($flex_index); ?>">
    <div class="guestlist-widget" data-guestlist-embed-key="<?php echo esc_attr($guestlist_embed_key); ?>" data-guestlist-style-mode="styled"></div>
</section>
<script src="<?php echo esc_url($guestlist_url . '/assets/js/widgets/guestlist-embed.js'); ?>" async></script>
