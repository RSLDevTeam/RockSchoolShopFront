<?php
/*
Template Name: Custom Finder
Template Post Type: page
*/

get_header();

$google_api_key = get_field('googel_map_api_key', 'options'); 
$search_field = get_sub_field('search');

//get type, distance and instrument from get request
$type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';
$instrument = isset($_GET['instrument']) ? sanitize_text_field($_GET['instrument']) : '';
$distance = isset($_GET['distance']) ? sanitize_text_field($_GET['distance']) : '15'; // Default to 15 miles if not set

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

				<section class="finder-body flex flex-col md:flex-row flex-wrap justify-start md:justify-center mb-[1em] gap-4 px-[10px] md:px-0">

					<!-- Filter by Type -->
					<div class="finder-sidebar w-full md:w-auto">
						<div class="finder-filters mt-6">
							<h6 class="font-bold uppercase tracking-[3px] mb-[16px]">
								<?php _e('Filter by Type', 'rockschool'); ?>
							</h6>
							<select id="filter-type" name="type" class="w-full p-[8px] text-lg">
								<option value=""><?php _e('All Types', 'rockschool'); ?></option>
							</select>
						</div>
					</div>

					<!-- Filter by Instrument -->
					<div class="finder-sidebar w-full md:w-auto">
						<div class="finder-filters mt-6">
							<h6 class="font-bold uppercase tracking-[3px] mb-[16px]">
								<?php _e('Filter by Instrument', 'rockschool'); ?>
							</h6>
							<select id="filter-instrument" name="instrument" class="w-full p-[8px] text-lg">
								<option value=""><?php _e('All Instruments', 'rockschool'); ?></option>
							</select>
						</div>
					</div>

					<!-- Filter by Distance -->
					<div class="finder-sidebar w-full md:w-auto">
						<div class="finder-filters mt-6">
							<h6 class="font-bold uppercase tracking-[3px] mb-[16px]">
								<?php _e('Filter by Distance', 'rockschool'); ?>
							</h6>
							<div class="inputRange relative w-full md:w-[350px] flex items-center gap-2">
								<input type="range" id="distanceRange" value="15" min="1" max="50" step="1"
									class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
								<output class="text-sm text-gray-500 font-medium">0 <?php _e('miles', 'rockschool'); ?></output>
							</div>
						</div>
					</div>

				</section>

				<section class="finder-body w-full flex flex-col-reverse xl:flex-row">
					<div class="finder-results w-full xl:basis-[30%] xl:max-w-[30%] overflow-y-auto max-h-[600px]">
						<div id="provider-cards"></div>
					</div>

					<div class="finder-map w-full xl:flex-grow">
						<div
							id="finder-map"
							class="w-full h-[600px] shadow-md"
							data-marker-icon="<?php echo get_template_directory_uri(); ?>/img/map-marker-single.svg"
							data-cluster-icon="<?php echo get_template_directory_uri(); ?>/img/map-marker-single.svg">
						</div>
					</div>
				</section>



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
				output.textContent = val + ' ' + '<?php _e('miles', 'rockschool'); ?>';
			}

			input.addEventListener('input', handleInput);
			input.addEventListener('change', handleInput);

			handleInput();
		});

		const typeSelect = document.getElementById("filter-type");
		const instrumentSelect = document.getElementById("filter-instrument");
		const distanceRange = document.getElementById("distanceRange");
		const distanceOutput = distanceRange.nextElementSibling;

		// Helper function to get current filter values
		function getFilterValues() {
			const type = typeSelect.value;
			const instrument = instrumentSelect.value;
			const distance = distanceRange.value;

			//set these options in the URL and options 
			const urlParams = new URLSearchParams(window.location.search);
			urlParams.set('type', type);
			urlParams.set('instrument', instrument);
			urlParams.set('distance', distance);
			window.history.replaceState({}, '', `${window.location.pathname}?${urlParams.toString()}`);



			// You can call your filtering logic here using the values
			applyFiltersAndUpdateList();
			applyFiltersAndUpdateMap();
			
		}
		// Attach change event listeners
		typeSelect.addEventListener("change", getFilterValues);
		instrumentSelect.addEventListener("change", getFilterValues);

		distanceRange.addEventListener("input", () => {
			distanceOutput.textContent = `${distanceRange.value} miles`;
		});

		distanceRange.addEventListener("change", getFilterValues);
	});
</script>
<?php
get_footer();