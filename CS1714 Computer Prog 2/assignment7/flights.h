#ifndef FLIGHTS_H
#define PRODUCTS_H

#define NUM_FLIGHTS 200

typedef struct Flight {
 char origin[4];
 char destination[4];
 char airline[3];
 int passengers;
} Flight;
#endif
