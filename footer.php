<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rockschool
 */

?>

	<!-- Footer container -->
	<footer
	class="text-center text-[0.65em] leading-[1.5em] text-surface/75 bg-rock-alabaster-50 dark:bg-rock-gray-900 text-rock-gray-950 dark:text-rock-alabaster-50 lg:text-left">
		
		<div
		class="flex items-center justify-center border-b-2 border-neutral-200 p-6 dark:border-white/10 pt-[2.5em] pb-[2.5em]">

			<?php get_template_part( 'snippets/snippet', 'socials' ); ?>

		</div>


		<div class="mx-6 py-10 text-center md:text-left">

			<div class="grid-1 grid gap-8 md:grid-cols-2 lg:grid-cols-4 pt-[3em] max-w-[1300px] m-auto block mb-[2em]">
			
				<div class="footer-logo-holder">

	                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
	                    <img class="footer-logo light" src="<?php echo get_stylesheet_directory_uri(); ?>/img/rs-light-logo.svg" alt="<?php bloginfo( 'name' ); ?>">
	                	<img class="footer-logo dark" src="<?php echo get_stylesheet_directory_uri(); ?>/img/rs-dark-logo.svg" alt="<?php bloginfo( 'name' ); ?>">
	                </a>
					<?php echo get_field('intro', 'option'); ?>
				</div>

			<!-- Useful links section -->
			<div>
				<h4
				class="mb-4 flex justify-center font-semibold uppercase md:justify-start">
				Useful links
				</h4>

				<div class="flex justify-between items-center footer-menu">
		            <!-- Footer Menu -->
		            <?php
		            if (has_nav_menu('footer-menu')) {
		                wp_nav_menu(array(
		                    'theme_location' => 'footer-menu',
		                    'menu_class'     => 'flex flex-col space-y-1 text-md',
		                    'container'      => false,
		                    'depth'          => 1, 
							'link_before'    => '<span class="hover:underline">', 
		                    'link_after'     => '</span>', 
		                ));
		            } else {
		                echo '<p>No footer menu set.</p>';
		            }
		            ?>
	        	</div>
			</div>
			<div>
				<h4
				class="mb-4 flex justify-center font-semibold uppercase md:justify-start">
				Legal & Terms
				</h4>
				
				<div class="flex justify-between items-center footer-menu">
		            <!-- Footer Menu -->
		            <?php
		            if (has_nav_menu('footer-menu-2')) {
		                wp_nav_menu(array(
		                    'theme_location' => 'footer-menu-2',
		                    'menu_class'     => 'flex flex-col space-y-1 text-md',
		                    'container'      => false,
		                    'depth'          => 1, 
							'link_before'    => '<span class="hover:underline">', 
		                    'link_after'     => '</span>', 
		                ));
		            } else {
		                echo '<p>No footer menu set.</p>';
		            }
		            ?>
	        	</div>
			</div>
			<!-- Contact section -->
			<div>
				<h4
				class="mb-4 flex justify-center font-semibold uppercase md:justify-start">
				Contact
				</h4>
				<p class="mb-4 flex items-center justify-center md:justify-start">
					<?php echo get_field('address', 'option'); ?>
				</p>
				<p class="mb-4 flex items-center justify-center md:justify-start">
				
					<?php echo get_field('email', 'option'); ?>
				</p>
				<p class="mb-4 flex items-center justify-center md:justify-start">
				
					<?php echo get_field('telephone', 'option'); ?>
				</p>

			</div>
			</div>
		</div>

		<!--Copyright section-->
		<div class="bg-black/5 p-6 text-center">
			<span class="copyright-text">© <?php echo date('Y'); ?> Copyright Rockschool London Ltd. All rights reserved.</span>
			
		</div>
	</footer>
</div>

<?php wp_footer(); ?>

<script>AOS.init();</script>

</body>
</html>
