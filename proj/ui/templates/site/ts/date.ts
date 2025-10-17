class UIDate {

	static today(): string {
		let d = new Date();
		let day = d.getDate();
		let month = d.getMonth() + 1;
		let year = d.getFullYear();

		return `${year}-${month}-${day}`;
	}

}