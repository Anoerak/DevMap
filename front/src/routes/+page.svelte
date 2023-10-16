<script>
	import Map from '../components/map/+page.svelte';
	import apiServer from '../hooks/apiServer';

	// We check how user has an active status set to true
	const jsonApi = new apiServer();
	const getActiveUser = async () => {
		const user = await jsonApi.getAllUsers();
		let userCounter = 0;
		user.features.forEach((/** @type {{ properties: { active: boolean; }; }} */ element) => {
			if (element.properties.active === true) {
				userCounter++;
			}
		});
		return userCounter;
	};
</script>

<section id="home">
	<h1>DevMap</h1>
	<h2>{#await getActiveUser()}
			<i class="fa-solid fa-spinner fa-spin-pulse" style="color: #1e3050;"></i>
			<p>Loading...</p>
		{:then userCounter}
			{userCounter} users are active
		{:catch error}
			<p>{error.message}</p>
		{/await}


	<Map />

</section>

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
		text-align: center;
	}
	h2 {
		font-size: 2rem;
		text-align: center;
	}
	.fa-solid {
		margin: 1rem;
	}
</style>
