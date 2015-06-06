# include <iostream>
# include <cstdio>
using namespace std;
# define ll long long
int main()
{
	//freopen("in","r",stdin);
	ll **prob;
	int maxn=0,maxk=0;
	int t;
	ll N[1000];
	ll K[1000];
	cin>>t;
	for(int i=0;i<t;i++)
	{
		cin>>N[i]>>K[i];
		if(maxn<N[i])maxn=N[i];
		if(maxk<K[i])maxk=K[i];
	}
	prob=new ll*[maxn+1];
	for(int i=0;i<maxn;i++)prob[i]=new ll[maxk+1];
	for(int i=0;i<maxk && i<6;i++)prob[0][i]=(ll)100.0/6.0;
	for(int i=1;i<maxn;i++)
		for(int j=i;j<maxk && j<=6*(i+1);j++)
		{
			if(j-1>=0)prob[i][j]+=prob[i-1][j-1];
			if(j-2>=0)prob[i][j]+=prob[i-1][j-2];
			if(j-3>=0)prob[i][j]+=prob[i-1][j-3];
			if(j-4>=0)prob[i][j]+=prob[i-1][j-4];
			if(j-5>=0)prob[i][j]+=prob[i-1][j-5];
			if(j-6>=0)prob[i][j]+=prob[i-1][j-6];
			prob[i][j]/=6.0;
		}
		for(int i=0;i<t;i++)
			printf("%lld\n",(ll)prob[N[i]-1][K[i]-1]);
	return 0;
}
