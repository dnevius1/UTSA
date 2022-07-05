#include <stdio.h>
#include <math.h>
#include "point.h"

void midpoint(Point a, Point b, Point* m){
   (*m).x =  (a.x + b.x) / 2;
   (*m).y = (a.y + b.y) / 2;
   (*m).z = (a.z + b.z) / 2;
}

void distance(Point a, Point b, double* dist) {
    *dist = sqrt(pow(b.x - a.x, 2) + pow(b.y - a.y, 2) + pow(b.z - a.z, 2));
}
