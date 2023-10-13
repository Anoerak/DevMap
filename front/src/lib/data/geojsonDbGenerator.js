import apiGeoLoc from '../../hooks/apiGeoLoc';
import apiJsonServer from '../../hooks/apiJsonServer';

export const geojsonDbGenerator = async (
	/** @type {string} */ zip,
	/** @type {string} */ country
) => {
	// @ts-ignore
	let specialities = ['front', 'back', 'full'];
	let stacks = [
		'javascript',
		'node',
		'express',
		'react',
		'react-native',
		'angular',
		'vue',
		'html',
		'css',
		'sass',
		'less',
		'bootstrap',
		'bulma',
		'foundation',
		'ionic',
		'jquery',
		'php',
		'symfony',
		'laravel',
		'wordpress',
		'ruby',
		'rails',
		'python',
		'django',
		'java',
		'spring',
		'c#',
		'asp.net',
		'c++',
		'c',
		'go'
	];
	let city = '';
	/**
	 * @type {Array<number>}
	 */
	let coordinates = [];
	/**
	 * @type {Array<string>}
	 */
	let zipCollection = [];
	/**
	 * @type {Array<object>}
	 */
	const datas = [];
	const apiGeoLocCall = new apiGeoLoc();
	const apiJson = new apiJsonServer();

	const zipGenerator = () => {
		for (let i = 0; i < 949; i++) {
			// We generate zipcode as string from 01000 to 95900 by incrementing 100 by 100
			let zipCode = 1000 + i * 100;
			// We add a 0 if the zipcode is less than 10000
			if (zipCode < 10000) {
				// @ts-ignore
				zipCode = '0' + zipCode;
			}
			// We add the zipcode to the array
			zipCollection.push(zipCode.toString());
		}
	};

	zipGenerator();

	// For each, we get the data from the apiGeoLoc function
	for (const zipCode of zipCollection) {
		const data = await apiGeoLocCall.getCoord(zipCode, country);
		if (data.features[0] !== undefined) {
			datas.push(data);
		}
	}

	datas.forEach((data) => {
		// @ts-ignore
		city = data.features[0].properties.city;
		// @ts-ignore
		coordinates.push(data.features[0].geometry.coordinates[0]);
		// @ts-ignore
		coordinates.push(data.features[0].geometry.coordinates[1]);

		let developer = {
			properties: {
				cluster_id: Math.floor(Math.random() * 100),
				country: country,
				zipcode: zip,
				department: zip.slice(0, 2),
				city: city,
				speciality: specialities[Math.floor(Math.random() * specialities.length)],
				stack: stacks
					.sort(() => Math.random() - Math.random())
					.slice(0, Math.floor(Math.random() * stacks.length))
			},
			geometry: {
				type: 'Point',
				coordinates: coordinates
			}
		};

		// We slow down the process to avoid the 429 error
		setTimeout(() => {
			apiJson.postGeojson(developer);
		}, 500);

		// We empty coordinates
		coordinates = [];
		city = '';
	});
};
