<script>
	/*----------------------
	|	IMPORTS
	----------------------*/
	import '@fortawesome/fontawesome-free/css/all.min.css';
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
			status: 0,
			title: '',
			message: '',
		},
		modals: {
			showModal: false,
			popUpModal: false,
		}
	});

	$: store.subscribe((/** @type {{ userCounter: number; dataset: { type: string; features: any[]; }; mapboxDataset: { type: string; features: any[]; }; lastUser: { lat: number; lng: number; zoom: number;};  }} */ store) => {
		store.mapboxDataset.features = store.dataset.features.filter((/** @type {{ properties: { active: boolean; }; }} */ element) => {
			return element.properties.active === true;
		});
		store.userCounter = store.mapboxDataset.features.length !== 0 ? store.mapboxDataset.features.length : 0;
	});

	// We set a Context to share the store with the children
	setContext('store', store);

	
</script>

<style lang="scss">
</style>


<Header />

<main>
	<!-- svelte-ignore a11y-click-events-have-key-events a11y-no-noninteractive-element-interactions -->
	<dialog 
		class="popup__modal"
		open={$store.modals.popUpModal}
		on:click|self={() => $store.modals.popUpModal = false}
	>
		<div>
			<h1>{$store.apiResponse.title}</h1>
			<p>{$store.apiResponse.message}</p>
		</div>
		<button
			class="close__button"
			on:click={() => $store.modals.popUpModal = false}
		>
		x
		</button>
	</dialog>
	<slot>
	</slot>
</main>

<Footer />
