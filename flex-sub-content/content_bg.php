<section class="contentBg ContentSection">
    <div class="bg-rock-moonstone-500 p-[10px] pt-4">
        <div class="w-[80%] mx-auto">
            <h6 class="section-title-column font-semibold uppercase pr-[10px] inline-block relative mb-[10px] tracking-[1.5px]"><?php echo get_sub_field('title'); ?></h6>
            <h2 class="section-title mb-[9px]"><?php echo get_sub_field('sub_title'); ?></h2>
            <p">
                <?php echo get_sub_field('content'); ?> 
            </p>
            <?php
            $button_link = get_sub_field('button_link');
            if ($button_link) : ?>
            <div class="items-center">
                <a href="<?php echo esc_url($button_link); ?>" class="w-[5px] p-[15px] text-sm text-white font-medium bg-rock-moonstone-500 rounded-lg hover:bg-rock-moonstone-600 focus:ring-4 focus:outline-none focus:ring-blue-300"><?php echo get_sub_field('button_text'); ?></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>