<script>
// @ts-nocheck

	import { onMount, getContext } from 'svelte';
	/*----------------------
	|	IMPORTS
	----------------------*/
	// @ts-ignore
	import userModel from '../../models/userModel.js';

	import { getAllCountry, getAllStack, createUser } from '../../routes/api/backend/+server';
	import { getCoordByZipCountry } from '../../routes/api/openweather/+server';
	import { error } from '@sveltejs/kit';

	/*----------------------
	|	DECLARATIONS (VARIABLES)
	----------------------*/
	const store = getContext('store');
	
	/**
	 * @type {any[]}
	 */
	let countries = [],
		/**
		 * @type {string[]}
		*/
		stack = [],
		/**
		 * @type {any}
		 * */
		geoDatas = {
			country: '',
			zipcode: '',
			name: '',
			lat: 0,
			lon: 0,
		},
		/**
		 * @type {string[]}
		 * */
		stackSelection = [],
		/**
		 * @type {any}
		 * */
		// @ts-ignore
		response = {},
		/**
		 * @type {Object}
		 * */
		user = {};

	/*----------------------
	|	FUNCTIONS
	----------------------*/
	const countriesList = async() => {
		countries = await getAllCountry();
	};

	const stackList = async () => {
		stack = await getAllStack();
		stack.sort(
			/** @type {Object} */
			(a, b) => {
				if(a.name < b.name) {
					return -1;
				}
				if(a.name > b.name) {
					return 1;
				}
				return 0;
			}
		);
	};

	const geoList = async (/** @type {string} */ zip, /** @type {string} */ country) => {
		const geoPromise = await getCoordByZipCountry(zip, country);
		if(geoPromise.error) {
			const errorSpan = document.querySelector('.error');
			// @ts-ignore
			errorSpan.innerHTML = 'Zipcode not found, use the ISO alpha-2 zipcode please';
			// @ts-ignore
			errorSpan.style.display = 'block';
			throw error(geoPromise.code, `Something's wrong with your location datas. Please check your inputs!`);
		}
		geoDatas.lat = geoPromise.lat;
		geoDatas.lon = geoPromise.lon;
		geoDatas.name = geoPromise.name;
		geoDatas.country = geoPromise.country;
		geoDatas.zipcode = geoPromise.zipcode;
		return geoDatas;
	};

	const registerStackSelection = (/** @type {any} */ form) => {
		const stackSelect = form.elements.stack;
		stackSelect.forEach((/** @type {{ checked: any; value: string; }} */ element) => {
			if(element.checked) {
				stackSelection.push(element.value);
			}
		});
		return stackSelection;
	};

	const handleSubmit = async (/** @type {Event} */ event) => {
		event.preventDefault();
		const form = event.currentTarget;
		const formData = new FormData(form);
		registerStackSelection(form);
		const data = Object.fromEntries(formData);
		
		await geoList(data.zipcode.toString(), data.country.toString());
		
		const dataToSend = {
			country: data.country.toString(),
			zipcode: data.zipcode.toString(),
			shortZipcode: data.zipcode.toString().slice(0, 2),
			city: geoDatas.name.toString(),
			specialty: data.specialty.toString(),
			stack: stackSelection,
			geometryType: 'Point',
			geometryCoordinates: [geoDatas.lon, geoDatas.lat],
			email: data.email.toString(),
			username: data.username.toString()
		};

		user = new userModel().setUser(dataToSend);

		response = await createUser(user);

		return response;
	};
	
	onMount(() => {
		countriesList();
		stackList();
	});
</script>


<form
	method="POST"
	on:submit|preventDefault={handleSubmit}
	>
	<label for="username">Username</label>
	<input 
		type="text" 
		name="username" 
		id="username" 
		placeholder="Username"
		required
	>

	<label for="email">Email</label>
	<input 
		type="email" 
		name="email" 
		id="email" 
		placeholder="Email"
		required
	>

	<label for="country">Country</label>
	<select 
		name="country" 
		id="country"
		required
	>
		{#await countries}
			<option value="">Loading...</option>
		{:then country}
			{#each country as c}
				<option value={c.Code}>{c.Name}</option>
			{/each}
		{:catch error}
			<p>{error.message}</p>
		{/await}
	</select>

	<label for="zipcode">Zip Code</label>
	<input 
		type="text" 
		name="zipcode" 
		id="zipcode" 
		placeholder="Zip Code"
		required
	>

	<label for="specialty">Your specialty</label>
	<select 
		name="specialty" 
		id="specialty"
		required
	>
		<option value="">Select your speciality</option>
		<option value="Front">Front</option>
		<option value="Back">Back</option>
		<option value="Fullstack">Fullstack</option>
	</select>

	<!-- <label for="stack">Your stack</label> -->
	<fieldset
		name="stack"
		id="stack"
	>
		<legend>Your stack</legend>
		{#await stack}
			<p>Loading...</p>
			{:then s}
				{#each s as st}
					<div class="input__container">
					<label for={st.name}>{st.name}</label>
					<input type="checkbox" name="stack" id={st.name} value={st.name} multiple>
					</div>
				{/each}
			{:catch error}
				<p>{error.message}</p>
		{/await}
	</fieldset>


	<button 
		type="submit"
	>
		Register
	</button>

	<span class="error"></span>

</form>


<style lang="scss">
	@import './register_form.scss';
</style>
