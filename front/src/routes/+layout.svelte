<script>
	import Header from '../components/header/Header.svelte';
	import Footer from '../components/footer/Footer.svelte';
</script>

<style lang="scss">
	@import '../lib/style/style.scss';
</style>


<Header />

<main>
	<slot></slot>
</main>

<Footer />
