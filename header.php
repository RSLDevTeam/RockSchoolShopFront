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

<body  class="bg-rock-alabaster-50 dark:bg-rock-gray-900 text-rock-gray-950 dark:text-rock-alabaster-50" <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'rockschool' ); ?></a>
	<header class="py-2.5 border-b border-gray-300">
        <div class="flex justify-between items-center">
            <div class="logo">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Rockschool-OG-G1-3-Dark.svg" alt="<?php bloginfo( 'name' ); ?>">
                    </a>
                <?php endif; ?>
            </div>
			<nav id="site-navigation" class="main-navigation text-rock-gray-900 dark:text-rock-alabaster-50" role="navigation">
				<div class="container mx-auto flex items-center justify-between p-4">
					
					<!-- Mobile Menu Toggle Button -->
					<button
					id="menu-toggle"
					class="md:hidden p-2 focus:outline-none"
					aria-expanded="false"
					aria-controls="primary-menu"
					>
						<span class="block w-6 h-0.5 bg-rock-alabaster mb-1"></span>
						<span class="block w-6 h-0.5 bg-rock-alabaster mb-1"></span>
						<span class="block w-6 h-0.5 bg-rock-alabaster"></span>
						<span class="screen-reader-text"><?php esc_html_e('Menu', 'rockschool'); ?></span>
					</button>

					<!-- Desktop Menu -->
					<div class="hidden md:flex md:items-center md:space-x-6">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'flex space-x-6',
						'container'      => false,
					));
					?>
					</div>
				</div>

				<!-- Mobile Menu -->
				<div id="mobile-menu" class="md:hidden bg-rock-moonstone-700">
					<?php
					wp_nav_menu(array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu-mobile',
					'menu_class'     => 'flex flex-col space-y-4 p-4',
					'container'      => false,
					));
					?>
				</div>
			</nav>
            <div class="header-actions">
                <a href="<?php echo esc_url( wp_login_url() ); ?>" class="login-link">Login</a>
                <a href="<?php echo esc_url( wp_registration_url() ); ?>" class="register-link">Teach Rock School</a>
            </div>
        </div>
    </header>
	
	<button id="theme-toggle" class="relative z-0 inline-grid gap-0.5 rounded-full bg-gray-950/5 p-0.75 text-gray-950 dark:bg-white/10 dark:text-white" id="headlessui-radiogroup-:r6:" role="radiogroup">
		<span id="theme-icon" class="rounded-full p-1.5 *:size-7 data-checked:bg-white data-checked:inset-ring data-checked:ring data-checked:ring-gray-950/10 data-checked:inset-ring-white/10 sm:p-0 dark:data-checked:bg-gray-700 dark:data-checked:text-white dark:data-checked:ring-transparent" aria-label="Dark theme" id="headlessui-radio-:r9:" role="radio" aria-checked="false" tabindex="-1" data-headlessui-state="">
			<svg viewBox="0 0 28 28" fill="none">
				<path d="M10.5 9.99914C10.5 14.1413 13.8579 17.4991 18 17.4991C19.0332 17.4991 20.0176 17.2902 20.9132 16.9123C19.7761 19.6075 17.109 21.4991 14 21.4991C9.85786 21.4991 6.5 18.1413 6.5 13.9991C6.5 10.8902 8.39167 8.22304 11.0868 7.08594C10.7089 7.98159 10.5 8.96597 10.5 9.99914Z" stroke="currentColor" stroke-linejoin="round"></path>
				<path d="M16.3561 6.50754L16.5 5.5L16.6439 6.50754C16.7068 6.94752 17.0525 7.29321 17.4925 7.35607L18.5 7.5L17.4925 7.64393C17.0525 7.70679 16.7068 8.05248 16.6439 8.49246L16.5 9.5L16.3561 8.49246C16.2932 8.05248 15.9475 7.70679 15.5075 7.64393L14.5 7.5L15.5075 7.35607C15.9475 7.29321 16.2932 6.94752 16.3561 6.50754Z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
				<path d="M20.3561 11.5075L20.5 10.5L20.6439 11.5075C20.7068 11.9475 21.0525 12.2932 21.4925 12.3561L22.5 12.5L21.4925 12.6439C21.0525 12.7068 20.7068 13.0525 20.6439 13.4925L20.5 14.5L20.3561 13.4925C20.2932 13.0525 19.9475 12.7068 19.5075 12.6439L18.5 12.5L19.5075 12.3561C19.9475 12.2932 20.2932 11.9475 20.3561 11.5075Z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
			</svg>
		</span>
	</button>