#ifndef POINT_H
#define POINT_H

typedef struct Point_struct {
double x;
double y;
double z;
} Point;

void midpoint(Point, Point, Point*);
void distance(Point, Point, double*);

#endif
