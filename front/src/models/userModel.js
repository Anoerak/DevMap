class userModel {
	constructor() {
		/**
		 * @param {{ country: string; zipcode: string; shortZipcode: string; city: string; specialty: string; stack: string[]; geometryCoordinates: number[]; email: string; username: string; }} datas
		 */
		this.user = {
			country: '',
			zipcode: '',
			shortZipcode: '',
			city: '',
			specialty: '',
			stack: [''],
			geometryType: 'Point',
			geometryCoordinates: [0, 0],
			user: {
				email: '',
				username: '',
				active: false
			}
		};
	}

	getUser() {
		return this.user;
	}

	/**
	 * @param {{ country: string; zipcode: string; shortZipcode: string; city: string; specialty: string; stack: string[]; geometryCoordinates: number[]; email: string; username: string; }} datas
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
			geometryCoordinates: datas.geometryCoordinates,
			user: {
				email: datas.email,
				username: datas.username,
				active: false
			}
		};

		return this.user;
	}
}

export default userModel;
