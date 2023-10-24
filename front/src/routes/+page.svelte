<script>
	/*----------------------
	|	IMPORTS
	----------------------*/
	import Map from '../components/map/+page.svelte';
	import { _getAllUsers } from './api/backend/+server';
 	import { onMount, getContext } from 'svelte';

	/*----------------------
	|	VARIABLES
	----------------------*/
	const store = getContext('store');
	
	/*----------------------
	|	FUNCTIONS
	----------------------*/
	onMount(() => {
		_getAllUsers()
			.then((/** @type {{ features: any; }} */ user) => {
				store.update((/** @type {{ userCounter: number; dataset: { type: string; features: any[]; }; }} */ store) => {
					store.dataset.features = [];
					return store;
				});

				user.features.forEach((/** @type {{ properties: { active: boolean; }; }} */ element) => {
					store.update((/** @type {{ userCounter: number; dataset: { type: string; features: any[]; }; }} */ store) => {
						store.dataset.features.push(element);
						return store;
					});
				});
				
			})
			.catch((/** @type {{ message: any; }} */ error) => {
				console.log(error.message);
			});
	});
</script>

<section id="home">
	<div class="header"></div>
	<h1>
		<span class="dev__title">Dev.</span><span class="map__title">map</span><span class="parenthesis__title">(</span><span class="developers__title">developers </span><span class="arrow__title"> =&gt; </span><span class="bracket__title">&#123;</span><span class="dot__title"> ... </span><span class="bracket__title">&#125;</span><span class="parenthesis__title">)</span>
	</h1>
	<h2>
		<!-- While loading data, we display an icon -->
		{#if !$store.userCounter}
			<i class="fas fa-spinner fa-spin"></i>
		{:else if $store.userCounter === 0}
			No active users
		{:else if $store.userCounter === 1}
			{$store.userCounter} active user
		{:else}
			{$store.userCounter} active users
		{/if}
	</h2>

	<Map />
</section>

<style lang="scss">
	@import './home.scss';
</style>
