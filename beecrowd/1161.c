#include <stdio.h>
 
int main() {
 
  int m, n;
    int i;
    long long fat[21];
    fat[0] = 1;

    for(i = 1; i <= 20; i++){
            fat[i] = fat[i-1]*i;
     }

    while(scanf("%d",&m)!= EOF){
                   scanf("%d",&n);
                 printf("%lld\n", fat[m] + fat[n]);
    }
    return 0;
}