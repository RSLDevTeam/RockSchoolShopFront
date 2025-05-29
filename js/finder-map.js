let map;
let center;
let markers = [];
let markerCluster;
let placesService;
let autocomplete;
let input;
let defaultLocation = { lat: 51.5, lng: -0.1 }; // Default to London if no location is found
let userLat = null;
let userLng = null;
let providers = [];
let uniqueTypes = [];
let uniqueInstruments = [];



async function loadProviders(userType = '', userInstrument = '', userLat = 51.5, userLng = -0.1, distance = 15) {
	const url = `/wp-admin/admin-ajax.php?action=get_providers&type=${encodeURIComponent(userType)}&instrument=${encodeURIComponent(userInstrument)}&lat=${encodeURIComponent(userLat)}&lng=${encodeURIComponent(userLng)}&distance=${encodeURIComponent(distance)}`;
	const { AdvancedMarkerElement } = await google.maps.importLibrary('marker');
	const providerContainer = document.getElementById("provider-cards");

	fetch(url)
		.then((res) => res.json())
		.then((data) => {
			console.log('Loaded providers:', data);
			providers = data;
			if (markerCluster) markerCluster.clearMarkers();
			markers.forEach(marker => marker.setMap(null));
			markers = [];
			uniqueTypes = [...new Set(providers.map(p => p.type))];

			const allInstruments = providers.flatMap(p => p.instrument);
			uniqueInstruments = [...new Set(allInstruments)];
			const markerIconUrl = document.getElementById('finder-map')?.dataset.markerIcon;

			providerContainer.innerHTML = '';
			providerContainer.innerHTML = providers.map(p => `
				<div class="provider-card">
				<a href="${p.permalink}">
					<div class="bg-white shadow-lg bg-rock-alabaster-50 dark:bg-rock-gray-800 text-rock-gray-950 dark:text-rock-alabaster-50 flex gap-4 p-4 items-center hover:shadow-xl transition">
						<img src="${p.photo}" alt="${p.title}" class="w-20 h-20 rounded-full object-cover" />
						<div>
							<h5 class="font-bold uppercase tracking-[3px]">${p.title}</h5>
							<p class="text-sm">${p.type} &bull; ${p.instrument.join(', ')}</p>
							<p class="text-sm">${p.address}</p>
							<p class="text-sm font-medium">Distance: ${p.distance.toFixed(2)} miles</p>
						</div>
					</div>
				</a>
				</div>
			`).join('');
			if (providers.length === 0) {
				providerContainer.innerHTML = '<p class="text-center text-rock-gray-950 dark:text-rock-alabaster-50">No providers found in this area.</p>';
			}

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
						img.style.width = '80px';
						img.style.height = '80px';
						return img;
					})()
				});
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


			//Add option to the filter type select
			const filterTypeSelect = document.getElementById("filter-type");
			filterTypeSelect.length = 1;
			uniqueTypes.forEach(type => {
				const option = document.createElement("option");
				option.value = type;
				option.textContent = type;
				filterTypeSelect.appendChild(option);
				if (type === userType) {
					option.selected = true;
				}
			});

			//Add option to the filter instrument select
			const filterInstrumentSelect = document.getElementById("filter-instrument");
			filterInstrumentSelect.length = 1;
			uniqueInstruments.forEach(instrument => {
				const option = document.createElement("option");
				option.value = instrument;
				option.textContent = instrument;
				filterInstrumentSelect.appendChild(option);
				//add selecrted attribute if the instrument matches the provider's instrument
				if (instrument === userInstrument) {
					option.selected = true;
				}
			});

		});

}


async function initFinderMap() {
	const { Place, AutocompleteSessionToken, AutocompleteSuggestion } = await google.maps.importLibrary("places");
	const { Map } = await google.maps.importLibrary("maps");
	const { MarkerEl } = await google.maps.importLibrary("marker");
	input = document.getElementById("place-search");
	//get user location
	const googleRequest = await getCurrentLocation();
	if (!googleRequest) {

		center = defaultLocation;
	} else {
		center = {
			lat: googleRequest.origin.lat,
			lng: googleRequest.origin.lng,
		};
	}
	const mapEl = document.getElementById('finder-map');
	initAutocomplete();


	//get current path of window
	const currentSitePath = window.location.pathname;
	if (currentSitePath.includes('find-an-instructor')) {
		if (input && input.value.trim() !== "") {
			await geocodeAndCenter(input.value, (geocodedCenter) => {
				if (geocodedCenter) {
					center = geocodedCenter;
					map = new Map(mapEl, {
						center: center,
						zoom: 13,
						mapId: 'f137ea192ad53b4a4b4ca0d3',
						disableDefaultUI: true,
					});
					loadProviders('', '', center.lat, center.lng);
				}
			});

		} else if (mapEl) {
			map = new Map(mapEl, {
				center: center,
				zoom: 13,
				mapId: 'f137ea192ad53b4a4b4ca0d3',
				disableDefaultUI: true,
			});

			loadProviders();

		}

	}
	document.addEventListener("DOMContentLoaded", async () => {
		const autocompleteEl = document.getElementById("place-search");
		if (!autocompleteEl) {
			console.log("Place search input not found");
		}
		const searchBtn = document.getElementById("search-btn");
		let selectedPlace = null;


		searchBtn.addEventListener("click", () => {
			if (selectedPlace) {
				window.location.href = `/find-an-instructor?location=${selectedPlace}`;
			} else {
				alert("Please select a place first!");
			}
		});
	});

}


async function initAutocomplete() {
	const {
		AutocompleteSessionToken,
		AutocompleteSuggestion,
	} = await google.maps.importLibrary("places");

	const resultsEl = document.getElementById("google-results");
	let sessionToken = new AutocompleteSessionToken();

	input.addEventListener("input", async () => {
		const userInput = input.value.trim();
		if (userInput.length < 2) {
			resultsEl.innerHTML = "";
			return;
		}

		const request = {
			input: userInput,
			sessionToken,
			language: "en-US",
			region: "uk", // customize this
		};

		const { suggestions } = await AutocompleteSuggestion.fetchAutocompleteSuggestions(request);

		resultsEl.innerHTML = "";
		for (const suggestion of suggestions) {
			const placePrediction = suggestion.placePrediction;
			const place = placePrediction.toPlace();
			// Wait for place details to fetch coordinates
			await place.fetchFields({ fields: ["location", "displayName", "formattedAddress"] });

			const destLat = place.location.lat();
			const destLng = place.location.lng();
			const distance = userLat && userLng
				? `${calculateDistanceMiles(userLat, userLng, destLat, destLng).toFixed(2)} miles`
				: "";

			const li = document.createElement("li");
			li.className = "flex items-start gap-2 p-3 cursor-pointer";

			li.innerHTML = `
			<div class="flex items-center w-full">
				<!-- Icon -->
				<div class="w-10 h-10 mr-2 flex-shrink-0">
					<?xml version="1.0" encoding="UTF-8"?>
					<svg id="uuid-b1744f63-6327-4e34-9256-dfbf8c3a67ae" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 76.5 77.28">
						<defs>
							<clipPath id="uuid-50041d36-f244-45b0-b1d8-b3f6e6ec505e">
								<path d="M26.5,18.41c-4.35,1.33-7.4,5.5-7.4,10.16,0,.69.06,1.37.19,2.04,2.11,11.31,7.79,21.38,16.41,29.14.7.62,1.6.96,2.54.96s1.84-.34,2.54-.96c8.63-7.76,14.3-17.83,16.41-29.14.13-.67.19-1.36.19-2.04,0-4.65-3.04-8.83-7.39-10.16-3.86-1.22-7.8-1.83-11.75-1.83s-7.89.61-11.75,1.83" style="fill: none;"/>
							</clipPath>
							<linearGradient id="uuid-6b0f0325-710a-4175-895e-0ccdbd7c6a42" x1="-169.9" y1="337.19" x2="-168.9" y2="337.19" gradientTransform="translate(9390.01 18653.75) scale(55.21 -55.21)" gradientUnits="userSpaceOnUse">
								<stop offset="0" stop-color="#8f807d"/>
								<stop offset=".33" stop-color="#3dadbf"/>
								<stop offset=".66" stop-color="#d11a6f"/>
								<stop offset="1" stop-color="#51247f"/>
								<stop offset="1" stop-color="#51247f"/>
								<stop offset="1" stop-color="#51247f"/>
							</linearGradient>
						</defs>
						<g style="clip-path: url(#uuid-50041d36-f244-45b0-b1d8-b3f6e6ec505e);">
							<rect x="10.64" y="9.96" width="55.22" height="57.36" transform="translate(-14.2 24.3) rotate(-30)" style="fill: url(#uuid-6b0f0325-710a-4175-895e-0ccdbd7c6a42);"/>
						</g>
						<path d="M37.88,44.85c5.57,0,10.09-4.52,10.09-10.09s-4.52-10.1-10.09-10.1-10.09,4.52-10.09,10.1,4.52,10.09,10.09,10.09Z" style="fill: none; stroke: #fff;"/>
						<path d="M37.88,44.85c5.57,0,10.09-4.52,10.09-10.09s-4.52-10.1-10.09-10.1-10.09,4.52-10.09,10.1,4.52,10.09,10.09,10.09" style="fill: #231f20;"/>
						<path d="M49.85,18.52c-7.71-2.44-15.79-2.44-23.49,0-4.35,1.33-7.4,5.51-7.4,10.16,0,.69.07,1.37.19,2.04,2.11,11.31,7.79,21.38,16.41,29.14.7.62,1.6.96,2.54.96s1.84-.34,2.54-.96c8.63-7.76,14.3-17.83,16.41-29.14.13-.67.19-1.35.19-2.04,0-4.65-3.04-8.83-7.39-10.16" style="fill: none; stroke: #231f20; stroke-miterlimit: 10;"/>
					</svg>
				</div>
		
				<!-- Text -->
				<div class="flex flex-col justify-center text-sm leading-tight flex-grow">
					<span class="font-medium truncate">${place.displayName}</span>
					<span class="text-xs truncate">${place.formattedAddress}</span>
				</div>
		
				<!-- Distance -->
				<div class="ml-2 text-xs text-right whitespace-nowrap">
					${distance}
				</div>
			</div>
		`;


			li.addEventListener("click", () => {
				const selectedName = place.displayName;
				input.value = selectedName;
				input.text = selectedName;
				resultsEl.innerHTML = ""; // Clear results

				const currentSitePath = window.location.pathname;
				if (currentSitePath.includes('find-an-instructor')) {
					const url = new URL(window.location);
					url.searchParams.set("location", selectedName);
					window.history.pushState({}, "", url);
				}


				document.getElementById("search-btn").onclick = () => {
					const selectedPlace = encodeURIComponent(selectedName);
					window.location.href = `/find-an-instructor?location=${selectedPlace}`;
				};
			});

			resultsEl.appendChild(li);
		}
		if (suggestions.length === 0) {
			resultsEl.innerHTML = "<li class='p-3'>No results found</li>";
		}
	});
}

function getCurrentLocation() {
	return new Promise((resolve, reject) => {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(
				(position) => {
					userLat = position.coords.latitude;
					userLng = position.coords.longitude;
					const request = useLocation(userLat, userLng);
					resolve(request);
				},
				(error) => {
					console.error("No permission to get location", error.message);
					return resolve(null);
				}
			);
		} else {
			return resolve(null);
		}
	});
}


function useLocation(lat, lng) {
	const request = {
		input: document.getElementById("place-search").value,
		origin: { lat, lng },
		locationRestriction: {
			north: lat + 0.02,
			south: lat - 0.02,
			east: lng + 0.02,
			west: lng - 0.02,
		},
		sessionToken: new google.maps.places.AutocompleteSessionToken(),
		language: "en-US",
	};

	return request;

}

function calculateDistanceKM(lat1, lon1, lat2, lon2) {
	const R = 6371; // Radius of Earth in km
	const dLat = (lat2 - lat1) * (Math.PI / 180);
	const dLon = (lon2 - lon1) * (Math.PI / 180);
	const a =
		Math.sin(dLat / 2) * Math.sin(dLat / 2) +
		Math.cos(lat1 * (Math.PI / 180)) *
		Math.cos(lat2 * (Math.PI / 180)) *
		Math.sin(dLon / 2) *
		Math.sin(dLon / 2);
	const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
	return R * c; // Distance in km
}

//calculate distance in miles
function calculateDistanceMiles(lat1, lon1, lat2, lon2) {
	const km = calculateDistanceKM(lat1, lon1, lat2, lon2);
	return km * 0.621371; // Convert km to miles
}

// A helper function which uses Google Maps Geocoder to get coordinates
function geocodeAndCenter(address, callback) {
	// Create a new geocoder
	const geocoder = new google.maps.Geocoder();

	geocoder.geocode({ address: address }, (results, status) => {
		if (status === 'OK' && results[0]) {
			const location = results[0].geometry.location;
			// Call the callback with the location
			callback({ lat: location.lat(), lng: location.lng() });
		} else {
			console.error("Geocode was not successful for the following reason: " + status);
			callback(null);
		}
	});
}

function filterProviders(type = null, instrument = null, distance = 15) {
	loadProviders(type, instrument, center.lat, center.lng, distance);
}
