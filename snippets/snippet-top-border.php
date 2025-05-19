<?php 
// top-border-graphic
if ($enable_top_border && $top_border_colour) : ?>
    <div class="section-border <?php 
        if ($top_border_colour == 'yellow') { 
            echo 'bg-rockschool-yellow-900'; 
        } elseif ($top_border_colour == 'latte') { 
            echo 'bg-rockschool-latte'; 
        } elseif ($top_border_colour == 'teal') { 
            echo 'bg-rockschool-teal'; 
        } elseif ($top_border_colour == 'pink') { 
            echo 'bg-rockschool-pink'; 
        } elseif ($top_border_colour == 'purple') { 
            echo 'bg-rockschool-purple'; 
        } ?>">
    </div>
    <?php if ( $top_border_vector != 'none' ) : ?>

        <img class="section-top-border vector-border-<?php echo $top_border_vector; ?>" src="<?php echo get_stylesheet_directory_uri() . '/img/top-border-' . $top_border_vector . '-' . $top_border_colour . '.svg'; ?>" />

    <?php endif; ?>
<?php endif; ?>