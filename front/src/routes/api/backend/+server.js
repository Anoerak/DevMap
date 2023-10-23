import { API_URL } from '../../../config/config.local';

/*--------------------------
|		GET
--------------------------*/
export function _getAllCountry() {
	const url = `${API_URL}/countries`;

	let response = fetch(url, {
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	})
		.then((response) => response.json())
		.then((data) => data['hydra:member'])
		// .then((data) => console.log('Success:', data['hydra:member']))
		.catch((error) => console.error('Error:', error));

	return response;
}

export function _getAllStack() {
	const url = `${API_URL}/tech_stacks`;

	let response = fetch(url, {
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	})
		.then((response) => response.json())
		.then((data) => data['hydra:member'])
		// .then((data) => console.log('Success:', data['hydra:member']))
		.catch((error) => console.error('Error:', error));

	return response;
}

export function _getOneUser(/** @type {string} */ id) {
	const url = `${API_URL}/user_details/${id}`;

	let response = fetch(url, {
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	})
		.then((response) => response.json())
		.then((data) => data)
		// .then((data) => console.log('Success:', data))
		.catch((error) => console.error('Error:', error));

	return response;
}

export function _getAllUsers() {
	const url = `${API_URL}/getAllGeojson`;

	let response = fetch(url, {
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	})
		.then((response) => response.json())
		.then((data) => data)
		// .then((data) => console.log('Success:', data))
		.catch((error) => console.error('Error:', error));

	return response;
}

/*--------------------------
|		POST
--------------------------*/
export async function _createUser(/** @type {Object} */ data) {
	const url = `${API_URL}/user`;

	// We send the data to the server and get the response to display it
	const response = await fetch(url, {
		method: 'POST',
		// We send the data in JSON format and get the response in in text/html
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify(data)
	});

	const dataResponse = await response.json();

	return dataResponse;
}

/*--------------------------
|		PUT
--------------------------*/
export async function _activateUser(/** @type {Object} */ data) {
	const url = `${API_URL}/user/activate`;

	// We send the data to the server and get the response to display it
	const response = await fetch(url, {
		method: 'PUT',
		// We send the data in JSON format and get the response in in text/html
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify(data)
	});

	const dataResponse = await response.json();

	return dataResponse;
}

/*--------------------------
|		DELETE
--------------------------*/
export async function _deleteUser(/** @type {Object} */ data) {
	const url = `${API_URL}/user/delete`;

	const response = await fetch(url, {
		method: 'DELETE',
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify(data)
	});

	const dataResponse = await response.json();

	return dataResponse;
}
