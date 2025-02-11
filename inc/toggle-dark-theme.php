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

function rockschool_scripts() {
    // Enqueue the main stylesheet
    wp_enqueue_style( 'rockschool-style', get_stylesheet_uri(), array(), _S_VERSION );
    wp_style_add_data( 'rockschool-style', 'rtl', 'replace' );

    // Enqueue the navigation script
    wp_enqueue_script( 'rockschool-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

    // Enqueue the theme toggle script
    wp_enqueue_script( 'rockschool-theme-toggle', get_template_directory_uri() . '/js/theme-toggle.js', array(), _S_VERSION, true );

    // Enable comment-reply script if needed
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'rockschool_scripts' );