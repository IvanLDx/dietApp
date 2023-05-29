export class MouseModel {
	constructor() {
		this.x = 0;
		this.y = 0;
		this.set = function (e) {
			this.x = e.clientX;
			this.y = e.clientY;
		};
		this.getTotal = function (elem1, elem2) {
			this.x = elem1.x - elem2.x;
			this.y = elem1.y - elem2.y;
		};
	}
}
