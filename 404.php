<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package rockschool
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<div class="container mx-auto p-2.5 max-w-[1440px] z-1">
				<div class="tailwind-cols grid grid-cols-1 lg:grid-cols-3 pt-[1.5em] pb-[2em] gap-8 w-[85%] mx-auto px-4">
					<div class="profile-col-1 col-span-1">
						<div class="mb-6">
							<div class="provider-photo aos-init aos-animate" data-aos="zoom-in">
								<img src="<?php echo get_template_directory_uri(); ?>/img/guitar-404.png" alt="">
							</div>
						</div>

					</div>

					<div class="profile-col-2 col-span-1 lg:col-span-2">
						<div class="prose max-w-none">
							<header class="provider-header">
								<h1 data-aos="zoom-in" class="aos-init aos-animate"> Oops! Looks like the tune’s gone missing. </h1>
							</header>
							<div class="provider-biog aos-init aos-animate" data-aos="zoom-in">
								<p> You’ve hit a flat note! 
									<br/> Don’t worry, let’s get you back in key. </p>
							</div>
							<div class="w-full flex justify-center items-center mt-8 aos-init aos-animate" data-aos="zoom-in">
								<a href="<?php echo esc_url(home_url('/')); ?>"> <button> Go to Home </button> </a>
							</div>
					</div>
				</div>
			</div>
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
