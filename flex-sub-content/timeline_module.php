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
?>

<section id="<?php echo get_sub_field('section_id'); ?>" class="timeline-module ContentSection module-<?php echo $flex_index; ?>">
    <?php if ($background_image) { echo '<div class="background-image-cover" style="background-image:url(' . $background_image['url'] . ');"></div>'; } ?>
    
    <?php 
    get_template_part( 'snippets/snippet', 'top-border' ); ?>

    <?php if (have_rows('elements')) : 

        $element_count = 1;

        while (have_rows('elements')) : the_row(); ?>

            <div class="timeline-module-inner w-[85%] mx-auto px-4 pt-[6em]">
                <div class="grid grid-cols-1 md:grid-cols-2 items-center">
                    
                    <!-- Text Column -->
                    <div class="md:max-w-full shrink-0 grow pad <?php if ($element_count % 2 == 0) { echo 'order-2 md:order-1'; } else { echo 'order-2'; } ?>" <?php if ($element_count % 2 == 0) { echo 'data-aos="fade-right"'; } else { echo 'data-aos="fade-left"'; } ?>>

                        <div class="split-text-holder">                    
                            <div class="text-edgray mb-[1em] mt-[1em] <?php if ($element_count % 2 == 0) { echo 'align-right'; } else { echo 'align-left'; } ?>"><?php echo get_sub_field('content'); ?></div>
                        </div>
                    </div>

                    <!-- Title Column  -->
                    <div class="md:max-w-full grow relative <?php if ($element_count % 2 == 0) { echo 'order-1 md:order-2'; } else { echo 'order-1'; } ?>" <?php if ($element_count % 2 == 0) { echo 'data-aos="fade-left"'; } else { echo 'data-aos="fade-right"'; } ?>>
                        
                        <h2 class="ed-section-title text-[3em] font-bold mb-[0.3em] mt-[0.3em] <?php if ($element_count % 2 == 0) { echo 'align-left'; } else { echo 'align-right'; } ?>">
                            <?php echo get_sub_field('title'); ?>
                        </h2>

                    </div>
                </div>
            </div>


        <?php $element_count++; endwhile; 

    endif; ?>

    <?php 
    get_template_part( 'snippets/snippet', 'bottom-border' ); ?>

</section>



