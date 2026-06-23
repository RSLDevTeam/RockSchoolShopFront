
async function initMap() {
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary('marker');
    const mapEl = document.getElementById('single-acf-map');
    if (!mapEl) return;

    const lat = parseFloat(mapEl.dataset.lat);
    const lng = parseFloat(mapEl.dataset.lng);
    const title = mapEl.dataset.title;
    const address = mapEl.dataset.address;
    const markerIconUrl = mapEl.dataset.markerIcon;
    const center = { lat, lng };

    const map = new Map(mapEl, {
        center,
        zoom: 15,
        mapId: 'f137ea192ad53b4a4b4ca0d3',
        disableDefaultUI: true,
        zoomControl: false,
        streetViewControl: false,
        mapTypeControl: false,
        fullscreenControl: false
    });

    const marker = new AdvancedMarkerElement({
        position: center,
        map,
        title: title,
        content: (() => {
            const img = document.createElement('img');
            img.src = markerIconUrl;
            img.style.width = '150px';
            img.style.height = '150px';
            return img;
        })()
    });

    const infoWindow = new google.maps.InfoWindow({
        content: `<strong>${title}</strong><br>${address}`,
    });

    marker.addListener('gmp-click', () => infoWindow.open(map, marker));

}