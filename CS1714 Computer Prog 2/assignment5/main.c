#include <stdio.h>
#include <math.h>
#include "point.h"

int main(void) {
    Point a;
    Point b;
    Point m;
    double dist;
    scanf("%lf", &a.x);
    scanf("%lf", &a.y);
    scanf("%lf", &a.z);
    scanf("%lf", &b.x);
    scanf("%lf", &b.y);
    scanf("%lf", &b.z);
    midpoint(a, b, &m);
    distance(a, b, &dist);
    printf("midpoint: %0.2lf, %0.2lf, %0.2lf\n", m.x, m.y, m.z);
    printf("distance: %0.2lf", dist);


}
