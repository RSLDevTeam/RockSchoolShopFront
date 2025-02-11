<?php
/**
 * rockschool functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package rockschool
 */

if ( ! defined( '_S_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function rockschool_setup() {
    load_theme_textdomain( 'rockschool', get_template_directory() . '/languages' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    register_nav_menus( array( 'menu-1' => esc_html__( 'Primary', 'rockschool' ) ) );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'custom-background', apply_filters( 'rockschool_custom_background_args', array( 'default-color' => 'ffffff', 'default-image' => '' ) ) );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'custom-logo', array( 'height' => 250, 'width' => 250, 'flex-width' => true, 'flex-height' => true ) );
}
add_action( 'after_setup_theme', 'rockschool_setup' );

/**
 * Set the content width in pixels.
 */
function rockschool_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'rockschool_content_width', 640 );
}
add_action( 'after_setup_theme', 'rockschool_content_width', 0 );

/**
 * Register widget area.
 */
function rockschool_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'rockschool' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'rockschool' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'rockschool_widgets_init' );


/**
 * Automatically include all PHP files from the inc folder.
 */
function rockschool_include_inc_files() {
    $inc_dir = get_template_directory() . '/inc';

    // Check if the directory exists
    if (is_dir($inc_dir)) {
        // Get all PHP files in the inc directory
        $inc_files = glob($inc_dir . '/*.php');

        // Include each file
        foreach ($inc_files as $file) {
            if (is_file($file)) {
                require_once $file;
            }
        }
    }
}
add_action('after_setup_theme', 'rockschool_include_inc_files');

