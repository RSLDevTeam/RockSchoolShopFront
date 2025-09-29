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

$enable_slick = get_sub_field('enable_slick');
$grid_id = 'elements-grid-' . $flex_index;
$full_bleed_elements = get_sub_field('full_bleed_elements');
$image_size = get_sub_field('image_size');

$centre_align = get_sub_field('centre_align');
?>



<section id="<?php echo get_sub_field('section_id'); ?>" class="content_grid ContentSection module-<?php echo $flex_index; ?>">
    <?php if ($background_image) { echo '<div class="background-image-cover" style="background-image:url(' . $background_image['url'] . ');"></div>'; } ?>
    
    <?php 
    get_template_part( 'snippets/snippet', 'top-border' ); ?>

    <div class="split-module-inner split-module-<?php echo $flex_index; ?> w-[85%] mx-auto px-4 pt-[6em] pb-[1em]">

        <?php if (!$centre_align) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 items-center">
        <?php endif; ?>
            
            <div class="split-text-holder" data-aos="fade-up" <?php if ($centre_align) { echo 'style="text-align: center;"';} ?>>
                <h6 class="section-title-column font-semibold coffee uppercase pr-[10px] inline-block relative mb-[10px] tracking-[1.5px]">
                    <?php echo get_sub_field('title'); ?>
                </h6>
                <h2 class="ed-section-title text-[3em] font-bold mb-[0.3em] <?php if (get_sub_field('title_and_button_colour_override') == 'latte') { echo 'text-rockschool-latte-900'; } elseif (get_sub_field('title_and_button_colour_override') == 'yellow') { echo 'text-rockschool-yellow-900'; } ?>">
                    <?php echo get_sub_field('sub_title'); ?>
                </h2>
                <div class="text-edgray mb-[3em]"><?php echo get_sub_field('content'); ?></div>
            </div>

        <?php if (!$centre_align) : ?>    
            </div>
        <?php endif; ?>

    </div>

    <?php if (have_rows('elements')) : 
        $element_count = 1; ?>

        <div class="elements-holder relative">

            <?php if ($enable_slick) : ?>
                <svg id="slick-left-arrow" class="slick-prev absolute slick-arrow max-w-50px left-5 top-1/2 transform -translate-y-1/2 z-20" data-name="Isolation Mode" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 266.56 459.07">
                  <polygon points="229.54 0 266.56 37.02 74.05 229.54 266.56 422.05 229.54 459.07 37.02 266.56 0 229.54 229.54 0" style="fill: #fff;"/>
                </svg>
            <?php endif; ?>

            <div id="element-grid-<?php echo esc_attr($grid_id); ?>" class="elements-grid <?php echo $enable_slick ? 'is-slick' : ''; ?> grid grid-cols-1 md:grid-cols-3 gap-8 <?php if (!$full_bleed_elements) : ?> w-[85%] mx-auto px-4 <?php endif; ?> mb-[6em]" data-aos="fade-up">

                <?php while (have_rows('elements')) : the_row(); 
                    $image = get_sub_field('image');
                    $content = get_sub_field('content');
                    $video = get_sub_field('video');
                    $has_video = !empty($video);
                    $aspect_class = $image_size === 'square' ? 'aspect-square' : 'aspect-video';
                    ?>
                    <div class="element-item px-4 element-grid-<?php echo esc_attr($grid_id); ?>-grid-item-<?php echo $element_count; ?>">
                        <?php if ($image) : ?>
                            <div class="element-media relative mb-4 <?php echo $aspect_class; ?>">
                                <div class="media-wrapper w-full h-full overflow-hidden" 
                                     data-img-src="<?php echo esc_url($image['sizes'][$image_size]); ?>" 
                                     data-img-alt="<?php echo esc_attr($image['alt']); ?>">
                                    <img src="<?php echo esc_url($image['sizes'][$image_size]); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="w-full h-full object-cover video-thumbnail" />
                                </div>
                                <?php if ($has_video) : ?>
                                    <div class="play-button absolute inset-0 flex items-center justify-center bg-black/50 hover:bg-black/70 transition z-10 cursor-pointer" data-video-src="<?php echo esc_url($video['url']); ?>">
                                        <div class="play-icon fade-in fade-in-active">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" id="Play-Icon" height="100" width="100">
                                                <desc>Play Icon</desc>
                                                <path fill="#ffffff" d="M9.575 16.25 16.25 12l-6.675 -4.25v8.5ZM12 22c-1.36665 0 -2.65835 -0.2625 -3.875 -0.7875 -1.21665 -0.525 -2.27915 -1.24165 -3.1875 -2.15 -0.908335 -0.90835 -1.625 -1.97085 -2.15 -3.1875C2.2625 14.65835 2 13.36665 2 12c0 -1.38335 0.2625 -2.68335 0.7875 -3.9 0.525 -1.21665 1.241665 -2.275 2.15 -3.175 0.90835 -0.9 1.97085 -1.6125 3.1875 -2.1375C9.34165 2.2625 10.63335 2 12 2c1.38335 0 2.68335 0.2625 3.9 0.7875 1.21665 0.525 2.275 1.2375 3.175 2.1375 0.9 0.9 1.6125 1.95835 2.1375 3.175C21.7375 9.31665 22 10.61665 22 12c0 1.36665 -0.2625 2.65835 -0.7875 3.875 -0.525 1.21665 -1.2375 2.27915 -2.1375 3.1875 -0.9 0.90835 -1.95835 1.625 -3.175 2.15C14.68335 21.7375 13.38335 22 12 22Zm0 -1.5c2.36665 0 4.375 -0.82915 6.025 -2.4875C19.675 16.35415 20.5 14.35 20.5 12c0 -2.36665 -0.825 -4.375 -2.475 -6.025C16.375 4.325 14.36665 3.5 12 3.5c-2.35 0 -4.35415 0.825 -6.0125 2.475C4.329165 7.625 3.5 9.63335 3.5 12c0 2.35 0.829165 4.35415 2.4875 6.0125C7.64585 19.67085 9.65 20.5 12 20.5Z" stroke-width="0.5"></path>
                                            </svg>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <div class="element-content prose max-w-none">
                            <?php echo $content; ?>
                        </div>
                    </div>
                <?php $element_count++; endwhile; ?>

            </div>

            <?php if ($enable_slick) : ?>
                <svg id="slick-right-arrow" class="slick-next absolute max-w-50px slick-arrow right-5 top-1/2 transform -translate-y-1/2 z-20" data-name="Isolation Mode" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 266.56 459.07">
                  <polygon points="37.02 459.07 0 422.05 192.51 229.54 0 37.02 37.02 0 229.54 192.51 266.56 229.54 37.02 459.07" style="fill: #fff;"/>
                </svg>
            <?php endif; ?>

        </div>

    <?php endif; ?>

    <?php 
    get_template_part( 'snippets/snippet', 'bottom-border' ); ?>

</section>

<?php if ($enable_slick) : ?>
    <script>
        jQuery(document).ready(function($) {
            $('#element-grid-<?php echo esc_attr($grid_id); ?>.is-slick').slick({
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 3,
                arrows: true,
                prevArrow: $('.slick-prev'),
                nextArrow: $('.slick-next'),
                dots: false,
                infinite: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            centerPadding: '30px'
                        }
                    },
                    {
                        breakpoint: 640,
                        settings: {
                            slidesToShow: 1,
                            centerPadding: '20px'
                        }
                    }
                ]
            });
        });
    </script>
<?php endif; ?>

<script>
jQuery(document).ready(function($) {
    $('.play-button').on('click', function() {
        const $playButton = $(this);
        const videoUrl = $playButton.data('video-src');
        const $media = $playButton.closest('.element-media');
        const $wrapper = $media.find('.media-wrapper');

        // Pause and restore all other videos
        $('.element-media video').each(function() {
            this.pause();
            const $mw = $(this).closest('.media-wrapper');
            const imgSrc = $mw.data('img-src');
            const imgAlt = $mw.data('img-alt');

            $mw.html('<img src="' + imgSrc + '" alt="' + imgAlt + '" class="w-full h-full object-cover video-thumbnail" />');
            // Show play button again
            $mw.closest('.element-media').find('.play-button').show();
        });

        // Inject and play the clicked video
        const $video = $('<video />', {
            src: videoUrl,
            autoplay: true,
            controls: true,
            class: 'w-full h-full object-cover'
        });

        $wrapper.html($video);
        $playButton.hide(); // just hide instead of removing
    });
});
</script>

