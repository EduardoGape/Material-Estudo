#include<stdio.h>

int main() {
    int x, y;
    while(scanf("%d %d", &x, &y)!= EOF)
    {
        if(x/30<10){
            if(y/6<10){
                printf("0%d:0%d\n", x/30, y/6);
           }
           else{
                printf("0%d:%d\n", x/30, y/6);
           }
        }
        else{
            if(y/6<10){
                printf("%d:0%d\n", x/30, y/6);
            }
            else{
                printf("%d:%d\n", x/30, y/6);
            }
       }
    }
}