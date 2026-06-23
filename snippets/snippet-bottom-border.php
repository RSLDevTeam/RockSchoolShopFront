<?php 
// bottom-border-graphic
if ($enable_bottom_border && $bottom_border_colour) : ?>

        <?php if ( $bottom_border_vector != 'none' ) : ?>

            <img class="section-bottom-border vector-border-<?php echo $bottom_border_vector; ?>" src="<?php echo get_stylesheet_directory_uri() . '/img/bottom-border-' . $bottom_border_vector . '-' . $bottom_border_colour . '.svg'; ?>" />

        <?php endif; ?>

        <div class="section-border <?php 
            if ($bottom_border_colour == 'yellow') { 
                echo 'bg-rockschool-yellow'; 
            } elseif ($bottom_border_colour == 'latte') { 
                echo 'bg-rockschool-latte'; 
            } elseif ($bottom_border_colour == 'teal') { 
                echo 'bg-rockschool-teal'; 
            } elseif ($bottom_border_colour == 'pink') { 
                echo 'bg-rockschool-pink'; 
            } elseif ($bottom_border_colour == 'purple') { 
                echo 'bg-rockschool-purple'; 
            } ?>">
        </div>

    <?php endif; ?>