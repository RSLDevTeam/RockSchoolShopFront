<?php
// misc functions

// image sizes
add_image_size( 'square', 500, 500, true );
add_image_size( 'video-small', 650, 366, true );

// page id in body classes
function add_slug_body_class( $classes ) {
    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

// close flex content elements when opening page
function my_acf_admin_head() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.layout').not('.clones .layout').addClass('-collapsed');
    });
    </script>
    <?php
}
add_action('acf/input/admin_head', 'my_acf_admin_head');

// ACF Google Maps API Key (get from defined global ACF field)
function maps_acf_init() {
    $key = get_field('googel_map_api_key', 'option');
    acf_update_setting('google_api_key', $key);
}
add_action('acf/init', 'maps_acf_init');

// Disable comments
add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
     
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
 
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 
    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});
 
// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
 
// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);
 
// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
 
// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});