<?php
  $google_api_key = get_field('googel_map_api_key', 'options'); 
  $search_field = get_sub_field('search');
  $partial_height = get_sub_field('partial_height');
  ?>

<script async defer src='https://maps.googleapis.com/maps/api/js?key=<?php echo $google_api_key; ?>&loading=async&libraries=places&callback=initMap'></script>


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