#include<stdio.h>
#include"functions.h"

int main(int argc, char* argv[]) {
    int array[LENGTH];
    int i;
    double a;
    double b;
    double c;
    double x1;
    double x2;
    for (i = 0; i < LENGTH; ++i) {
     scanf("%d", &array[i]);
    }
    scanf("%lf", &a);
    scanf("%lf", &b);
    scanf("%lf", &c);
    quadraticFormula(a, b, c, &x1, &x2);
    printf("average: %0.2lf\n", average(array));
    printf("x1: %0.2lf\n", x1);
    printf("x2: %0.2lf", x2);
}
