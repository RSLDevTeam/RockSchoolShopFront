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

// ACF options pages
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Rock School Theme Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'icon_url'      => 'dashicons-marker',
        'position'      => 2
    ));
}

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

function register_footer_menu() {
    register_nav_menus(
        array(
            'footer-menu' => __('Footer Menu', 'rockschool'),
            'footer-menu-2' => __('Footer Menu 2', 'rockschool'),
        )
    );
}
add_action('after_setup_theme', 'register_footer_menu');


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

function rockschool_scripts() {

    // Enqueue jQuery
    wp_enqueue_script('jquery');
    
    // Enqueue the main stylesheet
    wp_enqueue_style( 'rockschool-style', get_stylesheet_uri(), array(), _S_VERSION );
    wp_style_add_data( 'rockschool-style', 'rtl', 'replace' );

    // Enqueue the navigation script
    wp_enqueue_script( 'rockschool-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

    // Enqueue the theme mode script
    wp_enqueue_script( 'rockschool-theme-mode', get_template_directory_uri() . '/js/theme-mode.js', array(), _S_VERSION, true );

    // Enqueue the theme header fixed script
    wp_enqueue_script( 'rockschool-fixed-header', get_template_directory_uri() . '/js/fixed-header.js', array(), _S_VERSION, true );

    // Enable comment-reply script if needed
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // Slick.js 
    wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/css/slick.css', array(), filemtime( get_stylesheet_directory() . '/css/slick.css' ) );
    wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/js/slick.js', array('jquery'), filemtime( get_stylesheet_directory() . '/js/slick.js' ), true );

    // AOS Library
    wp_enqueue_style('aos', get_stylesheet_directory_uri() . '/assets/vendor/aos/aos.css', [], null);
    wp_enqueue_script('aos', get_stylesheet_directory_uri() . '/assets/vendor/aos/aos.js', [], null, true);

    // Compiled stylesheet 
    wp_enqueue_style( 'output', get_stylesheet_directory_uri() . '/css/output.css', array(), filemtime( get_stylesheet_directory() . '/css/output.css' ) );

    // Custom JS 
    wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/js/custom.js', array(), filemtime( get_stylesheet_directory() . '/js/custom.js' ) );

    // Custom stylesheet 
    wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/css/rs.min.css', array(), filemtime( get_stylesheet_directory() . '/css/rs.min.css' ) );
    
}
add_action( 'wp_enqueue_scripts', 'rockschool_scripts' );

/**
 * Api Directory functions.
 */
require get_template_directory() . '/apis/api-loader.php';


