<section class="heroSearch ContentSection">
    <?php
    $google_api_key = get_field('googel_map_api_key', 'options'); 
    ?>
    <script async defer src='https://maps.googleapis.com/maps/api/js?key=<?php echo $google_api_key; ?>&loading=async&libraries=places&callback=initMap'></script>
    <div class="ed-banner-slider swiper relative">
        
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <?php
                $banner_bg_image = get_sub_field('image');
                $banner_bg_video = get_sub_field('video');
                if ($banner_bg_image) : ?>
                    <div class="min-h-[85vh] flex flex-col justify-center items-center bg-no-repeat bg-center bg-cover relative z-[1] before:absolute before:-z-[1] before:inset-0 before:bg-edblue/70 before:pointer-events-none"
                        style="background-image: url('<?php echo esc_url($banner_bg_image["url"]); ?>');"> 
                    <?php if ($banner_bg_video) : ?> 
                        <div class="video-container absolute top-0 w-full h-full overflow-hidden">
                            <video class="w-full h-full object-cover" muted autoplay loop>
                                <source src="<?php echo esc_url($banner_bg_video); ?>">
                            </video>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="min-h-[70vh] flex flex-col justify-center items-center bg-no-repeat bg-center bg-cover relative z-[1] before:absolute before:-z-[1] before:inset-0 before:bg-edblue/70 before:pointer-events-none"
                        style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/banner-bg-1.jpg');">
                <?php endif; ?>	
                <?php if (get_sub_field('enable_overlay')) : ?>
                    <div class="overlay z-2"></div>
                <?php endif; ?>
                <div class="mx-[10%] md:mx-[23 px] text-white z-2 relative text-center">
                    <h6 class="font-medium uppercase tracking-[3px] mb-[16px]"><?php echo get_sub_field('sub_title'); ?></span></h6>
                    <h2 class="font-bold text-[clamp(35px,4.57vw,80px)] leading-[1.13] mb-[15px]"><?php echo get_sub_field('title'); ?></h2>
                </div>
                <?php
                    $search_field = get_sub_field('search');
                    if ($search_field) : ?>
                    <div data-aos="zoom-in" class="absolute top-[98%] rounded-lg left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl z-2">
                        
                        <form action="<?php echo home_url('/finder'); ?>" method="get" class="bg-white shadow-lg rounded-[8px] p-[37px] w-full bg-rock-alabaster-50 dark:bg-rock-gray-800 text-rock-gray-950 dark:text-rock-alabaster-50">
                            <h2 class="font-bold uppercase tracking-[3px] mb-[16px]"><?php echo get_sub_field('search_title'); ?></span></h2>   
                            <div class="flex items-center">                                
                                <input id="place-search" aria-autocomplete="list" autocomplete="off" type="text" name="location" class="w-full p-[8px] text-lg focus:outline-none" placeholder="Search locations...">
                                <button type="submit" id="search-btn" class="large-button text-sm text-white font-medium bg-rock-moonstone-500 rounded-lg hover:bg-rock-moonstone-600 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    <?php _e('Search', 'rockschool'); ?>
                                </button>
                            </div>
                            
                        </form>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
      async function initMap() {
        // Request needed libraries.
        //@ts-ignore
        await google.maps.importLibrary("places");

        // Get the input field.
        const inputField = document.getElementById("place-search");
        //@ts-ignore
        const autocomplete = new google.maps.places.Autocomplete(inputField);

        // Add listener for place selection.
        autocomplete.addListener("place_changed", async () => {
          const place = autocomplete.getPlace();
          if (!place.geometry) return;
		  console.log(place);
          //selectedPlaceTitle.textContent = "Selected Place:";
          //selectedPlaceInfo.textContent = JSON.stringify(place, null, 2);

          // Extract place name or place ID for the URL
          const selectedPlace = encodeURIComponent(place.name);

          document.getElementById("search-btn").addEventListener("click", () => {
                if (selectedPlace) {
                    window.location.href = `/finder?location=${selectedPlace}`;
                } else {
                    alert("Please select a place first!");
                }
            });

        });
      }
      window.initMap = initMap;
    </script>
</section>