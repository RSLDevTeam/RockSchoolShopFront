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

				<header class="finder-header mx-auto px-4 text-center mt-[1.5em] mb-[1em]">
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</header>

				<section class="finder-search max-w-[1080px] block mx-auto">
					<?php get_template_part( 'snippets/snippet', 'google-places-map' ); ?>
				</section>

				<section class="finder-body grid grid-cols-1 md:grid-cols-4 gap-4">

					<div class="finder-sidebar md:col-span-1">

							<div class="finder-filters mt-6">
							    <h5 class="font-bold uppercase tracking-[3px] mb-[16px]"><?php _e('Filter by Type', 'rockschool'); ?></h5>
					
							    <select id="filter-type" name="type" class="w-full p-[8px] text-lg">
							        <option value=""><?php _e('All Types', 'rockschool'); ?></option>
							        <?php foreach ($field['choices'] as $key => $label) : ?>
							            <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></option>
							        <?php endforeach; ?>
							    </select>
							</div>
					
		      </div>

					<div class="finder-sidebar md:col-span-1">

							<div class="finder-filters mt-6">
							    <h5 class="font-bold uppercase tracking-[3px] mb-[16px]"><?php _e('Filter by Instrument', 'rockschool'); ?></h5>
					
							    <select id="filter-intsrument" name="instrument" class="w-full p-[8px] text-lg">
							        <option value=""><?php _e('All Instruments', 'rockschool'); ?></option>
							        <?php foreach ($field['choices'] as $key => $label) : ?>
							            <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></option>
							        <?php endforeach; ?>
							    </select>
							</div>
					

		      </div>

					<div class="finder-sidebar md:col-span-2">

							<div class="finder-filters mt-6">
							    <h5 class="font-bold uppercase tracking-[3px] mb-[16px]"><?php _e('Filter by Distance', 'rockschool'); ?></h5>
					
									<div class="inputRange relative w-[350px] flex justify-center items-center">
										<input type="range" name="inputName" id="inputName" value="0" min="0" step="1" max="10" class="relative appearance-none outline-none shadow-none w-full rounded-full h-1 m-0 p-0 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:cursor-grab [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:shadow-[0_1px_5px_#d1d5db] [&::-webkit-slider-thumb]:rounded-full">
										<output class="relative text-sm w-6 text-center pointer-events-none ml-1 text-gray-500 font-medium">0</output>
									</div>
							</div>
					

		      </div>

					

				</section>
				<div class="finder-map md:col-span-4">

						<div 
						id="finder-map" 
						class="w-full h-[600px]" 
						data-marker-icon="<?php echo get_template_directory_uri(); ?>/img/map-marker-single.svg"
						data-cluster-icon="<?php echo get_template_directory_uri(); ?>/img/map-marker-single.svg"
						></div>

					</div>

				<?php
				get_template_part( 'section-templates/section', 'flex-content' );
				?>

			</div><!-- .entry-content -->

			
		</article><!-- #post-<?php the_ID(); ?> -->

	<?php endwhile; // End of the loop.
	?>

</main><!-- #main -->

<script>
	document.addEventListener("DOMContentLoaded", function() {
		document.querySelectorAll('.inputRange').forEach(function (element) {
			let input = element.getElementsByTagName('input')[0];
			let output = element.getElementsByTagName('output')[0];

			if (!input || !output) return;

			let val = parseFloat(input.value);
			let min = parseFloat(input.min) || 0;
			let max = parseFloat(input.max) || 100;

			output.textContent = val;

			function handleInput() {
				let val = parseFloat(input.value);
				let fillPercent = ((val - min) / (max - min)) * 100;
				input.style.background = 'linear-gradient(to right, rgb(37 99 235) 0%, rgb(37 99 235) ' + fillPercent + '%, rgb(209 213 219) ' + fillPercent + '%)';
				output.textContent = val;
			}

			input.addEventListener('input', handleInput);
			input.addEventListener('change', handleInput);

			handleInput();
		});
	});
</script>
<?php
get_footer();