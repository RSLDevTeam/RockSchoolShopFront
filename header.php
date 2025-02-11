<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rockschool
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body  class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white" <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'rockschool' ); ?></a>
	<header class="site-header">
        <div class="container">
            <div class="logo">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Rockschool-OG-G1-3-Dark.svg" alt="<?php bloginfo( 'name' ); ?>">
                    </a>
                <?php endif; ?>
            </div>
            <nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-expanded="false" aria-controls="primary-menu">
					<span class="hamburger"></span>
					<span class="screen-reader-text"><?php esc_html_e('Menu', 'rockschool'); ?></span>
				</button>
				<?php
				wp_nav_menu(array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'nav-menu',
				));
				?>
			</nav>
            <div class="header-actions">
                <a href="<?php echo esc_url( wp_login_url() ); ?>" class="login-link">Login</a>
                <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="register-link">Teach Rock School</a>
            </div>
        </div>
    </header>

	<h1 class="text-3xl font-bold underline"> Hello world! </h1>

	<button id="theme-toggle" class="p-2 bg-gray-200 dark:bg-gray-700 rounded">
  		<span id="theme-icon">🌙</span> <!-- Moon icon for dark mode -->
	</button>