class apiServer {
	constructor() {
		this.serverUrl = 'https://127.0.0.1:8000/api';
	}

	// GET One /geojson/id
	async getOneUser(/** @type {string} */ id) {
		const url = `${this.serverUrl}/user_details/${id}`;

		const response = await fetch(url, {
			method: 'GET',
			headers: {
				'Content-Type': 'application/json'
			}
		});

		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		} else {
			const data = await response.json();
			console.log('Success:', data);
			return data; // return the data so it can be used by other functions
		}
	}

	// GET All /geojson
	async getAllUsers() {
		const url = `${this.serverUrl}/getAllGeojson`;

		const response = await fetch(url, {
			method: 'GET',
			headers: {
				'Content-Type': 'application/json'
			}
		});

		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		} else {
			const data = await response.json();
			// console.log('Success:', data[0]);
			return data; // return the data so it can be used by other functions
		}
	}

	// POST /geojson
	async postUser(/** @type {Object} */ data) {
		const url = `${this.serverUrl}/user`;

		const response = await fetch(url, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify(data)
		});

		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		} else {
			const data = await response.json();
			console.log('Success:', data);
			return data; // return the data so it can be used by other functions
		}
	}

	// PUT /geojson/id
	async putUser(/** @type {string} */ id, /** @type {Object} */ data) {
		const url = `${this.serverUrl}/user_details/${id}`;

		const response = await fetch(url, {
			method: 'PUT',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify(data)
		});

		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		} else {
			const data = await response.json();
			console.log('Success:', data);
			return data; // return the data so it can be used by other functions
		}
	}

	// DELETE /geojson/id
	async deleteUser(/** @type {string} */ id) {
		const url = `${this.serverUrl}/user_details/${id}`;

		await fetch(url, {
			method: 'DELETE',
			headers: {
				'Content-Type': 'application/json'
			}
		})
			.then((response) => response.json())
			.then((data) => console.log('Success:', data))
			.catch((error) => console.error('Error:', error));
	}

	// Get All /country
	async getAllCountry() {
		const url = `${this.serverUrl}/countries`;

		const response = await fetch(url, {
			method: 'GET',
			headers: {
				'Content-Type': 'application/json'
			}
		});

		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		} else {
			const data = await response.json();
			// console.log('Success:', data['hydra:member']);
			return data['hydra:member']; // return the data so it can be used by other functions
		}
	}

	// Get All /stack
	async getAllStack() {
		const url = `${this.serverUrl}/tech_stacks`;

		const response = await fetch(url, {
			method: 'GET',
			headers: {
				'Content-Type': 'application/json'
			}
		});

		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		} else {
			const data = await response.json();
			// console.log('Success:', data['hydra:member']);
			return data['hydra:member']; // return the data so it can be used by other functions
		}
	}
}

export default apiServer;
