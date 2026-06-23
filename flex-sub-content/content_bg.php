<section id="<?php echo get_sub_field('section_id'); ?>" class="contentBg ContentSection module-<?php echo $flex_index; ?>">
    <div class="<?php 
    if (get_sub_field('background_color') == 'yellow') { 
        echo 'bg-rockschool-yellow-900'; 
    } elseif (get_sub_field('background_color') == 'latte') { 
        echo 'bg-rockschool-latte'; 
    } elseif (get_sub_field('background_color') == 'teal') { 
        echo 'bg-rockschool-teal'; 
    } elseif (get_sub_field('background_color') == 'pink') { 
        echo 'bg-rockschool-pink'; 
    } elseif (get_sub_field('background_color') == 'purple') { 
        echo 'bg-rockschool-purple'; 
    } 
    ?> py-[4em] text-white">
        <div class="w-[80%] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
            <!-- Left Column: Heading -->
            <div class="lg:pr-[2em]">
                <h6 class="section-title-column font-semibold uppercase pr-[10px] inline-block relative mb-[10px] tracking-[1.5px]" data-aos="zoom-in">
                    <?php echo get_sub_field('title'); ?>
                </h6>
                <h2 class="section-title mb-[9px] text-[3em] font-bold mb-[0.3em]" data-aos="zoom-in">
                    <?php echo get_sub_field('sub_title'); ?>
                </h2>
            </div>

            <!-- Right Column: Content + Button -->
            <div class="flex flex-col gap-4" data-aos="zoom-in">
                <p>
                    <?php echo get_sub_field('content'); ?> 
                </p>
                <?php if ($button_link = get_sub_field('button_link')) : ?>
                    <a href="<?php echo esc_url($button_link); ?>" class="inline-block w-max px-6 py-3 text-sm text-white font-medium bg-rock-moonstone-500 rounded-lg hover:bg-rock-moonstone-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        <?php echo get_sub_field('button_text'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>