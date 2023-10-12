<script>
	import './_map.scss';

	// @ts-ignore
	import { MAPBOX_API_KEY, MAPBOX_API_KEY_2 } from '../../config/config.local';
	// @ts-ignore
	import { Map } from "mapbox-gl";
	import "../../../node_modules/mapbox-gl/dist/mapbox-gl.css";
	import { onMount, onDestroy } from "svelte";

	// @ts-ignore
	let map;
	// @ts-ignore
	let mapContainer;
	// @ts-ignore
	let lng, lat, zoom;

	// we use France coordinates
	lng = 2.213749;
	lat = 46.227638;
	zoom = 6;

	onMount(() => {
		// @ts-ignore
		const initialState = { lng: lng, lat: lat, zoom: zoom };

		console.log(MAPBOX_API_KEY_2);

		map = new Map({
			// @ts-ignore
			container: mapContainer,
			accessToken: MAPBOX_API_KEY,
			style: `mapbox://styles/mapbox/outdoors-v11`,
			center: [initialState.lng, initialState.lat],
			zoom: initialState.zoom,
		});
	});

	onDestroy(() => {
		// @ts-ignore
		// map.remove();
	});


</script>

<style lang="scss">
	@import '../../lib/style/style.scss';

</style>

<div class="map-wrap">
  <div class="map" bind:this={mapContainer} />
</div>
