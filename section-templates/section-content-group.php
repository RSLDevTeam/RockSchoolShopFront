<?php
if (have_rows('content_section')) :

    while (have_rows('content_section')) : the_row();

            $title = get_sub_field('title');
            $description = get_sub_field('description');
            $buttons = get_sub_field('buttons');
            ?>
            <section class="container">
                <div class="flex flex-col items-center space-y-4">
                    <h1 class="text-2xl font-bold"><?php echo esc_html($title); ?></h1>
                    <div class="text-base leading-relaxed"><?php echo wp_kses_post($description); ?></div>
                    <?php if ($buttons) : ?>
                        <div class="flex space-x-2">
                            <?php foreach ($buttons as $button) : ?>
                                <button onclick="location.href='<?php echo esc_url($button['button_link']); ?>'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    <?php echo esc_html($button['button_text']); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
    <?php endwhile; ?>
<?php endif; ?>