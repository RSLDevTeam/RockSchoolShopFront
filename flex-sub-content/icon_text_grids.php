<section class="py-24 px-4 lg:px-16"> 
    <div class="container mx-auto px-[12px] md:px-24 xl:px-12 max-w-[1300px] nanum2">
        <h1 class="text-center text-5xl pb-12">Industries we serve</h1>
        <div class="grid grid-cols-1 lg:grid-cols-5 xl:grid-cols-5 gap-x-4 gap-y-28 lg:gap-y-16">
            <?php if( have_rows('block') ): ?>
                <?php while( have_rows('block') ): the_row(); ?>
                    <div class="relative group h-48 flex flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
                        <a href="<?php echo get_sub_field('link'); ?>" class="block">
                            <div class="h-28">
                                <div class="absolute -top-20 lg:top-[-10%] left-[5%] z-40 group-hover:top-[-40%] group-hover:opacity-[0.9] duration-300 w-[90%] h-48 bg-rock-moonstone-50 rounded-xl justify-items-center align-middle">
                                    <img src="<?php echo esc_url(get_sub_field('icon_image')['url']); ?>" class="w-36 h-36 mt-6 m-auto" alt="<?php echo esc_attr(get_sub_field('icon')['alt']); ?>" title="<?php echo esc_attr(get_sub_field('icon')['title']); ?>" loading="lazy" width="200" height="200">
                                </div>
                            </div>
                            <div class="p-6 z-10 w-full">
                                <p class="mb-2 inline-block text-tg text-center w-full text-xl font-sans font-semibold leading-snug tracking-normal antialiased">
                                    <?php echo get_sub_field('title'); ?>
                                </p>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>