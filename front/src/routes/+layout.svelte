<script>
	/*----------------------
	|	IMPORTS
	----------------------*/
	import Header from '../components/header/+page.svelte';
	import Footer from '../components/footer/+page.svelte';
	import { setContext } from 'svelte';
	import { writable } from 'svelte/store';

	// We create a store to share data between components
	const store = writable({
		userCounter: 0,
		dataset: {
			type: 'FeatureCollection',
			features: [],
		},
		mapboxDataset: {
			type: 'FeatureCollection',
			features: [],
		},
		lastUser: {
			lng: 2.213749,
			lat: 46.227638,
			zoom: 5,
		},
		apiResponse: {
			message: '',
			data: {},
		},
		showModal: false,
	});

	$: store.subscribe((/** @type {{ userCounter: number; dataset: { type: string; features: any[]; }; mapboxDataset: { type: string; features: any[]; }; lastUser: { lat: number; lng: number; zoom: number;};  }} */ store) => {
		store.mapboxDataset.features = store.dataset.features.filter((/** @type {{ properties: { active: boolean; }; }} */ element) => {
			return element.properties.active === true;
		});
	});

	// We set a Context to share the store with the children
	setContext('store', store);

	
</script>

<style lang="scss">
</style>


<Header />

<main>
	<slot>
	</slot>
</main>

<Footer />
