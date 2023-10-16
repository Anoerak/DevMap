<script>
	import { page } from '$app/stores';
	import { afterUpdate } from 'svelte';
	import Logo from '../../lib/img/logo.webp';
	import MenuSvg from '../../lib/img/svg/menu.svg';
	import Modal from '../modal/+page.svelte';
	import RegisterForm from '../register_form/+page.svelte';

	// Set the current URL
	let pageTag = $page.url.pathname.split('/').filter(Boolean).pop() || '/';
	// Set it as soon as pages update
	afterUpdate(() => {
		pageTag = $page.url.pathname.split('/').filter(Boolean).pop() || '/';
		return pageTag;
	});

	let showModal = false;

</script>

<style lang="scss">
	@import './_header.scss';
</style>

<header>
	<div class="logo">
		<a href="/">
			<img src={Logo} alt="dark person icon behind a computer screen, a glove behind them.">
		</a>
	</div>

	<nav>
		<ul>
			<li>
				<a href="/" class={pageTag === '/' ? 'active' : ''}>
					<i class="fa-solid fa-house"></i>
					Home
				</a>
			</li>
			<li>
				<a class={pageTag === 'about' ? 'active' : ''} href="/about">
					<i class="fa-solid fa-circle-info"></i>
					About
				</a>
			</li>
			<li>
				<a class={pageTag === 'contact' ? 'active' : ''} href="/contact">
					<i class="fa-regular fa-comment"></i>
					Contact
				</a>
			</li>
			<li>
			</li>
	</nav>


	<div class="responsive__menu">
		<img id="responsive-menu-button" src={MenuSvg} alt="Menu button composed of 12 white blocks on 3 rows">
	</div>

	<div class="register">
		<button on:click={
			() => {
				showModal = true;
			}
		}>
			Register
		</button>
	</div>
</header>

<Modal bind:showModal>
	<RegisterForm />
</Modal>
