<?php
$position = get_sub_field('position'); 
$is_right = $position === 'right';

$image = get_sub_field('image');
$video = get_sub_field('video');
$background_image = get_sub_field('background_image');
$button_link = get_sub_field('button_link');
$mask_style = get_sub_field('mask_style');
$remove_bottom_padding = get_sub_field('remove_bottom_padding');

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

<section id="<?php echo get_sub_field('section_id'); ?>" class="twoColumn ContentSection module-<?php echo $flex_index; ?>">
    <?php if ($background_image) { echo '<div class="background-image-cover" style="background-image:url(' . $background_image['url'] . ');"></div>'; } ?>
    
    <?php 
    get_template_part( 'snippets/snippet', 'top-border' ); ?>

    <div class="split-module-inner split-module-<?php echo $flex_index; ?> w-[85%] mx-auto px-4 pt-[6em] <?php if(!$remove_bottom_padding) { echo 'pb-[6em]'; } ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 items-center">
            
            <!-- Text Column -->
            <div class="<?php if (get_sub_field('centre_align')) { echo 'centre_align'; } ?> md:max-w-full shrink-0 grow pad <?php echo $is_right ? 'order-1 md:order-2' : 'order-1'; ?>" <?php echo $is_right ? 'data-aos="fade-left"' : 'data-aos="fade-right"'; ?>>

                <div class="split-text-holder">
                    <h6 class="section-title-column font-semibold coffee uppercase pr-[10px] inline-block relative mb-[10px] tracking-[1.5px]">
                        <?php echo get_sub_field('title'); ?>
                    </h6>
                    <h2 class="ed-section-title text-[3em] font-bold mb-[0.3em] 
                    <?php if (get_sub_field('title_and_button_colour_override') == 'latte') { echo 'text-rockschool-latte'; 
                    } elseif (get_sub_field('title_and_button_colour_override') == 'yellow') { echo 'text-rockschool-yellow'; 
                    }  elseif (get_sub_field('title_and_button_colour_override') == 'teal') { echo 'text-rockschool-teal'; 
                    }  elseif (get_sub_field('title_and_button_colour_override') == 'pink') { echo 'text-rockschool-pink'; 
                    }  elseif (get_sub_field('title_and_button_colour_override') == 'purple') { echo 'text-rockschool-purple'; 
                    } ?>">
                        <?php echo get_sub_field('sub_title'); ?>
                    </h2>
                    <div class="text-edgray mb-[1em]"><?php echo get_sub_field('content'); ?></div>
                    <?php if ($button_link) : ?>
                        <div class="items-center mt-5.5">
                            <a href="<?php echo esc_url($button_link); ?>">
                                <button><?php echo get_sub_field('button_text'); ?></button>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Image Column (with mask) -->
            <div class="md:max-w-full grow relative <?php echo $is_right ? 'order-2 md:order-1' : 'order-2'; ?>" <?php echo $is_right ? 'data-aos="fade-right"' : 'data-aos="fade-left"'; ?>>
                <?php if ($video || $image) : ?>

                    <div class="split-image-holder">

                        <?php if ($video) : ?>
                            <video 
                                class="w-full h-auto lazy-video"
                                playsinline
                                muted
                                loop
                                preload="none"
                                data-src="<?php echo esc_url($video['url']); ?>"
                                poster="<?php echo esc_url($image['sizes']['square'] ?? ''); ?>"
                            >
                            </video>

                        <?php else : ?>

                            <?php if ($mask_style == 'pick' || $mask_style == 'circles' || $mask_style == 'circles-2') : ?>

                                <?php if ($mask_style == 'pick') : ?>

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 578.81 578.81" class="inline-svg" width="700" height="auto" style="max-width: 100%;">

                                      <defs>
                                        <style>
                                          .cls-1 { fill: #4CADC2; }
                                          .cls-2 { fill: #fff; }
                                        </style>
                                        <mask id="myMask-<?php echo $flex_index; ?>" maskUnits="userSpaceOnUse" x="0" y="0" width="578.81" height="578.81">
                                          <use href="#mask-shape-<?php echo $flex_index; ?>" fill="white" transform="scale(1, 1) translate(0, -0)" />
                                        </mask>
                                      </defs>
                        
                                        <!-- artwork remains here -->
                                        <path class="cls-1" d="M227.79,113.38c-56.88-17.99-116.44-17.97-173.25,0C22.43,123.17,0,153.98,0,188.3c0,5.06.48,10.13,1.41,15.05,15.56,83.37,57.42,157.67,121.03,214.88,5.13,4.57,11.77,7.09,18.71,7.09s13.59-2.52,18.71-7.09c63.61-57.21,105.46-131.51,121.03-214.87.94-4.93,1.42-10,1.42-15.06,0-34.32-22.42-65.13-54.53-74.92"/>
                                        <path class="cls-1" d="M524.28,113.38c-56.88-17.99-116.44-17.97-173.25,0-32.11,9.79-54.54,40.6-54.54,74.92,0,5.06.48,10.13,1.41,15.05,15.56,83.37,57.42,157.67,121.03,214.88,5.13,4.57,11.77,7.09,18.71,7.09s13.59-2.52,18.71-7.09c63.61-57.21,105.46-131.51,121.03-214.87.94-4.93,1.42-10,1.42-15.06,0-34.32-22.42-65.13-54.53-74.92"/>
                                      
                                        <!-- Your mask shape path -->
                                        <path id="mask-shape-<?php echo $flex_index; ?>" class="cls-2 mask-path" d="M418.7,20.13c-84.89-26.84-173.79-26.82-258.59,0-47.92,14.61-81.4,60.59-81.4,111.82,0,7.56.71,15.12,2.11,22.47,23.23,124.43,85.69,235.33,180.64,320.72,7.65,6.83,17.57,10.58,27.93,10.58s20.28-3.76,27.93-10.59c94.94-85.38,157.41-196.28,180.64-320.71,1.41-7.35,2.11-14.92,2.11-22.48,0-51.22-33.46-97.2-81.38-111.81"/>

                                <?php elseif ($mask_style =='circles') : ?>

                                    <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" class="inline-svg" viewBox="0 0 602.74 607.21">
                                      <defs>
                                        <style>
                                          .c-1-cls-1 {
                                            fill: #ffce7b;
                                          }

                                          .c-1-cls-2 {
                                            fill: #fff;
                                          }
                                        </style>
                                        <mask id="myMask-<?php echo $flex_index; ?>" maskUnits="userSpaceOnUse" x="0" y="0" width="602.74" height="602.74">
                                          <use href="#mask-shape-<?php echo $flex_index; ?>" fill="white" transform="scale(1, 1) translate(0, -0)" />
                                        </mask>
                                      </defs>

                                        <path class="c-1-cls-1" d="M431.33,356.43c-94.67,0-171.41-76.74-171.41-171.41S336.66,13.62,431.33,13.62s171.41,76.74,171.41,171.41-76.74,171.41-171.41,171.41"/>
                                        <path class="c-1-cls-1" d="M297.55,607.21c-94.67,0-171.41-76.74-171.41-171.41s76.74-171.41,171.41-171.41,171.41,76.74,171.41,171.41-76.74,171.41-171.41,171.41"/>
                                        <path class="c-1-cls-1" d="M159.94,363.66C71.61,363.66,0,292.05,0,203.72S71.61,43.78,159.94,43.78s159.94,71.61,159.94,159.94-71.61,159.94-159.94,159.94"/>
                                        <path id="mask-shape-<?php echo $flex_index; ?>" class="c-1-cls-2" d="M13.78,242.64c0-88.33,71.61-159.94,159.94-159.94,20.52,0,40.14,3.87,58.17,10.91C260.24,38.05,318,0,384.66,0c94.66,0,171.41,76.74,171.41,171.41,0,69.78-41.71,129.82-101.55,156.56,17.83,27.04,28.23,59.4,28.23,94.21,0,94.67-76.74,171.41-171.41,171.41s-171.41-76.74-171.41-171.41c0-7.75.52-15.38,1.52-22.86-72.86-14.93-127.67-79.41-127.67-156.69"/>

                                <?php elseif ($mask_style =='circles-2') : ?>

                                    <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" class="inline-svg" viewBox="0 0 602.73 607.21">
                                      <defs>
                                        <style>
                                          .c-2-cls-1 {
                                            fill: #8f807d;
                                          }

                                          .c-2-cls-2 {
                                            fill: #8f807d;
                                          }
                                        </style>
                                        <mask id="myMask-<?php echo $flex_index; ?>" maskUnits="userSpaceOnUse" x="0" y="0" width="602.74" height="602.74">
                                          <use href="#mask-shape-<?php echo $flex_index; ?>" fill="white" transform="scale(1, 1) translate(0, -0)" />
                                        </mask>
                                      </defs>

                                      <path class="c-2-cls-2" d="M171.41,356.43c94.67,0,171.41-76.74,171.41-171.41S266.07,13.62,171.41,13.62,0,90.36,0,185.02s76.74,171.41,171.41,171.41"/>
                                      <path class="c-2-cls-2" d="M305.18,607.21c94.67,0,171.41-76.74,171.41-171.41s-76.74-171.41-171.41-171.41-171.41,76.74-171.41,171.41,76.74,171.41,171.41,171.41"/>
                                      <path class="c-2-cls-2" d="M442.79,363.66c88.33,0,159.94-71.61,159.94-159.94s-71.61-159.94-159.94-159.94-159.94,71.61-159.94,159.94,71.61,159.94,159.94,159.94"/>
                                      <path id="mask-shape-<?php echo $flex_index; ?>" class="c-2-cls-1" d="M588.96,242.64c0-88.33-71.61-159.94-159.94-159.94-20.52,0-40.14,3.87-58.17,10.91C342.5,38.05,284.73,0,218.08,0,123.41,0,46.67,76.74,46.67,171.41c0,69.79,41.71,129.82,101.55,156.56-17.83,27.04-28.23,59.4-28.23,94.21,0,94.67,76.74,171.41,171.41,171.41s171.41-76.74,171.41-171.41c0-7.75-.52-15.38-1.52-22.86,72.86-14.93,127.67-79.41,127.67-156.69"/>

                                <?php endif; ?>
                                  
                                  <!-- masked image -->
                                  <image 
                                    href="<?php echo esc_url($image['sizes']['square']); ?>" 
                                    x="0" 
                                    y="0" 
                                    mask="url(#myMask-<?php echo $flex_index; ?>)" 
                                    preserveAspectRatio="xMidYMid slice"
                                    class="inline-svg"
                                  />

                                </svg>

                            <?php else : ?>
                                <!-- non-masked image -->
                                <image 
                                    src="<?php echo esc_url($image['sizes']['square']); ?>" 
                                  />

                            <?php endif; ?>


                        <?php endif; ?>

                        

                    </div>

                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php 
    get_template_part( 'snippets/snippet', 'bottom-border' ); ?>

</section>

<style>
.masked-image {
    display: block;
    margin: auto;
}
.inline-svg {
    position: relative;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.split-text-holder {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.split-image-holder img {
    width: 100%;
}
@media(min-width: 768px) {
.split-image-holder,
.split-text-holder {
    padding: 0 1em;
}
}
@media(max-width: 767px) {
.split-image-holder {
    margin: 4em 0;
}
}
</style>

