<?php
$guestlist_franscape_id = get_sub_field('franscape_id');
$guestlist_instance_id = 'guestlist-calendar-' . $flex_index;

get_template_part(
    'snippets/snippet',
    'guestlist-cal',
    [
        'franscape_id' => $guestlist_franscape_id,
        'instance_id' => $guestlist_instance_id,
    ]
);
