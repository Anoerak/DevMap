<script>
	import { onMount } from 'svelte';
	import Map from '../components/map/map.svelte';
	import { text } from '@sveltejs/kit';

	let name = 'Anørak';

	onMount(() => {
		console.log('mounted');
	});
</script>

<style type="text/scss">
	section#home {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		height: calc(100vh - 4rem);
	}
	h1 {
		font-size: 3rem;
	}
	h2 {
		font-size: 2rem;
	}
</style>

<section id="home">
	<h1>DevMap</h1>
	<h2>The dev community around the world</h2>

	<Map />

</section>
