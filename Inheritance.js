class Cat{ //base class
	constructor(name){
		this.name=name;
	}
	speak(){
		return this.name;
	}
	call(){
		return 'super method';
	}
}
class Dog extends Cat{//inheritance base class
	constructor(Name){
		super(Name);/*call base class constructor
		             function using super method*/
	}
	show(){
		document.write(this.speak()+':'+'geo geo ');//dog call geo geo
	}
	call(){
		document.write(super.call());//call super class method
	}
}
let d=new Dog('Mr');//object declarion of child class
d.show();
d.call();
