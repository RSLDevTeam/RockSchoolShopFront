<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package rockschool
 */

get_header();

$posts_page_id       = get_option( 'page_for_posts' );
$archive_title       = is_home() && $posts_page_id ? get_the_title( $posts_page_id ) : get_the_archive_title();
$archive_description = is_home() && $posts_page_id ? get_the_excerpt( $posts_page_id ) : get_the_archive_description();
?>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

	<main id="primary" class="site-main py-12 px-4 md:px-8">
		<div class="w-[92%] md:w-[85%] mx-auto space-y-10">

			<header class="page-header text-center md:text-left">
				<h1 class="page-title mb-4"><?php echo esc_html( $archive_title ); ?></h1>

				<?php if ( $archive_description ) : ?>
					<div class="archive-description max-w-3xl mx-auto md:mx-0 text-lg text-rock-gray-700 dark:text-rock-alabaster-200">
						<?php echo wp_kses_post( $archive_description ); ?>
					</div>
				<?php endif; ?>
			</header>

			<?php if ( have_posts() ) : ?>

				<?php the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card featured-post grid lg:grid-cols-2 gap-8 items-stretch overflow-hidden shadow-xl border border-rock-gray-200 dark:border-rock-gray-700' ); ?>>
					<div class="relative overflow-hidden">
						<a href="<?php the_permalink(); ?>" class="block h-full">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="aspect-[16/10] lg:h-full">
									<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover transition duration-500 ease-out hover:scale-105' ) ); ?>
								</div>
							<?php else : ?>
								<div class="bg-rockschool-grey h-full min-h-[260px]"></div>
							<?php endif; ?>
						</a>
					</div>

					<div class="p-6 md:p-10 flex flex-col justify-center gap-4 post-card-body">
						<div class="flex flex-wrap items-center gap-3 text-xs font-semibold tracking-[1.5px] uppercase text-rock-gray-600 dark:text-rock-alabaster-300">
							<span><?php echo esc_html( get_the_date() ); ?></span>
							<span class="w-1 h-1 rounded-full bg-rock-gray-400 dark:bg-rock-alabaster-400"></span>
							<span><?php echo esc_html( get_the_author() ); ?></span>
						</div>

						<h2 class="text-[2.6em] leading-[0.95em]">
							<a href="<?php the_permalink(); ?>" class="hover:text-rockschool-teal-900 transition-colors"><?php the_title(); ?></a>
						</h2>

						<p class="text-base text-rock-gray-700 dark:text-rock-alabaster-200">
							<?php echo esc_html( wp_trim_words( get_the_excerpt(), 45, '…' ) ); ?>
						</p>

						<a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 mt-2 text-rockschool-teal-900 font-semibold uppercase tracking-[2px]">
							<span><?php esc_html_e( 'Read More', 'rockschool' ); ?></span>
							<span aria-hidden="true">→</span>
						</a>
					</div>
				</article>

				<?php if ( have_posts() ) : ?>
					<section class="posts-grid">
						<div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
							<?php
							while ( have_posts() ) :
								the_post();
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card shadow-md border border-rock-gray-200 dark:border-rock-gray-700 overflow-hidden flex flex-col' ); ?>>
									<?php if ( has_post_thumbnail() ) : ?>
										<a href="<?php the_permalink(); ?>" class="block overflow-hidden">
											<div class="aspect-[16/10]">
												<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover transition duration-500 ease-out hover:scale-105' ) ); ?>
											</div>
										</a>
									<?php endif; ?>

									<div class="p-6 flex flex-col gap-3 flex-1 post-card-body">
										<div class="flex flex-wrap items-center gap-3 text-[11px] font-semibold tracking-[1.2px] uppercase text-rock-gray-600 dark:text-rock-alabaster-300">
											<span><?php echo esc_html( get_the_date() ); ?></span>
											<span class="w-1 h-1 rounded-full bg-rock-gray-400 dark:bg-rock-alabaster-400"></span>
											<span><?php echo esc_html( get_the_author() ); ?></span>
										</div>

										<h3 class="small-title leading-[1em]">
											<a href="<?php the_permalink(); ?>" class="hover:text-rockschool-teal-900 transition-colors"><?php the_title(); ?></a>
										</h3>

										<p class="text-base text-rock-gray-700 dark:text-rock-alabaster-200">
											<?php echo esc_html( wp_trim_words( get_the_excerpt(), 28, '…' ) ); ?>
										</p>

										<div class="mt-auto">
											<a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-rockschool-teal-900 font-semibold uppercase tracking-[2px]">
												<span><?php esc_html_e( 'Read More', 'rockschool' ); ?></span>
												<span aria-hidden="true">→</span>
											</a>
										</div>
									</div>
								</article>
								<?php
							endwhile;
							?>
						</div>
					</section>
				<?php endif; ?>

				<div class="mt-12">
					<?php
					the_posts_pagination(
						array(
							'prev_text' => esc_html__( 'Previous', 'rockschool' ),
							'next_text' => esc_html__( 'Next', 'rockschool' ),
						)
					);
					?>
				</div>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

		</div>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
