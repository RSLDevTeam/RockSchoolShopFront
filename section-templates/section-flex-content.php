<?php
/**
* Flexible Content (ACF 'page builder')
*
* @package understrap
*/
 
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
 
// Check value exists.
if( have_rows('flexible_elements') ):
 
    // Loop through rows.
    while ( have_rows('flexible_elements') ) : the_row();
 
        if( get_row_layout() == 'hero' ): ?>
            <section class="hero ContentSection">
                <div class="ed-banner-slider swiper relative">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <?php
                            $banner_bg_image = get_sub_field('image');
                            if ($banner_bg_image) : ?>
                                <div class="pt-[390px] md:pt-[300px] xs:pt-[280px] pb-[205px] bg-no-repeat bg-center bg-cover relative z-[1] before:absolute before:-z-[1] before:inset-0 before:bg-edblue/70 before:pointer-events-none"
                                    style="background-image: url('<?php echo esc_url($banner_bg_image["url"]); ?>');">
                            <?php else : ?>
                                <div class="pt-[390px] md:pt-[300px] xs:pt-[280px] pb-[205px] bg-no-repeat bg-center bg-cover relative z-[1] before:absolute before:-z-[1] before:inset-0 before:bg-edblue/70 before:pointer-events-none"
                                    style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/banner-bg-1.jpg');">
                            <?php endif; ?>						
                                <div class="mx-[10%] md:mx-[23 px] text-white">
                                        <h6 class="font-medium uppercase tracking-[3px] mb-[16px]"><?php echo get_sub_field('sub_title'); ?></span></h6>
                                        <h2 class="font-bold text-[clamp(35px,4.57vw,80px)] leading-[1.13] mb-[15px]"><?php echo get_sub_field('title'); ?></h2>
                                        <p class="leading-[1.75] mb-[41px]"><?php echo get_sub_field('intro'); ?></p>
                                        <div class="flex items-center gap-[20px]">
                                            <button class="px-5 rounded-full h-[50px] text-md font-medium border-0 focus:outline-none focus:ring transition text-white bg-rock-moonstone-500 hover:bg-rock-moonstone-600 active:bg-rock-moonstone-700 focus:ring-rock-moonstone-300" type="submit">Apply Now</button>
                                            <button class="px-5 rounded-full h-[50px] text-md font-medium border-1 border-white focus:outline-none focus:ring transition text-white hover:text-rock-moonstone-600 active:text-rock-moonstone-700 focus:ring-rock-moonstone-300" type="submit">About Us</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php elseif( get_row_layout() == 'hero_search' ): ?>
            <section class="heroSearch ContentSection">
                <div class="ed-banner-slider swiper relative">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <?php
                            $banner_bg_image = get_sub_field('image');
                            if ($banner_bg_image) : ?>
                                <div class="max-h-[100px] pt-[390px] md:pt-[300px] xs:pt-[280px] pb-[205px] bg-no-repeat bg-center bg-cover relative z-[1] before:absolute before:-z-[1] before:inset-0 before:bg-edblue/70 before:pointer-events-none"
                                    style="background-image: url('<?php echo esc_url($banner_bg_image["url"]); ?>');">
                            <?php else : ?>
                                <div class="pt-[390px] md:pt-[300px] xs:pt-[280px] pb-[205px] bg-no-repeat bg-center bg-cover relative z-[1] before:absolute before:-z-[1] before:inset-0 before:bg-edblue/70 before:pointer-events-none"
                                    style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/banner-bg-1.jpg');">
                            <?php endif; ?>	
                            <div class="mx-[10%] md:mx-[23 px] text-white">
                                <h6 class="font-medium uppercase tracking-[3px] mb-[16px]"><?php echo get_sub_field('sub_title'); ?></span></h6>
                                <h2 class="font-bold text-[clamp(35px,4.57vw,80px)] leading-[1.13] mb-[15px]"><?php echo get_sub_field('title'); ?></h2>
                            </div>
                            <?php
                                $search_field = get_sub_field('search');
                                if ($search_field) : ?>
                                <div class="absolute top-[98%] rounded-b-lg left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl">
                                    <form action="<?php echo home_url('/'); ?>" method="get" class="bg-white shadow-lg rounded-lgitems-center px-4 py-3 w-full">
                                        <h6 class="font-bold uppercase tracking-[3px] mb-[16px]"><?php echo get_sub_field('search_title'); ?></span></h6>   
                                        <div class="flex items-center gap-[20px]">                                   
                                            <input type="text" name="s" class="w-full px-4 py-2 text-lg focus:outline-none" placeholder="Search locations...">
                                            <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-rock-moonstone-950 bg-rock-moonstone-500 rounded-lg hover:bg-rock-moonstone-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                                </svg>
                                                <span class="sr-only">Search</span>
                                            </button>
                                         </div>
                                        
                                     </form>
                                </div>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        <?php elseif( get_row_layout() == 'two_column' ): ?>
            <section class="py-[120px] xl:py-[80px] md:py-[60px]">
                <div class="container mx-auto px-4">
                    <div class="grid md:grid-cols-1 lg:grid-cols-2 gap-[60px] xl:gap-[40px] items-center">
                        
                        <!-- Image Section -->
                        <div class="relative max-w-full lg:max-w-[50%] md:max-w-full">
                            <img src="assets/img/about-img.png" alt="About Image" class="w-full object-cover">
                            <img src="assets/img/about-img-vector.svg" alt="Vector" class="absolute -top-[25px] left-[25px] -z-[1] w-[90%]">
                        </div>

                        <!-- Text Section -->
                        <div class="max-w-full lg:max-w-[50%] md:max-w-full">
                            <h6 class="ed-section-sub-title">About Us</h6>
                            <h2 class="ed-section-title mb-2">Welcome to the Best School for Your Child</h2>
                            <p class="text-edgray">Curabitur nibh justo imperdiet non ex non tempus faucibus urna. Aliquam at elit vitae dui sagittis maximus eget vitae diam in fermentum.</p>

                            <!-- Info Section -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-[20px] border-b border-gray-300 pb-[30px] mb-[26px]">
                                <!-- Mission -->
                                <div class="flex items-center gap-[20px] xl:gap-[15px]">
                                    <div class="shrink-0 bg-edpurple h-[80px] xl:h-[70px] w-[80px] xl:w-[70px] rounded-lg flex items-center justify-center">
                                        <img src="assets/img/icon/target.svg" alt="Mission Icon">
                                    </div>
                                    <div>
                                        <h6 class="font-semibold text-[18px] text-edblue mb-1">Our Mission</h6>
                                        <p class="text-[16px] text-edgray">Aliquam erat volutpat nullam imperdiet.</p>
                                    </div>
                                </div>

                                <!-- Vision -->
                                <div class="flex items-center gap-[20px] xl:gap-[15px]">
                                    <div class="shrink-0 bg-edpurple h-[80px] xl:h-[70px] w-[80px] xl:w-[70px] rounded-lg flex items-center justify-center">
                                        <img src="assets/img/icon/book-light.svg" alt="Vision Icon">
                                    </div>
                                    <div>
                                        <h6 class="font-semibold text-[18px] text-edblue mb-1">Our Vision</h6>
                                        <p class="text-[16px] text-edgray">Ut vehicula dictumst maecenas ante.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Principal Info -->
                            <div class="flex flex-wrap items-center gap-4">
                                <div class="flex gap-x-[8px] items-center">
                                    <div class="rounded-full overflow-hidden w-[58px] h-[58px]">
                                        <img src="assets/img/user.png" alt="Principal" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-[18px] text-black">Ronald Richards</h5>
                                        <h6 class="text-edgray">Principal <span class="text-edpurple">Edutics</span></h6>
                                    </div>
                                </div>
                                <a href="#" class="ed-btn">Message Principal</a>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

        <?php endif;

    endwhile;

endif;



