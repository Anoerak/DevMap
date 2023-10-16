import { OPENWEATHER_API_KEY } from '../config/config.local.js';
import { error } from '@sveltejs/kit';
class apiGeoLoc {
	constructor() {
		this.coordLocalDbUrl = 'http://localhost:7878/search?q=';
		this.coordOpenWeatherUrl = 'http://api.openweathermap.org/geo/1.0/zip?zip=';
	}

	async getCoord(/** @type {string} */ zip, /** @type {string} */ city) {
		const url = `${this.coordLocalDbUrl}${zip}&municipality=${city}&limit=1`;

		const response = await fetch(url);

		if (!response.ok) {
			throw error(
				response.status,
				`Something's wrong with your location datas. Please check your inputs!`
			);
		} else {
			const data = await response.json();
			return data;
		}
	}

	async getCoordByZipCountry(/** @type {string} */ zip, /** @type {string} */ country) {
		const url = `${this.coordOpenWeatherUrl}${zip},${country}&limit=1&appid=${OPENWEATHER_API_KEY}`;

		const response = await fetch(url);

		if (!response.ok) {
			return {
				error: true,
				code: response.status,
				message: `Something's wrong with your location datas. Please check your inputs!`
			};
		} else {
			const data = await response.json();
			return data;
		}
	}
}

export default apiGeoLoc;
