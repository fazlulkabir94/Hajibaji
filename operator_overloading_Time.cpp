# include <iostream>
using namespace std;
class Time{
public:
	double Hour;
	double Minue;
	Time(){};
	void input(){
		cout<<"Enter the exact Hour:"<<endl;
		cin>>Hour;
		cout<<"Enter the exact Minue:"<<endl;
		cin>>Minue;
		cout<<endl<<"Hour is:"<<Hour<<"H"<<endl<<"Minue is:"<<Minue<<"m"<<endl;
	}
	double getHour(double min){//convert Minue to Hour
		return min/60;
	}
	Time(double hour,double min){
		Hour=hour;
		Minue=min;
	}
	Time operator+(Time obj){
		Time temp1,temp2,total;
		temp1.Hour=Hour+getHour(Minue);
		temp2.Hour=obj.Hour+getHour(obj.Minue);
		total.Hour=temp1.Hour+temp2.Hour;
		return total;
	}
	Time operator-(Time obj){
		Time temp1,temp2,total;
		temp1.Hour=Hour+getHour(Minue);
		temp2.Hour=obj.Hour+getHour(obj.Minue);
		total.Hour=temp1.Hour-temp2.Hour;
		return total;
	}
	Time(double min){
		Minue=min;
	}
	Time operator++(){//Prefix operator overloading
		Time temp;
		++Minue;
		temp.Minue=Minue;
		return temp;
	}
	Time operator++(int){//Postfix operator overloading
		Time temp;
		Minue++;
		temp.Minue=Minue;
		return temp;
	}
    bool operator>(Time obj){
		Time temp1,temp2,total;
		temp1.Hour=Hour+getHour(Minue);
		temp2.Hour=obj.Hour+getHour(obj.Minue);
		if (temp1.Hour>temp2.Hour)return true;
		else
			return false;
	}

};
int main(){
	Time user;
	user.input();
	double hour,min;
	cout<<"Enter first object Hour:"<<endl;
	cin>>hour;
	cout<<"Enter first object Minue:"<<endl;
	cin>>min;
	Time a(hour,min);
	cout<<"Enter second object Hour:"<<endl;
	cin>>hour;
	cout<<"Enter second object Minue:"<<endl;
	cin>>min;
	Time b(hour,min);
	Time sum,sub;
	sum=a+b;
	sub=a-b;
	++a;
	b++;
	cout<<"Overloading Action>>>>>>>>"<<endl;
	cout<<"Total Time two Object after add:"<<sum.Hour<<"H"<<endl;
	cout<<"Total Time two Object after Substract:"<<sub.Hour<<"H"<<endl;
	cout<<"increment Prefix Object ++a:"<<a.Minue<<"m"<<endl;
	cout<<"increment Postfix Object b++:"<<b.Minue<<"m"<<endl;
	if(a>b)
		cout<<"Left object has bigger"<<endl;
	else
		cout<<"Right object has bigger"<<endl;
	return 0;
}
