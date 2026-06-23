<?php
$background_image = get_sub_field('background_image');
$enable_top_border = get_sub_field('enable_top_border');
$top_border_colour = get_sub_field('top_border_colour');
$top_border_vector = get_sub_field('top_border_vector');
$enable_bottom_border = get_sub_field('enable_bottom_border');
$bottom_border_colour = get_sub_field('bottom_border_colour');
$bottom_border_vector = get_sub_field('bottom_border_vector');

set_query_var( 'enable_top_border', $enable_top_border );
set_query_var( 'top_border_colour', $top_border_colour );
set_query_var( 'top_border_vector', $top_border_vector );
set_query_var( 'enable_bottom_border', $enable_bottom_border );
set_query_var( 'bottom_border_colour', $bottom_border_colour );
set_query_var( 'bottom_border_vector', $bottom_border_vector );
set_query_var( 'flex_index', $flex_index );

$width_class = $content_width === 'narrow' ? 'max-w-[60%]' : 'max-w-full';
$content_class = "{$alignment_class} {$width_class} block";
?>

<section id="<?php echo get_sub_field('section_id'); ?>" class="contact_shortcode_module module-<?php echo $flex_index; ?>">

    <?php if ($background_image) { echo '<div class="background-image-cover" style="background-image:url(' . $background_image['url'] . ');"></div>'; } ?>

    <?php 
    get_template_part( 'snippets/snippet', 'top-border' ); ?>

    <div class="container mx-auto px-4 max-w-[1300px] py-24 px-4 lg:px-16">

        <h2 class="text-center text-5xl pb-12"><?php echo get_sub_field('title'); ?></h2>

        <?php if (get_sub_field('content')) : ?><div class="text-<?php echo esc_attr($content_colour); ?> mb-[3em] text-left ml-0 mr-auto"><?php echo get_sub_field('content'); ?></div><?php endif; ?>

        <?php if (get_sub_field('shortcode')) : 
            $shortcode = get_sub_field('shortcode')?>
            <div class="contact_shortcode"><?php echo do_shortcode($shortcode); ?></div>
        <?php endif; ?>

    </div>

    <?php 
    get_template_part( 'snippets/snippet', 'bottom-border' ); ?>

</section>