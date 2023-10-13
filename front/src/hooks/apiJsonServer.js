class apiJsonServer {
	constructor() {
		this.serverUrl = 'http://localhost:3000';
	}

	// GET One /geojson/id
	async getGeojson(/** @type {string} */ id) {
		const url = `${this.serverUrl}/geojson/${id}`;

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
	async getAllGeojson() {
		const url = `${this.serverUrl}/geojson`;

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
			console.log('Success:', data[0]);
			return data[0]; // return the data so it can be used by other functions
		}
	}

	// POST /geojson
	async postGeojson(/** @type {Object} */ data) {
		const url = `${this.serverUrl}/geojson`;

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
	async putGeojson(/** @type {string} */ id, /** @type {Object} */ data) {
		const url = `${this.serverUrl}/geojson/${id}`;

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
	async deleteGeojson(/** @type {string} */ id) {
		const url = `${this.serverUrl}/geojson/${id}`;

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
}

export default apiJsonServer;
