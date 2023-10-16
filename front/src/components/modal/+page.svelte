
<script>
	/**
	 * @type {boolean}
	 */
	export let showModal;
	
	/**
	 * @type {HTMLDialogElement}
	 */
	let dialog;

	$: if (dialog && showModal) dialog.showModal();
	
</script>


<!-- svelte-ignore a11y-click-events-have-key-events a11y-no-noninteractive-element-interactions -->
<dialog
	class="dialog"
	bind:this={dialog}
	on:close={() => (showModal = false)}
	on:click|self={() => dialog.close()}
>
	<!-- svelte-ignore a11y-no-static-element-interactions -->
	<div on:click|stopPropagation>
		<slot>
			<hr />
		</slot>
		<!-- svelte-ignore a11y-autofocus -->
		<button
			autofocus
			on:click={() => dialog.close()}
		>X</button>
	</div>
</dialog>


<style>
	dialog {
		position: relative;
		margin: auto;
		max-width: 32rem;
		min-width: 20rem;
		border-radius: 1rem;
		border: none;
		padding: 0;
		box-shadow: 0 0 1rem rgba(0, 0, 0, 0.3);
	}
	dialog::backdrop {
		background: rgba(0, 0, 0, 0.3);
	}
	dialog > div {
		padding: 1em;
	}
	dialog[open] {
		animation: zoom 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
	}
	@keyframes zoom {
		from {
			transform: scale(0.95);
		}
		to {
			transform: scale(1);
		}
	}
	dialog[open]::backdrop {
		animation: fade 0.2s ease-out;
	}
	@keyframes fade {
		from {
			opacity: 0;
		}
		to {
			opacity: 1;
		}
	}
	button {
		display: flex;
		align-items: center;
		justify-content: center;
		position: absolute;
		top: 1rem;
		right: 1rem;
		width: 1rem;
		height: 1rem;
		text-align: center;
		padding: .5rem;
	}
</style>
