# include <iostream>
# include <cstdio>
# include <cstring>
using namespace std;
int data[2][2];
int r=2,c=2;
void func(int i,int j)
{
	if(data[i][j]==5)
	{
		cout<<"data location is="<<i<<" "<<j<<"\n";return;
	}
	else
	{
		if(j+1<c)func(i,j+1);
	   else	if(i+1<r)func(i+1,j);
	   else
	   {
	   	cout<<"data not found\n";
	   }
	}

}
int main()
{
	
data[0][0]=1;
data[0][1]=2;
data[1][0]=3;
data[1][1]=4;
func(0,0);
return 0;
}
