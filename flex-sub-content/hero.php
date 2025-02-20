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