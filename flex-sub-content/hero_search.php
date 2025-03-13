<section class="heroSearch ContentSection">
    <div class="ed-banner-slider swiper relative">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <?php
                $banner_bg_image = get_sub_field('image');
                $banner_bg_video = get_sub_field('video');
                if ($banner_bg_image) : ?>
                    <div class="max-h-[100px] pt-[390px] md:pt-[300px] xs:pt-[280px] pb-[205px] bg-no-repeat bg-center bg-cover relative z-[1] before:absolute before:-z-[1] before:inset-0 before:bg-edblue/70 before:pointer-events-none"
                        style="background-image: url('<?php echo esc_url($banner_bg_image["url"]); ?>');"> 
                    <?php if ($banner_bg_video) : ?>
                        <div class="video-container absolute top-0 w-full h-full overflow-hidden">
                            <video class="w-full h-full object-cover" muted autoplay loop>
                                <source src="<?php echo esc_url($banner_bg_video); ?>">
                            </video>
                        </div>
                    <?php endif; ?>
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
                    <div class="absolute top-[98%] rounded-lg left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl">
                        <form action="<?php echo home_url('/'); ?>" method="get" class="bg-white shadow-lg rounded-lgitems-center px-4 py-3 w-full">
                            <h6 class="font-bold uppercase tracking-[3px] mb-[16px]"><?php echo get_sub_field('search_title'); ?></span></h6>   
                            <div class="flex items-center gap-[20px]">                                   
                                <input id="place-search" type="text" name="search" class="w-full px-4 py-2 text-lg focus:outline-none" placeholder="Search locations...">
                                <button type="submit" class="p-2.5 ms-2 text-sm text-white font-medium bg-rock-moonstone-500 rounded-lg hover:bg-rock-moonstone-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
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