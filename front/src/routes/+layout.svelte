<script>
	import Header from '../components/header/+page.svelte';
	import Footer from '../components/footer/+page.svelte';

</script>

<style lang="scss">
	@import '../lib/style/style.scss';
</style>


<Header />

<main>
	<slot>
	</slot>
</main>

<Footer />
