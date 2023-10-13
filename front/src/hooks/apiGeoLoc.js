class apiGeoLoc {
	constructor() {
		this.coordUrl = 'http://localhost:7878/search?q=';
	}

	async getCoord(/** @type {string} */ zip, /** @type {string} */ city) {
		const url = `${this.coordUrl}${zip}&municipality=${city}&limit=1`;

		const response = await fetch(url);
		const data = await response.json();

		return data;
	}
}

export default apiGeoLoc;
