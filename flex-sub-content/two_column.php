<section class="twoColumn ContentSection w-[75%] mx-auto px-4 mb-[5em]">
    <div class="grid grid-cols-1 md:grid-cols-2 items-center">
        <?php
        $position = get_sub_field('position'); // 'left' or 'right'
        $is_right = $position === 'right';

        $image = get_sub_field('image');
        $button_link = get_sub_field('button_link');
        $mask_vector = get_sub_field('mask_vector');
        ?>

        <!-- Text Column -->
        <div class="max-w-[50%] md:max-w-full shrink-0 grow pad <?php echo $is_right ? 'order-1 md:order-2' : 'order-1'; ?>" <?php echo $is_right ? 'data-aos="fade-left"' : 'data-aos="fade-right"'; ?>>
            <h6 class="section-title-column font-semibold coffee uppercase pr-[10px] inline-block relative mb-[10px] tracking-[1.5px]">
                <?php echo get_sub_field('title'); ?>
            </h6>
            <h2 class="ed-section-title text-[3em] font-bold mb-[0.3em]">
                <?php echo get_sub_field('sub_title'); ?>
            </h2>
            <div class="text-edgray mb-[3em]"><?php echo get_sub_field('content'); ?></div>
            <?php if ($button_link) : ?>
                <div class="items-center mt-5.5">
                    <a href="<?php echo esc_url($button_link); ?>" class="w-[5px] p-[15px] text-sm text-white font-medium bg-rock-moonstone-500 rounded-lg hover:bg-rock-moonstone-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        <?php echo get_sub_field('button_text'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Image Column (with mask) -->
        <div class="max-w-[50%] md:max-w-full grow relative <?php echo $is_right ? 'order-2 md:order-1' : 'order-2'; ?>" <?php echo $is_right ? 'data-aos="fade-right"' : 'data-aos="fade-left"'; ?>>
            <?php if ($image) : ?>
                <img 
                    data-src="<?php echo esc_url($image['sizes']['square']); ?>" 
                    alt="<?php echo esc_attr($image['alt']); ?>" 
                    class="lazy masked-image left-[25px] max-w-[75%] top-[65px] z-[2]"
                    style="mask-image: url('<?php echo $mask_vector; ?>');
                           -webkit-mask-image: url('<?php echo $mask_vector; ?>');"
                >
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
.masked-image {
    display: block;
    margin: auto;
}
</style>

<?php if ($mask_vector) : ?>

<style>
.masked-image {
    mask-size: contain;
    mask-repeat: no-repeat;
    mask-position: center;
    -webkit-mask-size: contain;
    -webkit-mask-repeat: no-repeat;
    -webkit-mask-position: center;
    display: block;
    margin: auto;
}
.vector-shape {
    visibility: hidden; 
}
img.masked-image-bg {
    position: absolute;
    top: 0;
    left: auto;
    right: auto;
    z-index: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
}
</style>

<?php endif; ?>