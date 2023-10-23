import {
	OPENWEATHER_API_KEY,
	LOCAL_DB_URL,
	OPENWEATHER_API_URL
} from '../../../config/config.local.js';

export function _getCoord(/** @type {string} */ zip, /** @type {string} */ city) {
	const url = `${LOCAL_DB_URL}${zip}&municipality=${city}&limit=1`;

	const response = fetch(url)
		.then((response) => response.json())
		// .then((data) => console.log('Success:', data)
		.then((data) => data)
		// .catch((error) => console.error('Error:', error));
		.catch((error) => {
			return {
				error: true,
				code: error.status,
				message: `Something's wrong. Please check your inputs!`
			};
		});

	return response;
}

export function _getCoordByZipCountry(/** @type {string} */ zip, /** @type {string} */ country) {
	const url = `${OPENWEATHER_API_URL}${zip},${country}&limit=1&appid=${OPENWEATHER_API_KEY}`;

	const response = fetch(url)
		.then((response) => response.json())
		// .then((data) => console.log('Success:', data)
		.then((data) => data)
		// .catch((error) => console.error('Error:', error));
		.catch((error) => {
			return {
				error: true,
				code: error.status,
				message: `Something's wrong with your location datas. Please check your inputs!`
			};
		});

	return response;
}
