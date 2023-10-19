
<script>
	import { getContext } from 'svelte';
	
	const store = getContext('store');

	/**
	 * @type {HTMLDialogElement}
	 */
	let dialog;

	$: if ($store.showModal) {
		dialog.showModal();
	}
	
</script>


<!-- svelte-ignore a11y-click-events-have-key-events a11y-no-noninteractive-element-interactions -->
<dialog
	class="dialog"
	bind:this={dialog}
	on:close={() => ($store.showModal = false)}
	on:click|self={() => dialog.close()}
>
	<!-- svelte-ignore a11y-no-static-element-interactions -->
	<div on:click|stopPropagation>
		<slot>
			<hr />
		</slot>
		<!-- svelte-ignore a11y-autofocus -->
		<button
			class="close__button"
			autofocus
			on:click={() => dialog.close()}
		>x</button>
	</div>
</dialog>


<style>
	@import './_modal.scss';
</style>
