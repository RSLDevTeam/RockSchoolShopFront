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
let center;
let markers = [];
let markerCluster;
let placesService;
let autocomplete;
// let geocoder;

// async function initFinderMap() {
//     const { Place } = await google.maps.importLibrary("places");
//     console.log('Place', Place);

//     const mapEl = document.getElementById('finder-map');
//     if (!mapEl) return;

//     // geocoder = await new google.maps.Geocoder();



//     loadProviders();

//     const typeSelect = document.getElementById('filter-type');
//     if (typeSelect) {
//         typeSelect.addEventListener('change', () => {
//             loadProviders(typeSelect.value);
//         });
//     }

//     const searchForm = document.querySelector('.finder-search form');
//     if (searchForm) {
//         searchForm.addEventListener('submit', (e) => {
//             e.preventDefault();
//             const query = document.getElementById('place-search').value;
//             if (query) {
//                 findPlace(query);
//             }
//         });
//     }
// }

// function findPlace(query) {
//     const service = new google.maps.places.PlacesService(map);

//     const request = {
//         query,
//         fields: ['name', 'geometry'],
//     };

//     service.findPlaceFromQuery(request, (results, status) => {
//         if (status === google.maps.places.PlacesServiceStatus.OK && results[0]) {
//             const location = results[0].geometry.location;
//             map.setCenter(location);
//             map.setZoom(12);
//         } else {
//             alert('Location not found. Please try again.');
//         }
//     });
// }


// function geocodeAndCenter(address) {
//     geocoder.geocode({ address }, (results, status) => {
//         if (status === 'OK' && results[0]) {
//             const location = results[0].geometry.location;
//             map.setCenter(location);
//             map.setZoom(12); // or 14 if you want tighter zoom
//         } else {
//             alert('Location not found. Please try again.');
//         }
//     });
// }

async function loadProviders(type = '') {
	const url = `/wp-admin/admin-ajax.php?action=get_providers&type=${encodeURIComponent(type)}`;
	const { AdvancedMarkerElement } = await google.maps.importLibrary('marker');
	fetch(url)
		.then((res) => res.json())
		.then((data) => {
			// Clear existing
			console.log(data)
			if (markerCluster) markerCluster.clearMarkers();
			markers.forEach(marker => marker.setMap(null));
			markers = [];

			const markerIconUrl = document.getElementById('finder-map')?.dataset.markerIcon;


			data.forEach((provider) => {
				const marker = new AdvancedMarkerElement({
					position: {
						lat: parseFloat(provider.lat),
						lng: parseFloat(provider.lng),
					},
					map,
					title: provider.title,
					content: (() => {
						const img = document.createElement('img');
						img.src = markerIconUrl;
						img.style.width = '40px';
						img.style.height = '40px';
						return img;
					})()
				});
				// const marker = new google.maps.Marker({
				// 	position: {
				// 		lat: parseFloat(provider.lat),
				// 		lng: parseFloat(provider.lng),
				// 	},
				// 	map: map,
				// 	title: provider.title,
				// 	icon: {
				// 		url: markerIconUrl,
				// 		scaledSize: new google.maps.Size(80, 80),
				// 	}
				// });

				// const infoWindow = new google.maps.InfoWindow({
				// 	content: `
				// 						<div class="map-card mb-[10px] text-sm text-black max-w-[220px]">
				// 								${provider.photo ? `<img src="${provider.photo}" alt="${provider.title}" class="mb-2 rounded-md" />` : ''}
				// 								<strong>${provider.title}</strong> | ${provider.type}<br/>
				// 								${provider.address}<br/>
				// 								<a href="${provider.permalink}" class="map-card-link mt-2 block">View profile</a>
				// 						</div>
				// 				`
				// });
				const infoWindow = new google.maps.InfoWindow({
					content: `
						<div class="map-card mb-[10px] text-sm text-black max-w-[220px]">
							${provider.photo ? `<img src="${provider.photo}" alt="${provider.title}" class="mb-2 rounded-md" />` : ''}
							<strong>${provider.title}</strong> | ${provider.type}<br/>
							${provider.address}<br/>
							<a href="${provider.permalink}" class="map-card-link mt-2 block">View profile</a>
						</div>
					`
				});

				marker.addListener('gmp-click', () => infoWindow.open(map, marker));

				markers.push(marker);
			});

		});

	const typeSelect = document.getElementById('filter-type');
	if (typeSelect) {
		typeSelect.addEventListener('change', () => {
			loadProviders(typeSelect.value);
		});
	}

	const searchForm = document.querySelector('.finder-search form');
	if (searchForm) {
		searchForm.addEventListener('submit', (e) => {
			e.preventDefault();
			const query = input?.value;
			if (query) {
				findPlace(query);
			}
		});
	}
}


async function initFinderMap() {
	console.log('Finder map init');
	const { Place } = await google.maps.importLibrary("places");
	const { Map } = await google.maps.importLibrary("maps");
	const { MarkerEl } = await google.maps.importLibrary("marker");

	const mapEl = document.getElementById('finder-map');
	if (!mapEl) return;

	map = new Map(mapEl, {
		center: { lat: 54.5, lng: -3 },
		zoom: 6,
		mapId: '211ca0ed7a23cd2da3b44d39',
		disableDefaultUI: true,
	});

	loadProviders();



}
