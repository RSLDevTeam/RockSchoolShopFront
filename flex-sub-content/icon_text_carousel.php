<?php
$background_image = get_sub_field('background_image');
$enable_top_border = get_sub_field('enable_top_border');
$top_border_colour = get_sub_field('top_border_colour');
$top_border_vector = get_sub_field('top_border_vector');
$enable_bottom_border = get_sub_field('enable_bottom_border');
$bottom_border_colour = get_sub_field('bottom_border_colour');
$bottom_border_vector = get_sub_field('bottom_border_vector');

$remove_bottom_padding = get_sub_field('remove_bottom_padding');

set_query_var( 'enable_top_border', $enable_top_border );
set_query_var( 'top_border_colour', $top_border_colour );
set_query_var( 'top_border_vector', $top_border_vector );
set_query_var( 'enable_bottom_border', $enable_bottom_border );
set_query_var( 'bottom_border_colour', $bottom_border_colour );
set_query_var( 'bottom_border_vector', $bottom_border_vector );
set_query_var( 'flex_index', $flex_index );

?>

<section id="<?php echo get_sub_field('section_id'); ?>" class="icon_text_grid module-<?php echo $flex_index; ?>">

    <?php if ($background_image) { echo '<div class="background-image-cover" style="background-image:url(' . $background_image['url'] . ');"></div>'; } ?>

    <?php 
    get_template_part( 'snippets/snippet', 'top-border' ); ?>

    <div class="container mx-auto px-4 pt-[6em] <?php if(!$remove_bottom_padding) { echo 'pb-[6em]'; } ?> px-4 lg:px-16">

        <?php if (get_sub_field('title')) : ?><h2 class="text-center text-5xl pb-12"><?php echo get_sub_field('title'); ?></h2><?php endif; ?>

        <?php if (get_sub_field('content')) : ?><div class="text-edgray mb-[3em] max-w-[60%] block mx-auto text-center"><?php echo get_sub_field('content'); ?></div><?php endif; ?>

    </div>

    <?php if( have_rows('block') ): ?>
        <div class="icon-carousel slick-carousel-<?php echo esc_attr($flex_index); ?>">
            <?php while( have_rows('block') ): the_row(); 
                $link = get_sub_field('link');
                $icon = get_sub_field('icon_image');
                $title = get_sub_field('title');
            ?>
                <div class="icon-carousel-single flex flex-col items-center text-center max-w-xs w-[300px]">
                    <?php if ($link): ?>
                        <a href="<?php echo esc_url($link); ?>" class="block">
                    <?php endif; ?>

                    <?php if ($icon): ?>
                        <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt'] ?? ''); ?>" title="<?php echo esc_attr($icon['title'] ?? ''); ?>" class="w-28 h-28 mb-4 block mx-auto" />
                    <?php endif; ?>

                    <p class="text-xl font-semibold"><?php echo esc_html($title); ?></p>

                    <?php if (get_sub_field('content')) { echo '<p class="small-text">' . get_sub_field('content') . '</p>'; } ?>

                    <?php if ($link): ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

    <?php 
    get_template_part( 'snippets/snippet', 'bottom-border' ); ?>

<script>
    jQuery(document).ready(function($) {
      const $carousel = $('.slick-carousel-<?php echo esc_js($flex_index); ?>');

      if ($carousel.length) {

      $carousel.slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 1,
      speed: 5000,
      cssEase: 'linear',
      infinite: true,
      arrows: false,
      dots: false,
      variableWidth: true,
      draggable: true,
      responsive: [
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            centerMode: true,
            variableWidth: false, 
            autoplay: true,
            speed: 3000,
            cssEase: 'ease'
          }
        }
      ]
    });

      }
    });

</script>

</section>