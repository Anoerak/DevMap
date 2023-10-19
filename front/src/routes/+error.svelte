<script>
	import { page } from '$app/stores';
	import { emojis } from '$lib/emojis';
</script>

<section id="error">
	<h1>Here it comes.. </h1>
	<h2>{$page.status} {$page.error.message}</h2>
	<span style='font-size: 10em'>
		{emojis[$page.status] ?? emojis[500]}
	</span>
</section>


<style lang=scss>
	section#error {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		height: calc(100vh - 4rem);
		h1 {
			font-size: 3rem;
		}
		h2 {
			font-size: 2rem;
		}
	}
</style>
