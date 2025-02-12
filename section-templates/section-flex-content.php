<?php
/**
* Flexible Content (ACF 'page builder')
*
* @package understrap
*/
 
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
 
// Check value exists.
if( have_rows('flexible_elements') ):
 
    // Loop through rows.
    while ( have_rows('flexible_elements') ) : the_row();
 
        if( get_row_layout() == 'hero' ): ?>

            <section class="hero">

                <?php 
                $image = get_sub_field('image');
                if( !empty( $image ) ): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="hero-background" />
                <?php endif; ?>

                <div class="container">
                    <div class="hero-content">
                        
                        <h1><?php echo get_sub_field('title'); ?></h1>
                        <p><?php echo get_sub_field('intro'); ?></p>

                        <?php 
                        $button_text = get_sub_field('button_text');
                        $button_link = get_sub_field('button_link');
                        render_acf_button($button_text, $button_link);
                        ?>

                    </div>
                </div>

            </section>

        <?php elseif( get_row_layout() == 'next_element_here' ): ?>

            <!-- somehting -->

        <?php endif;

    endwhile;

endif;



