#include <stdio.h>
 
int main() {
 
    int temp, horas, minutos, segundos;
    int hsegundos;
    
    hsegundos=3600;
    
    scanf("%d", &temp);
    
    horas=(temp/hsegundos);
    minutos=(temp-(hsegundos*horas))/60;
    segundos=(temp-(hsegundos*horas)-(minutos*60));
    
    printf("%d:%d:%d\n", horas, minutos, segundos);
 
    return 0;
}