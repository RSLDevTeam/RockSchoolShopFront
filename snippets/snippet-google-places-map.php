<?php
  $google_api_key = get_field('googel_map_api_key', 'options'); 
  $search_field = get_sub_field('search');
  $partial_height = get_sub_field('partial_height');
  $finder_url = get_field('finder_url', 'option');

  //get location from get request
  $location = isset($_GET['location']) ? sanitize_text_field($_GET['location']) : '';
  ?>

<script async defer src='https://maps.googleapis.com/maps/api/js?key=<?php echo $google_api_key; ?>&loading=async&libraries=places&v=beta&callback=initFinderMap&modules=placeautocomplete'></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/finder-map.js"></script>


<form action="<?php echo home_url($finder_url); ?>" method="get" class="bg-white shadow-lg p-[37px] w-full bg-rock-alabaster-50 dark:bg-rock-gray-800 text-rock-gray-950 dark:text-rock-alabaster-50">
    <h5 class="font-bold uppercase tracking-[3px] mb-[16px]"><?php echo get_sub_field('search_title'); ?></span></h5>   
    <div class="flex items-center">
        <input id="place-search" aria-autocomplete="list" autocomplete="off" type="text" name="location" value="<?php echo $location?>" class="w-full p-[8px] text-lg focus:outline-none" placeholder="Search locations...">
        <button type="submit" id="search-btn" class="large-button focus:ring-4 focus:outline-none focus:ring-blue-300">
            <?php _e('Search', 'rockschool'); ?>
        </button>
    </div>
    <ul id="google-results" class="absolute left-0 w-full shadow-lg max-h-60 overflow-auto z-5 mt-1 bg-rock-alabaster-50 dark:bg-rock-gray-800"></ul>
    <p id="prediction"></p>

    
</form>


