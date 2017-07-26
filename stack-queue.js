//START The Queue class
class queue{
	constructor(size){
		this.data=Array();
		this.front=-1;
		this.rear=-1;
		this.maxqueue=size-1;//Queue initialization
		this.recentOut='None';
	}
	isEmpty(){/*check whether Queue is empty or not.is empty than return true otherwise false*/
		if (this.front<0) {
			return true;
		}
		else{
			return false;
		}
	}
	isFull(){/*check whether Queue is Full or not.is full than return true otherwise false*/
		if ((this.front==0 && this.rear==this.maxqueue)||(this.front>this.rear+1)) {
			return true;
		}
		else{
			return false;
		}
	}
	enQueue(value){//data inser in Queue
		if (!this.isFull()) {
			if (this.front==-1 && this.rear==-1) {
				this.front=0;
				this.rear=0;
			}
			else if (this.rear==this.maxqueue) {
				this.rear=0;
			}
			else{
				this.rear=this.rear+1;
			}
			this.data[this.rear]=value;
		}
	}
	deQueue(){//data delete from queue
		if (!this.isEmpty()) {
			this.recentOut=this.data[this.front];
			if (this.rear==this.front) {
				this.rear=-1;
				this.front=-1;
			}
			else if (this.front==this.maxqueue) {
				this.front=0;
			}
			else{
				this.front=this.front+1;
			}
		}
	}
	frontIs(){//return the front index
		if (this.front!=-1) {
			return this.front;
		}
		else{
			return false;
		}
	}
	rearIs(){//return the rear index
		if (this.rear!=-1) {
			return this.rear;
		}
		else{
			return false;
		}
	}
	frontValue(){//return the front value
		if (this.front!=-1) {
			return this.data[this.front];
		}
		else{
			false;
		}
	}
	rearValue(){//return the rear value
		if (this.rear!=-1) {
			return this.data[this.rear];
		}
		else{
			return false;
		}
	}
	recentPeek(){//return the last deleted data
		return this.rearValue;
	}
}


//START The stack class
class stack{
	constructor(size){
		this.data=Array();//stack initialization
		this.top=-1;
		this.maxstack=size-1;//define the stack size
		this.topVal='None';
	}
	isEmpty(){         /*check whether stack is empty or not.is empty than return true otherwise false*/
		if (this.top<0) {
			return true;
		}
		else{
			return false;
		}
	}
	isFull(){ /*check whether stack is Full or not.is full than return true otherwise false*/
		if (this.top==this.maxstack) {
			return true;
		}
		else{
			return false;
		}
	}
	push(value){//push the value in stack
		if (!this.isFull()) {
			this.top=this.top+1;
			this.data[this.top]=value;
		}
	}
	pop(){//pop the value from stack
		if (!this.isEmpty()) {
			this.topVal=this.data[this.top];
			this.top-=1;
		}
	}
	sizeOf(){//return the size of stack
		return this.top+1;
	}
	topValue(){//retur the top value from stack
		return this.data[this.top];
	}
	recentOut(){//which value out from the stack return
		return this.topVal;
	}
}
var stackobject=new stack(5);//Construct function pass stack size
var queueobject=new queue(5);//Construct function pass queue size

