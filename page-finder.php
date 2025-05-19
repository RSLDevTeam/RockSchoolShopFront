<?php
/*
Template Name: Custom Finder
Template Post Type: page
*/

get_header();

$google_api_key = get_field('googel_map_api_key', 'options'); 
$search_field = get_sub_field('search');
?>

<main id="primary" class="site-main">

	<?php
	while ( have_posts() ) :
		the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class="entry-content">

				<header class="finder-header mx-auto px-4">
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</header>

				<section class="finder-body grid grid-cols-1 md:grid-cols-4 gap-4">

					<div class="finder-sidebar md:col-span-1">

						<div class="finder-search">
							<form action="#" onsubmit="return false;" method="get" class="bg-white shadow-lg p-[37px] w-full bg-rock-alabaster-50 dark:bg-rock-gray-800 text-rock-gray-950 dark:text-rock-alabaster-50">
		                        <h5 class="font-bold uppercase tracking-[3px] mb-[16px]"><?php echo get_sub_field('search_title'); ?></span></h5>   
		                        <div class="flex items-center">                                
		                            <input id="place-search" aria-autocomplete="list" autocomplete="off" type="text" name="location" class="w-full p-[8px] text-lg focus:outline-none" placeholder="Search locations...">
		                            <button type="submit" id="search-btn" class="large-button focus:ring-4 focus:outline-none focus:ring-blue-300">
		                                <?php _e('Search', 'rockschool'); ?>
		                            </button>
		                        </div>
		                    </form>
		                </div>

		                <?php
						$field = get_field_object('type');
						if ($field && !empty($field['choices'])) :
						?>
						<div class="finder-filters mt-6">
						    <h5 class="font-bold uppercase tracking-[3px] mb-[16px]"><?php _e('Filter by Type', 'rockschool'); ?></h5>
						    <select id="filter-type" name="type" class="w-full p-[8px] text-lg">
						        <option value=""><?php _e('All Types', 'rockschool'); ?></option>
						        <?php foreach ($field['choices'] as $key => $label) : ?>
						            <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></option>
						        <?php endforeach; ?>
						    </select>
						</div>
						<?php endif; ?>

		            </div>

		            <div class="finder-map md:col-span-3">

		            	<div id="finder-map" class="w-full h-[600px]" data-cluster-icon="<?php echo get_template_directory_uri(); ?>/img/cluster.svg"></div>

		            </div>

				</section>

				<?php
				get_template_part( 'section-templates/section', 'flex-content' );
				?>

			</div><!-- .entry-content -->

			
		</article><!-- #post-<?php the_ID(); ?> -->

	<?php endwhile; // End of the loop.
	?>

</main><!-- #main -->

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo esc_attr($google_api_key); ?>"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/finder-map.js"></script>

<?php
get_footer();
