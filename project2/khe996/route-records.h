#include<stdio.h>
#ifndef ROUTE_RECORDS_H
#define ROUTE_RECORDS_H

enum SearchType {ROUTE, ORIGIN, DESTINATION, AIRLINE} SearchType;

typedef struct RouteRecord {
    char oCode[4];
    char dCode[4];
    char aCode[3];
    int pCount[7];

} RouteRecord;

RouteRecord* createRecords(FILE*);
int fillRecords(RouteRecord*, FILE*);
int findAirlineRoute(RouteRecord*, int, const char*, const char*, const char*, int);
void searchRecords(RouteRecord*, int, const char*, const char*, enum SearchType);
void printMenu();

#endif
