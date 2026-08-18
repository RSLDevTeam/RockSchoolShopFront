<?php
$guestlist_embed_key = trim((string) get_sub_field('guestlist_embed_key'));

if ($guestlist_embed_key === '') {
    return;
}
?>
<section class="guestlist-widget-section module-<?php echo esc_attr($flex_index); ?>">
    <div class="guestlist-widget" data-guestlist-embed-key="<?php echo esc_attr($guestlist_embed_key); ?>" data-guestlist-style-mode="styled"></div>
</section>
<script src="https://guestlist.rockschool.io/assets/js/widgets/guestlist-embed.js" async></script>
