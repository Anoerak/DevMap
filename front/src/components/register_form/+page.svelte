<script>
	// We import our model
	// @ts-ignore
	import userModel from '../../models/userModel.js';
	// We import our api
	import apiServer from '../../hooks/apiServer.js';
	import apiGeoLoc from '../../hooks/apiGeoLoc.js';
	import { error } from '@sveltejs/kit';

	
	// We create a new instance of our api
	const api = new apiServer();
	const apiGeo = new apiGeoLoc();

	/**
	 * @type {any[]}
	 */
	const countries = [];
	/**
	 * @type {any[]}
	 */
	const stack = [];
	/**
	 * @type {any}
	 */
	const geoDatas = {
		country: '',
		zipcode: '',
		name: '',
		lat: 0,
		lon: 0,
	};
	
	const countriesList = async () => {
		const country = await api.getAllCountry();
		country.forEach((/** @type {any} */ element) => {
			countries.push(element);
		});
		return countries;
	};

	const stackList = async () => {
		const stackPromise = await api.getAllStack();

		stackPromise.forEach((/** @type {any} */ element) => {
			stack.push(element.name);
		});
		stack.sort();
		return stack;
	};

	const geoList = async (/** @type {string} */ zip, /** @type {string} */ country) => {
		const geoPromise = await apiGeo.getCoordByZipCountry(zip, country);
		if(geoPromise.error) {
			const errorSpan = document.querySelector('.error');
			errorSpan.innerHTML = 'Zipcode not found, use the ISO alpha-2 zipcode please';
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

	/**
	 * @type {any[]}
	 */
	const stackSelection = [];

	const registerStackSelection = (/** @type {any} */ form) => {
		const stackSelect = form.elements.stack;
		for (let i = 0; i < stackSelect.length; i++) {
			if (stackSelect[i].selected) {
				stackSelection.push(stackSelect[i].value);
			}
		}
		return stackSelection;
	};

	// We collect the datas from the POST
	const handleSubmit = async (/** @type {Event} */ event) => {
		event.preventDefault();
		const form = event.target;
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
			longitude: geoDatas.lat, 
			latitude: geoDatas.lon,
			email: data.email.toString(),
			username: data.username.toString()
		};

		const user = new userModel(dataToSend);

		console.log(user.user);
		
		await api.postUser(user.user);
	};
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
		{#await countriesList()}
			<option value="">Loading...</option>
		{:then country}
			{#each country as country}
				<option value="{country.Code}">{country.Name}</option>
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

	<label for="stack">Your stack</label>
	<select 
		name="stack" 
		id="stack"
		multiple
		required
	>
		{#await stackList()}
			<option value="">Loading...</option>
		{:then stack}
			{#each stack as stack}
				<option value="{stack}">{stack}</option>
			{/each}
		{:catch error}
			<p>{error.message}</p>
		{/await}
	</select>


	<button 
		type="submit"
	>
		Register
	</button>

	<span class="error"></span>

</form>



<style>
	@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

	* {
		box-sizing: border-box;
	}

	form {
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	label {
		font-family: 'Roboto', sans-serif;
		margin-top: 1rem;
	}

	input, select {
		font-family: 'Roboto', sans-serif;
		margin-top: 0.5rem;
		padding: 0.5rem;
		border: 1px solid #ccc;
		border-radius: 0.5rem;
	}

	button {
		font-family: 'Roboto', sans-serif;
		margin-top: 1rem;
		padding: 0.5rem;
		border: 1px solid #ccc;
		border-radius: 0.5rem;
		background-color: #ccc;
		cursor: pointer;
	}

	button:hover {
		background-color: #fff;
	}

	.error {
		display: none;
		font-family: 'Roboto', sans-serif;
		color: red;
		margin-top: 1rem;

	}
</style>
