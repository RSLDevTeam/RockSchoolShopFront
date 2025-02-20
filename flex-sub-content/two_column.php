<section class="twoColumn ContentSection w-[80%] mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-2">
        <?php
        $position = get_sub_field('position');
        if ($position == 'right') : ?>
        <!-- txt -->
        <div class="max-w-[50%] md:max-w-full shrink-0 grow pad">
            <h6 class="section-title-column font-semibold text-rock-moonstone-600 uppercase pr-[10px] inline-block relative mb-[10px] tracking-[1.5px]"><?php echo get_sub_field('title'); ?></h6>
            <h2 class="ed-section-title mb-[9px]"><?php echo get_sub_field('sub_title'); ?></h2>
            <p class="text-edgray"><?php echo get_sub_field('content'); ?> </p>
            <?php
            $button_link = get_sub_field('button_link');
            if ($button_link) : ?>
            <div class="items-center mt-5.5">
                <a href="<?php echo esc_url($button_link); ?>" class="w-[5px] p-[15px] text-sm text-white font-medium bg-rock-moonstone-500 rounded-lg hover:bg-rock-moonstone-600 focus:ring-4 focus:outline-none focus:ring-blue-300"><?php echo get_sub_field('button_text'); ?></a>
            </div>
            <?php endif; ?>
        </div>
        <!-- img -->
        <div class="max-w-[50%] md:max-w-full grow relative">
            <?php
            $image = get_sub_field('image');
            if ($image) : ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/about-img-vector.svg" alt="About Image" class="max-h-[75%] z-[1]">
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="absolute left-[25px] max-w-[75%] top-[65px] z-[2]">
            <?php endif; ?>
        </div>
        <?php else : ?>
        <!-- img -->
        <div class="max-w-[50%] md:max-w-full grow relative">
            <?php
            $image = get_sub_field('image');
            if ($image) : ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/about-img-vector.svg" alt="About Image" class="max-h-[75%] z-[1]">
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="absolute left-[25px] max-w-[75%] top-[65px] z-[2]">
            <?php endif; ?>
        </div>
        <!-- txt -->
        <div class="max-w-[50%] md:max-w-full shrink-0 grow pad">
            <h6 class="section-title-column font-semibold text-rock-moonstone-600 uppercase pr-[10px] inline-block relative mb-[10px] tracking-[1.5px]"><?php echo get_sub_field('title'); ?></h6>
            <h2 class="ed-section-title mb-[9px]"><?php echo get_sub_field('sub_title'); ?></h2>
            <p class="text-edgray pb-1.5"><?php echo get_sub_field('content'); ?> </p>
            <?php
            $button_link = get_sub_field('button_link');
            if ($button_link) : ?>
            <div class="items-center mt-5.5">
                <a href="<?php echo esc_url($button_link); ?>" class="w-[5px] p-[15px] text-sm text-white font-medium bg-rock-moonstone-500 rounded-lg hover:bg-rock-moonstone-600 focus:ring-4 focus:outline-none focus:ring-blue-300"><?php echo get_sub_field('button_text'); ?></a>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>