class userModel {
	/**
	 * @param {{ email: string, username: string; country: string; zipcode: string; shortZipcode: string; city: string; specialty: string; stack: string[]; longitude: number; latitude: number; }} datas
	 */
	constructor(datas) {
		this.user = {
			country: datas.country,
			zipcode: datas.zipcode,
			shortZipcode: datas.shortZipcode,
			city: datas.city,
			specialty: datas.specialty,
			stack: datas.stack,
			geometryType: 'Point',
			geometryCoordinates: [datas.longitude, datas.latitude],
			user: {
				email: datas.email,
				username: datas.username,
				active: false
			}
		};
	}

	getUser() {
		return this.user;
	}

	/**
	 * @param {{ email: string, username: string; country: string; zipcode: string; shortZipcode: string; city: string; specialty: string; stack: string[]; longitude: number; latitude: number; }} datas
	 */
	setUser(datas) {
		this.user = {
			country: datas.country,
			zipcode: datas.zipcode,
			shortZipcode: datas.shortZipcode,
			city: datas.city,
			specialty: datas.specialty,
			stack: datas.stack,
			geometryType: 'Point',
			geometryCoordinates: [datas.longitude, datas.latitude],
			user: {
				email: datas.email,
				username: datas.username,
				active: false
			}
		};
	}
}

export default userModel;
