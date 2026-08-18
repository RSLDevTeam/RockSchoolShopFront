<?php
$guestlist_embed_key = trim((string) get_sub_field('guestlist_embed_key'));
$guestlist_url = rtrim((string) get_field('guestlist_url', 'option'), '/');

if ($guestlist_url === '') {
    $guestlist_url = 'https://guestlist.rockschool.io';
}

if ($guestlist_embed_key === '') {
    return;
}

$guestlist_widget_url = add_query_arg(
    array(
        'embed_key' => $guestlist_embed_key,
        'guestlist_url' => $guestlist_url,
    ),
    get_template_directory_uri() . '/flex-sub-content/guestlist-widget.html'
);
?>
<section class="guestlist-widget-section module-<?php echo esc_attr($flex_index); ?>">
    <iframe
        class="guestlist-widget-frame"
        src="<?php echo esc_url($guestlist_widget_url); ?>"
        title="Guestlist classes and lessons"
        loading="lazy"
        scrolling="no"
        style="border: 0; display: block; min-height: 400px; width: 100%;"
    ></iframe>
</section>
<script>
    (function () {
        var frame = document.currentScript.previousElementSibling.querySelector('.guestlist-widget-frame');

        window.addEventListener('message', function (event) {
            if (event.origin !== window.location.origin || event.source !== frame.contentWindow || !event.data || event.data.type !== 'guestlist-widget-height') {
                return;
            }

            frame.style.height = event.data.height + 'px';
        });
    }());
</script>
