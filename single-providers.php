<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package rockschool
 */

get_header();

// Provider variables
$location = get_field('location');
$franscape_id = get_field('franscape_id');
$phone = get_field('phone');
$email = get_field('email');

// Global variables
$provider_contact_form_id = get_field('provider_contact_form_id', 'option');
$background_image = get_field('provider_contact_form_image', 'option');
?>

<main id="primary" class="site-main">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/profile-bg.svg" class="profile-bg z-[-1] absolute" />
	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('single-provider '); ?>>

			<div class="container mx-auto p-2.5 max-w-[1440px] z-1">

				<div class="tailwind-cols grid grid-cols-1 lg:grid-cols-3 pt-[1.5em] pb-[2em] gap-8 w-[85%] mx-auto px-4">

					<div class="profile-col-1 col-span-1">

						<div class="mb-6">

							<?php 
							$image = get_field('photo');
							if( !empty( $image ) ): ?>
								<div class="provider-photo" data-aos="zoom-in">
							    	<img src="<?php echo esc_url($image['sizes']['square']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
							    </div>
							<?php endif; ?>

						</div>

					</div>

					<div class="profile-col-2 col-span-1 lg:col-span-2">

						<div class="prose max-w-none">
							<header class="provider-header">
								<h1 data-aos="zoom-in"><?php the_title(); ?></h1>
								<div class="provider-meta mb-[0.5em]" data-aos="zoom-in">
									<div class="provider-type">
										<?php echo get_field('type'); ?>
									</div>
									<?php $instruments = get_field('instruments');
									if( $instruments ): ?>
										
										    <ul class="flex flex-wrap gap-2 mt-4 instrument-list">
										        <?php foreach( $instruments as $instrument ): ?>
										            <li class="instrument-list-item small-text">
										                <?php echo esc_html($instrument); ?>
										            </li>
										        <?php endforeach; ?>
										    </ul>
									<?php endif; ?>								
								</div>
							</header>

							<div class="provider-biog" data-aos="zoom-in">
								<?php the_content(); ?>
							</div>

						</div>

					</div>

				</div>

				<?php if ($franscape_id) { get_template_part( 'snippets/snippet', 'franscape-cal' ); } ?>

			</div>

			<?php if ($location) : ?>

				<div class="container mx-auto p-2.5 max-w-[1440px] z-1 w-[85%] mx-auto px-4">

					<div class="md:flex justify-between map-intro">

						<div class="mb-[1em]">

							<h2 data-aos="zoom-in">Location</h2>
							<div id="location-text" data-aos="zoom-in">
						    	<?php echo $location['address']; ?>
						    </div>

						</div>

						<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/map-icon.svg" class="map-icon" data-aos="zoom-in" />

					</div>

				</div>

				<div id="single-acf-map"
			        class="mt-10 w-full h-[500px]"
			        data-lat="<?php echo esc_attr($location['lat']); ?>"
			        data-lng="<?php echo esc_attr($location['lng']); ?>"
			        data-title="<?php the_title(); ?>"
			        data-address="<?php echo esc_attr($location['address']); ?>"
			        data-marker-icon="<?php echo get_template_directory_uri(); ?>/img/map-marker-single.svg"
			        data-aos="zoom-in"
			        >
			    </div>

			<?php endif; ?>

			<?php get_template_part( 'section-templates/section', 'flex-content' ); ?>

			<section class="contact_shortcode_module provider-contact-form">

			    <?php if ($background_image) { echo '<div class="background-image-cover" style="background-image:url(' . $background_image['url'] . ');"></div>'; } ?>

			    <div class="container mx-auto px-4 max-w-[1300px] py-24 px-4 lg:px-16">

			        <h2 class="text-center text-5xl pb-12" data-aos="zoom-in">Questions?</h2>

			        <div class="text-white mb-[3em] text-center ml-0 mr-auto" data-aos="zoom-in">You can reach out directly to <?php echo get_the_title(); ?> by completing the form below or by calling <a href="tel:<?php echo $phone; ?>" class="text-rockschool-teal"><?php echo $phone; ?></a></div>

			        <div class="contact_shortcode" data-aos="zoom-in">
			        	<?php
						echo do_shortcode('[contact-form-7 id="' . esc_attr($provider_contact_form_id) . '" recipient-email="' . esc_attr($email) . '"]');
						?>
			        </div>

			    </div>

			</section>

		</article>

	<?php
	endwhile;
	?>
</main>

<?php
$location = get_field('location');
$google_maps_api_key = get_field('googel_map_api_key', 'option');

if ($location && $google_maps_api_key) :
?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo esc_attr($google_maps_api_key); ?>"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/acf-map.js"></script>
<?php endif; ?>

<?php
if (get_the_title() && $instruments && $location):
    $image_url = $image['sizes']['square'] ?? '';
    $description = get_the_excerpt() ?: wp_trim_words(get_the_content(), 30);
    ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "MusicTeacher",
        "name": "<?php echo esc_js(get_the_title()); ?>",
        <?php if ($image_url): ?>
        "image": "<?php echo esc_url($image_url); ?>",
        <?php endif; ?>
        "description": "<?php echo esc_js($description); ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?php echo esc_js($location['address']); ?>"
        },
        "instrument": [
            <?php
            $instrument_json = array_map(function($i) {
                return '"' . esc_js($i) . '"';
            }, $instruments);
            echo implode(',', $instrument_json);
            ?>
        ]
    }
    </script>
<?php endif; ?>

<?php
get_footer();
