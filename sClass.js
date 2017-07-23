class Point{
	constructor(x,y){
		this.x=x;
		this.y=y;
	}
	static distance(a,b){//using Static method 
		const  dx=a.x-b.x;
		const dy=a.y-b.y;
		     return Math.hypot(dx,dy);//sqrt((a*a)=(b*b))
	}
}
p1=new Point(5,5);//line point a
p2=new Point(10,10);//line point b
document.write(Point.distance(p1,p2));
