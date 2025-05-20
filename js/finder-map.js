function getMapStyles() {
    return [
        { elementType: "geometry", stylers: [{ color: "#212121" }] },
        { elementType: "labels.icon", stylers: [{ visibility: "off" }] },
        { elementType: "labels.text.fill", stylers: [{ color: "#757575" }] },
        { elementType: "labels.text.stroke", stylers: [{ color: "#212121" }] },
        { featureType: "administrative", elementType: "geometry", stylers: [{ color: "#757575" }] },
        { featureType: "administrative.country", elementType: "labels.text.fill", stylers: [{ color: "#9e9e9e" }] },
        { featureType: "administrative.locality", elementType: "labels.text.fill", stylers: [{ color: "#bdbdbd" }] },
        { featureType: "poi", elementType: "labels.text.fill", stylers: [{ color: "#757575" }] },
        { featureType: "poi.park", elementType: "geometry", stylers: [{ color: "#181818" }] },
        { featureType: "poi.park", elementType: "labels.text.fill", stylers: [{ color: "#616161" }] },
        { featureType: "poi.park", elementType: "labels.text.stroke", stylers: [{ color: "#1b1b1b" }] },
        { featureType: "road", elementType: "geometry.fill", stylers: [{ color: "#2c2c2c" }] },
        { featureType: "road", elementType: "labels.text.fill", stylers: [{ color: "#8a8a8a" }] },
        { featureType: "road.arterial", elementType: "geometry", stylers: [{ color: "#373737" }] },
        { featureType: "road.highway", elementType: "geometry", stylers: [{ color: "#3c3c3c" }] },
        { featureType: "road.highway.controlled_access", elementType: "geometry", stylers: [{ color: "#4e4e4e" }] },
        { featureType: "road.local", elementType: "labels.text.fill", stylers: [{ color: "#616161" }] },
        { featureType: "transit", elementType: "labels.text.fill", stylers: [{ color: "#757575" }] },
        { featureType: "water", elementType: "geometry", stylers: [{ color: "#000000" }] },
        { featureType: "water", elementType: "labels.text.fill", stylers: [{ color: "#3d3d3d" }] }
    ];
}

let map;
let markers = [];
let markerCluster;

function initFinderMap() {
    const mapEl = document.getElementById('finder-map');
    if (!mapEl) return;

    map = new google.maps.Map(mapEl, {
        center: { lat: 54.5, lng: -3 },
        zoom: 6,
        styles: getMapStyles(),
        // disableDefaultUI: true,
    });

    // Load all initially
    loadProviders();

    // Listen for filter change
    const typeSelect = document.getElementById('filter-type');
    if (typeSelect) {
        typeSelect.addEventListener('change', () => {
            loadProviders(typeSelect.value);
        });
    }
}

function loadProviders(type = '') {
    const url = `/wp-admin/admin-ajax.php?action=get_providers&type=${encodeURIComponent(type)}`;

    fetch(url)
        .then((res) => res.json())
        .then((data) => {
            // Clear existing
            if (markerCluster) markerCluster.clearMarkers();
            markers.forEach(marker => marker.setMap(null));
            markers = [];

            // Add new markers
            data.forEach((provider) => {
                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(provider.lat), lng: parseFloat(provider.lng) },
                    map: map,
                    title: provider.title,
                });

                const info = new google.maps.InfoWindow({
                    content: `
                        <div class="map-card text-sm text-black max-w-[220px]">
                            ${provider.photo ? `<img src="${provider.photo}" alt="${provider.title}" class="mb-2 rounded-md" />` : ''}
                            <strong>${provider.title}</strong><br/>
                            ${provider.address}<br/>
                            <a href="${provider.permalink}" class="map-card-link mt-2 block">View profile</a>
                        </div>
                    `
                });

                marker.addListener('click', () => info.open(map, marker));
                markers.push(marker);
            });

            markerCluster = new MarkerClusterer(map, markers, {
                imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',
            });
        });
}

document.addEventListener('DOMContentLoaded', initFinderMap);