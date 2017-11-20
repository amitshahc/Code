a = 1.1;
b = 2.1;
c = 3.1;

function fa() {
	return "Global fa()";
}

function f() {
	var a = 1;
	this.b = 2;

	function fa() {
		return this.b; // or this.b not working..!
		//return b // 2.2
		//return a // 1
	}

	var bound_fa = fa.bind(this);

	return {
		private_a: a, // 1
		global_a: window.a, // 1.1
		private_b: this.b, // 2
		global_b: b, // 2.1
		private_fax: fa(), // 2.1
		private_fa: bound_fa, // function private fa()
		global_fa: window.fa(), // Global fa()
		global_c: c, // 3.1
		private_c: this.c // 3
	};
}

try {
	f.prototype.c = 3;
	//var x = Object.create(f());
	var x = new f();
	//var x = f();

	f.prototype.c = 4;

	console.log("x:", x);
	console.log("x.private_fa():", x.private_fa());

	console.log("x.private_c", x.private_c);
	var x1 = new f();
	console.log("x1.private_c: ", x1.private_c);

	console.error(" - ");
} catch (e) {
	console.error("Error: ", e.message);
}
