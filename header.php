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
<html <?php language_attributes(); ?> class="dark" style="scroll-behavior: smooth;">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body  class="bg-rock-alabaster-50 dark:bg-rock-gray-900 text-rock-gray-950 dark:text-rock-alabaster-50" <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

<?php // page options
$enable_absolute_header = get_field('enable_absolute_header');
?>
	
	<header class="<?php if ($enable_absolute_header) { echo 'absolute absolute-header'; } else { echo 'border-gray-300 bg-rock-alabaster-50 dark:bg-rock-gray-900 text-rock-gray-950 dark:text-rock-alabaster-50'; } ?> z-3 ">
		<?php if (get_field('enable_top_bar', 'option')) : ?>

			<div class="topbar bg-rockschool-darker flex justify-end items-center p-2.5">
				<nav class="relative" role="navigation">
				    <div class="container mx-auto flex items-center justify-between p-4">
				        <div class="topbar-navigation ml-auto md:flex md:items-center md:space-x-6 relative lg:items-center lg:gap-[60px] xxs:gap-[30px]">
				            <ul id="topbar-menu" class="flex text-[17px] ed-header-nav font-normal space-x-6 nav-menu">
				                <!-- <li class="menu-item"><a href="/teach-rockschool/">Teach Rockschool</a></li> -->
				                <li class="menu-item"><a href="https://backstage.rockschool.io/" target="_blank"><svg id="uuid-1479b198-69b7-4687-ac20-930e91e96471" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 27.2 28.73"><defs><clipPath id="uuid-5242315f-e04f-4b56-ba8a-d4c281ba2d79"><path d="M13.72,26.96c7.45,0,13.48-6.04,13.48-13.48S21.17,0,13.72,0,.24,6.04.24,13.48s6.03,13.48,13.48,13.48" style="fill: none;"/></clipPath></defs><g style="clip-path: url(#uuid-5242315f-e04f-4b56-ba8a-d4c281ba2d79);"><path d="M13.48,26.96c7.45,0,13.48-6.04,13.48-13.48S20.92,0,13.48,0,0,6.04,0,13.48s6.03,13.48,13.48,13.48" style="fill: #fafafa;"/><path d="M17.48,12.68c1.2-1.07,1.96-2.61,1.96-4.35,0-3.24-2.62-5.86-5.86-5.86s-5.86,2.62-5.86,5.86c0,1.73.77,3.27,1.96,4.35-2.73,1.42-4.6,4.26-4.6,7.55,0,4.7,3.81,8.5,8.5,8.5s8.5-3.81,8.5-8.5c0-3.29-1.87-6.13-4.6-7.55" style="fill: #0f0f0f;"/></g></svg> Login</a></li>
				            </ul>
				        </div>
				    </div>
				</nav>
			</div>

		<?php endif; ?>

		<div class="header-main-inner flex justify-between items-center p-2.5 <?php if (!$enable_absolute_header) echo 'bg-rock-alabaster-50 dark:bg-rock-gray-900'; ?>">

            <div class="w-[180px]">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">	  
                	<img class="header-logo light" src="<?php echo get_stylesheet_directory_uri(); ?>/img/rs-text-logo.svg" alt="<?php bloginfo( 'name' ); ?>">
                    <img class="header-logo dark" src="<?php echo get_stylesheet_directory_uri(); ?>/img/rs-text-logo.svg" alt="<?php bloginfo( 'name' ); ?>">

                </a>
            </div>

			<nav id="site-navigation" class="main-navigation relative <?php if ($enable_absolute_header) { echo 'text-rock-alabaster-50 dark:text-rock-alabaster-50'; } else { echo 'text-rock-gray-900 dark:text-rock-alabaster-50'; } ?>" role="navigation">

				<div class="container mx-auto flex items-center justify-between p-4">
					
					<!-- Desktop Menu -->
					<div class="sm:hidden md:flex md:items-center md:space-x-6 relative lg:items-center lg:gap-[60px] xxs:gap-[30px]">
						<?php
						wp_nav_menu(array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							'menu_class'     => 'flex text-[17px] ed-header-nav font-normal space-x-6',
							'container'      => false,
						));
						?>
					</div>

				</div>

			</nav>

			<div class="mobile-nav-toggle">
            	<div id="nav-icon">
				  	<span></span>
				  	<span></span>
				  	<span></span>
				  	<span></span>
				</div>
			</div>
			
        </div>

        <div class="mobile-nav-pane" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/profile-bg.svg);">

    		<!-- Mobile Menu -->
			<div id="mobile-menu" class="md:hidden">
				<?php
				wp_nav_menu(array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu-mobile',
				'menu_class'     => 'flex flex-col space-y-4 p-4',
				'container'      => false,
				));
				?>

				<div class="mobile-nav-socials">
					<?php get_template_part( 'snippets/snippet', 'socials' ); ?>
				</div>

			</div>

		</div>

    </header>

	
	<!-- <button id="theme-toggle" class="fixed bottom-4 right-0 rounded-l-full bg-gray-950/5 p-0.75 text-gray-950 dark:bg-white/10 dark:text-white" role="radiogroup">
		<span id="theme-icon" class="rounded-full p-1.5 *:size-7 data-checked:bg-white data-checked:inset-ring data-checked:ring data-checked:ring-gray-950/10 data-checked:inset-ring-white/10 sm:p-0 dark:data-checked:bg-gray-700 dark:data-checked:text-white dark:data-checked:ring-transparent" aria-label="Dark theme" role="radio" aria-checked="false" tabindex="-1" data-headlessui-state="">
			<svg viewBox="0 0 28 28" fill="none">
				<path d="M10.5 9.99914C10.5 14.1413 13.8579 17.4991 18 17.4991C19.0332 17.4991 20.0176 17.2902 20.9132 16.9123C19.7761 19.6075 17.109 21.4991 14 21.4991C9.85786 21.4991 6.5 18.1413 6.5 13.9991C6.5 10.8902 8.39167 8.22304 11.0868 7.08594C10.7089 7.98159 10.5 8.96597 10.5 9.99914Z" stroke="currentColor" stroke-linejoin="round"></path>
				<path d="M16.3561 6.50754L16.5 5.5L16.6439 6.50754C16.7068 6.94752 17.0525 7.29321 17.4925 7.35607L18.5 7.5L17.4925 7.64393C17.0525 7.70679 16.7068 8.05248 16.6439 8.49246L16.5 9.5L16.3561 8.49246C16.2932 8.05248 15.9475 7.70679 15.5075 7.64393L14.5 7.5L15.5075 7.35607C15.9475 7.29321 16.2932 6.94752 16.3561 6.50754Z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
				<path d="M20.3561 11.5075L20.5 10.5L20.6439 11.5075C20.7068 11.9475 21.0525 12.2932 21.4925 12.3561L22.5 12.5L21.4925 12.6439C21.0525 12.7068 20.7068 13.0525 20.6439 13.4925L20.5 14.5L20.3561 13.4925C20.2932 13.0525 19.9475 12.7068 19.5075 12.6439L18.5 12.5L19.5075 12.3561C19.9475 12.2932 20.2932 11.9475 20.3561 11.5075Z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
			</svg>
		</span>
	</button> --> 