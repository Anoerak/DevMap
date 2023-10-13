<script>
	import './_map.scss';
	import "../../../node_modules/mapbox-gl/dist/mapbox-gl.css";

	// @ts-ignore
	import { onMount, onDestroy } from "svelte";
	// @ts-ignore
	import { Map } from "mapbox-gl";
	import apiJsonServer from '../../hooks/apiJsonServer.js';
	// @ts-ignore
	import { MAPBOX_API_KEY } from '../../config/config.local';

	/**
	 * @type {Map}
	 */
	let map;
	/**
	 * @type {HTMLDivElement}
	 */
	let mapContainer;
	/**
	 * @type {number}
	 */
	let lng, 
	/**
	 * @type {number}
	*/
		lat, 
	/**
	 * @type {number}
	 */
		zoom;

	// we use France coordinates
	lng = 2.213749;
	lat = 46.227638;
	zoom = 5;

	onMount(() => {
		// @ts-ignore
		const initialState = { lng: lng, lat: lat, zoom: zoom };

		const db = async () => {
			const jsonCall = new apiJsonServer();
			const dataset = await jsonCall.getAllGeojson();
			return dataset;
		};

		db().then((dataset) => {
			map = new Map({
				container: mapContainer,
				accessToken: MAPBOX_API_KEY,
				style: `mapbox://styles/mapbox/outdoors-v11`,
				center: [initialState.lng, initialState.lat],
				zoom: initialState.zoom,
			});

			map.on('load', () => {
				// Add a new source from our GeoJSON data and
				// set the 'cluster' option to true. GL-JS will
				// add the point_count property to your source data.
				// @ts-ignore
				map.addSource('developers', {
					type: 'geojson',
					// Point to GeoJSON data. This example visualizes all M1.0+ earthquakes
					// from 12/22/15 to 1/21/16 as logged by USGS' Earthquake hazards program.
					data: dataset,
					cluster: true,
					clusterMaxZoom: 14, // Max zoom to cluster points on
					clusterRadius: 50 // Radius of each cluster when clustering points (defaults to 50)
				});
				
				// @ts-ignore
				map.addLayer({
					id: 'clusters',
					type: 'circle',
					source: 'developers',
					filter: ['has', 'point_count'],
					paint: {
					// Use step expressions (https://docs.mapbox.com/style-spec/reference/expressions/#step)
					// with three steps to implement three types of circles:
					//   * Blue, 20px circles when point count is less than 100
					//   * Yellow, 30px circles when point count is between 100 and 750
					//   * Pink, 40px circles when point count is greater than or equal to 750
						'circle-color': [
							'step',
							['get', 'point_count'],
							'#51bbd6',
							100,
							'#f1f075',
							750,
							'#f28cb1'
						],
						'circle-radius': [
							'step',
							['get', 'point_count'],
							20,
							100,
							30,
							750,
							40
						]
					}
				});
				
				// @ts-ignore
				map.addLayer({
					id: 'cluster-count',
					type: 'symbol',
					source: 'developers',
					filter: ['has', 'point_count'],
					layout: {
						'text-field': ['get', 'point_count_abbreviated'],
						'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
						'text-size': 12
					}
				});
					
				// @ts-ignore
				map.addLayer({
					id: 'unclustered-point',
					type: 'circle',
					source: 'developers',
					filter: ['!', ['has', 'point_count']],
					paint: {
						'circle-color': '#11b4da',
						'circle-radius': 4,
						'circle-stroke-width': 1,
						'circle-stroke-color': '#fff'
					}
				});
				
				// inspect a cluster on click
				// @ts-ignore
				map.on('click', 'clusters', (e) => {
					// @ts-ignore
					const features = map.queryRenderedFeatures(e.point, {
						layers: ['clusters']
					});
					const clusterId = features[0].properties.cluster_id;
					// @ts-ignore
					map.getSource('developers').getClusterExpansionZoom(
						clusterId,
						// @ts-ignore
						(err, zoom) => {
							if (err) return;
					
							// @ts-ignore
							map.easeTo({
								center: features[0].geometry.coordinates,
								zoom: zoom
							});
						}
					);
				});
			});
	
			// When a click event occurs on a feature in
			// the unclustered-point layer, open a popup at
			// the location of the feature, with
			// description HTML from its properties.
			// @ts-ignore
			map.on('click', 'unclustered-point', (e) => {
				const coordinates = e.features[0].geometry.coordinates.slice();
				const speciality = e.features[0].properties.speciality;
				const stack = e.features[0].properties.stack;
			
				// Ensure that if the map is zoomed out such that
				// multiple copies of the feature are visible, the
				// popup appears over the copy being pointed to.
				while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
					coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
				}
			
				// @ts-ignore
				new mapboxgl.Popup()
				.setLngLat(coordinates)
				// We display the speciality and the stack of the developer in a way that is more readable
				.setHTML(
					`<h3>Speciality: ${speciality}</h3>
					<p>Stack:<br/>${stack}</p>`
				)
				// @ts-ignore
				.addTo(map);
			});
	
			map.on('mouseenter', 'clusters', () => {
				// @ts-ignore
				map.getCanvas().style.cursor = 'pointer';
			});
			map.on('mouseleave', 'clusters', () => {
				// @ts-ignore
				map.getCanvas().style.cursor = '';
			});
		});
	});
</script>

<style lang="scss">
	@import '../../lib/style/style.scss';
</style>

<div class="map-wrap">
  <div class="map" bind:this={mapContainer} />
</div>
