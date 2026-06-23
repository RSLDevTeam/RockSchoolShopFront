<?php $location = get_sub_field('location'); ?>    

<section class="locationSection ContentSection">
    
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

</section>

<?php
$google_maps_api_key = get_field('googel_map_api_key', 'option');
if ($location && $google_maps_api_key) :
?>

		<script async defer src='https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&loading=async&libraries=places&v=beta&callback=initMap'></script>

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

