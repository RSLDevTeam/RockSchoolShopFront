<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package rockschool
 */

get_header();
?>


<main id="primary" class="site-main py-12 px-4 md:px-8">
	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('max-w-4xl mx-auto single-post'); ?>>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="mb-[3em]">
					<?php the_post_thumbnail('full', ['class' => 'mx-auto max-w-[900px] w-full h-auto rounded-md shadow']); ?>
				</div>
			<?php endif; ?>

			<header class="mb-6">
				<h1 class="mb-2"><?php the_title(); ?></h1>
				<div class="text-sm space-x-4">
					<?php
					rockschool_posted_on();
					// rockschool_posted_by();
					?>
				</div>
			</header>

			<div class="prose max-w-none">
				<?php
				the_content();

				wp_link_pages([
					'before' => '<div class="page-links mt-6 text-sm text-gray-600">' . esc_html__('Pages:', 'rockschool'),
					'after'  => '</div>',
				]);
				?>
			</div>

			<footer class="mt-8 border-t border-gray-200 pt-6">
				<?php rockschool_entry_footer(); ?>
			</footer>

		</article>

		<div class="max-w-4xl mx-auto mt-12">
			<?php the_post_navigation([
				'prev_text' => '<span class="text-sm text-gray-500 block">Previous</span><span class="text-lg font-semibold text-rockschool-teal">%title</span>',
				'next_text' => '<span class="text-sm text-gray-500 block">Next</span><span class="text-lg font-semibold text-rockschool-teal">%title</span>',
			]); ?>
		</div>

		<?php
		if ( comments_open() || get_comments_number() ) :
			echo '<div class="max-w-4xl mx-auto mt-12">';
			comments_template();
			echo '</div>';
		endif;

	endwhile;
	?>
</main>

<?php
get_sidebar();
get_footer();
