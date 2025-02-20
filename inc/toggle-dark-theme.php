<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package rockschool
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses themes-modes()
 */
function rockschool_theme_script() {
    ?>
    <script>
        // Check for saved theme in localStorage
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <?php
}
add_action('wp_head', 'rockschool_theme_script');
