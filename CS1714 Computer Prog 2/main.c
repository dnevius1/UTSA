#include <stdio.h>
#include <math.h>

int main (void) {
    #define LENGTH 10
    double array[LENGTH];
    int i;
    double avg;
    double sum = 0;
    for (i = 0; i < LENGTH; ++i) {
        scanf("%lf", &array[i]);
    }
    for (i = 0; i < LENGTH; ++i) {
        sum = sum + array[i];
    }
    avg = sum / LENGTH;
    printf("average: %0.2lf\n", avg);
    for (i = 0; i < LENGTH; ++i) {
      array[i] = pow(array[i] - avg, 2);
      //printf("%lf\n", array[i]);
    }
    sum = 0;
    for (i = 0; i < LENGTH; ++i) {
        sum = sum + array[i];
        avg = sum / LENGTH;
    }
    printf("standard deviation: %0.2lf\n", sqrt(avg));
    return 0;
}
