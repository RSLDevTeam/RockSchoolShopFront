<?php
/**
* Flexible Content (ACF 'page builder')
*
* @package understrap
*/
 
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
// Check value exists.
if( have_rows('two_column_content') ):
    // Loop through rows.
    while ( have_rows('two_column_content') ) : the_row();
        if( get_row_layout() == 'two_cloumn_content' ): ?>
            <div class="container mx-auto px-4 py-8">
                <div class="grid grid-cols-6 md:grid-cols-2 gap-8">
                    <div>
                        <?php 
                        $image = get_sub_field('image');
                        if( !empty( $image ) ): ?>
                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="hero-background" />
                        <?php endif; ?>
                    </div>
                    <div>
                        <p><?php echo get_sub_field('content'); ?></p>
                        <?php 
                        $button_text = get_sub_field('button_text');
                        $button_link = get_sub_field('button_link');
                        render_acf_button($button_text, $button_link);
                        ?>
                    </div>
                </div>
            </div>

            <section class="hero">

                

                <div class="container">
                    <div class="hero-content">
                        
                        <h1><?php echo get_sub_field('title'); ?></h1>
                        

                        

                    </div>
                </div>

            </section>

        <?php endif;

    endwhile;

endif;



