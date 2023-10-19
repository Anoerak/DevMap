<script>
	/*----------------------
	|	IMPORTS
	----------------------*/
	import GitHub from '$lib/img/github.webp';
	import GitLab from '$lib/img/gitlab.webp';
	import LinkedIn from '$lib/img/Linkedin_logo.webp';
	import { activateUser, deleteUser } from '../../routes/api/backend/+server.js';
	import { getContext } from 'svelte';

	/*----------------------
	|	FUNCTIONS
	----------------------*/
	const store = getContext('store');

	const userActivation = async () => {
		const form = document.getElementById('form1');
		const formData = new FormData(form);
		const email = formData.get('email');
		const response = await activateUser({
			email: email,
		});
		if(response.message === 'User activated') {
			store.update((/** @type {{ userCounter: number; dataset: { type: string; features: any[]; }; lastUser: {lat: number; lng: number; zoom: number }; }} */ store) => {
				store.userCounter++;
				return store;
			});
			// We change the status of the user into the store
			store.update((/** @type {{ userCounter: number; dataset: { type: string; features: any[]; }; lastUser: {lat: number; lng: number; zoom: number }; }} */ store) => {
				store.dataset.features.forEach((/** @type {{ properties: { email: string; active: boolean; }; geometry: { coordinates: any[] }; }} */ element) => {
					if (element.properties.email === email) {
						element.properties.active = true;
						// We set the last user coordinates
						store.lastUser.lat = element.geometry.coordinates[1];
						store.lastUser.lng = element.geometry.coordinates[0];
						store.lastUser.zoom = 14;
					}
				});
				return store;
			});
		} else if (response.message === 'User deactivated') {
			store.update((/** @type {{ userCounter: number; dataset: { type: string; features: any[]; }; lastUser: {lat: number; lng: number; zoom: number }; }} */ store) => {
				store.userCounter--;
				return store;
			});
			// We change the status of the user into the store
			store.update((/** @type {{ userCounter: number; dataset: { type: string; features: any[]; }; lastUser: {lat: number; lng: number; zoom: number }; }} */ store) => {
				store.dataset.features.forEach((/** @type {{ properties: { email: string; active: boolean; }; geometry: { coordinates: any[] }; }} */ element) => {
					if (element.properties.email === email) {
						element.properties.active = false;
						// We set the coordinates to their initial values
						store.lastUser.lat = 46.227638;
						store.lastUser.lng = 2.213749;
						store.lastUser.zoom = 5;
					}
				});
				return store;
			});
			alert('Your profile has been deactivated');
		} else {
			alert('Something went wrong.' + '\n' + response.message);
		}
	};

	const userDeletion = async () => {
		/**
		 * @type {HTMLFormElement}
		 */
		if(!confirm('Are you sure you want to delete your profile?')) return;

		const form = document.getElementById('form1');
		const formData = new FormData(form);
		const email = formData.get('email');
		const response = await deleteUser({
			email: email,
		});

		if(response.message === 'User deleted') {
			store.update((/** @type {{ userCounter: number; dataset: { type: string; features: any[]; }; lastUser: {lat: number; lng: number; zoom: number }; }} */ store) => {
				store.userCounter--;
				return store;
			});
			// We change the status of the user into the store
			store.update((/** @type {{ userCounter: number; dataset: { type: string; features: any[]; }; lastUser: {lat: number; lng: number; zoom: number }; }} */ store) => {
				store.dataset.features.forEach((/** @type {{ properties: { email: string; active: boolean; }; geometry: { coordinates: any[] }; }} */ element) => {
					if (element.properties.email === email) {
						element.properties.active = false;
						// We set the coordinates to their initial values
						store.lastUser.lat = 46.227638;
						store.lastUser.lng = 2.213749;
						store.lastUser.zoom = 5;
					}
				});
				return store;
			});
			alert('Your profile has been deleted');
		} else {
			alert('Something went wrong.' + '\n' + response.message);
		}
	};
</script>

<style lang="scss">
	@import './_footer.scss';

</style>

<footer>
	<div class="website">
		<h2>Website</h2>
		<ul>
			<li>-<a href="/">Home</a></li>
			<li>-<a href="/about">About</a></li>
			<li>-<a href="/contact">Contact</a></li>
		</ul>
	</div>
	<div class="social">
		<h2>Follow me</h2>
		<ul>
			<li>
				<a href="https://github.com/Anoerak" target=”_blank”>
					<img src={GitHub} alt="Little white mouse 'ish on black background" />
					Github
				</a>
			</li>
			<li>
				<a href="https://gitlab.com/Anoerak" target=”_blank”>
					<img src={GitLab} alt="A fox head" />
					GitLab
				</a>
			</li>
			<li>
				<a href="https://www.linkedin.com/in/s%C3%A9bastien-p-48717074/" target=”_blank”>
					<img src={LinkedIn} alt="LinkedIn in white character on blue background" />
					Linkedin
				</a>
			</li>
		</ul>
	</div>
	<div class="profile">
		<h2>Activate/Deactivate your status</h2>
		<p>If you've already created an account, use your email address to activate/deactivate your status.</p>
		<form 
			id="form1" 
			class="profile__form"
		>
			<input type="text" id="email" name="email" placeholder="Your email" class="profile__input">
			<input 
				type="submit" 
				value="Change Status" 
				class="main__button change__status"
				on:click={userActivation}
			>
			<input 
				type="submit" 
				value="Delete Profile" 
				class="main__button delete__profile"
				on:click={userDeletion}
			>
		</form>
		<p class="privacy__policy__link">We care about your data in our <a href="/privacy">privacy policy</a></p>
	</div>
</footer>
