#include<stdio.h>
#include<math.h>
#include"functions.h"

double average(int array[]) {
    double avgNum;
    double sum = 0.0;
    int i;
    for (i = 0; i < LENGTH; ++i) {
        sum += array[i];
    }
    avgNum = sum / LENGTH;
    return avgNum;
}

void quadraticFormula(double a, double b, double c, double* x1, double* x2) {
    *x1 = (-b+sqrt(pow(b,2)-4*a*c))/(2*a);

    *x2 = (-b-sqrt(pow(b,2)-4*a*c))/(2*a);

}
