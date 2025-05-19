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
        <div class="w-[80%] mx-auto">

            <div class="lg:pr-[2em] mb-12">
                <h6 class="section-title-column font-semibold uppercase pr-[10px] inline-block relative mb-[10px] tracking-[1.5px]" data-aos="zoom-in">
                    <?php echo get_sub_field('title'); ?>
                </h6>
                <h2 class="section-title mb-[9px] text-[3em] font-bold mb-[0.3em]" data-aos="zoom-in">
                    <?php echo get_sub_field('sub_title'); ?>
                </h2>
            </div>

            <?php if (have_rows('columns')) : ?>
                <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                    <?php while (have_rows('columns')) : the_row(); ?>
                        <div class="prose max-w-none text-white" data-aos="zoom-in">
                            <?php echo get_sub_field('content'); ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>