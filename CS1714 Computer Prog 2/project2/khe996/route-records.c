#include<stdio.h>
#include<stdlib.h>
#include<string.h>
#include"route-records.h"

RouteRecord* createRecords(FILE* fileIn) {
    RouteRecord* r;
    int n = 0;
    char buffer [500];
    while(fgets(buffer, 500, fileIn) != NULL) {
        n++;
    }
    r = (RouteRecord*)malloc((sizeof(RouteRecord) * n));
    int i;
    int j;
    for (i = 0; i < n; i++) {
        for(j = 0; j < 7; ++j) {
            r[i].pCount[j] = 0;
        }
    }
    rewind(fileIn);
    return r;
}
//Populates the array with file data
int fillRecords(RouteRecord* r, FILE* fileIn) {
    int n = 0;
    int length = 0;
    int month = 1;
    char pass[12];
    char buffer0[500];
    char buffer[500];
    fgets(buffer0, 500, fileIn);
    //Getting data from file, parsing data and calling recursive function. 
    //Result of recursion is sameAt. Adds the current index n's pCount to 
    //the index it found to be the same.
    while(fgets(buffer, 500, fileIn) != NULL) {
        int pCount;
        char orig[4];
        char dest[4];
        char air[3];
        sscanf(buffer, "%d,%[^,],%[^,],%[^,],%[^,],%d", &month, orig, dest, air, pass, &pCount);
        const char *origin = orig;
        const char *destination = dest;
        const char *airline = air;
        int curIdx = 0;
        int sameAt;
        sameAt = findAirlineRoute(r, n, origin, destination, airline, curIdx);
         if (sameAt != -1) {
            r[sameAt].pCount[month-1] += pCount;
         }
         else {
            strcpy(r[n].oCode, orig);
            strcpy(r[n].dCode, dest);
            strcpy(r[n].aCode, air);
            r[n].pCount[month-1] = pCount;
            n++;
            length++;
         }   
    }
    rewind(fileIn);
        printf("Unique routes operated by airlines: %d\n\n\n", length);
    return length;
}
//Recursive function called from fillRecords to see 
//if same origin/destination/airline already entered
//for the month. returns curIdx if found.
int findAirlineRoute(RouteRecord* r, int n, const char *origin, const char *destination, const char *airline, int curIdx) {
    if (curIdx == n) {
        return -1;
    }
    if ((strcmp(origin, r[curIdx].oCode) == 0) && (strcmp(destination, r[curIdx].dCode) == 0) && (strcmp(airline, r[curIdx].aCode) == 0)){
        return curIdx;
    }
    else {
        findAirlineRoute(r, n, origin, destination, airline, curIdx + 1);
    }
}
//Searches through RouteRecord array to find matches based 
//on how the user searched. Prints total passengers, passengers 
//per month, and average passengers per month.
void searchRecords(RouteRecord* r, int length, const char* key1, const char* key2, enum SearchType st) {
    int i;
    int count = 0;
    int m1 = 0, m2 = 0, m3 = 0, m4 = 0, m5 = 0, m6 = 0;
    int pTotal;
    double avg;
    switch(st) {
        case ROUTE:
            printf("Searching by route...\n");
            for (i = 0; i < length; ++i) {
                if ((strcmp(key1, r[i].oCode) == 0) && (strcmp(key2, r[i].dCode) == 0)) {
                    count++;
                    m1 += r[i].pCount[0];
                    m2 += r[i].pCount[1];
                    m3 += r[i].pCount[2];
                    m4 += r[i].pCount[3];
                    m5 += r[i].pCount[4];
                    m6 += r[i].pCount[5];
                    printf("%s(%s-%s)", r[i].aCode, r[i].oCode, r[i].dCode);
                }
            }
            break;
        case ORIGIN:
            for (i = 0; i < length; ++i) {
                if ((strcmp(key1, r[i].oCode) == 0)) {
                    count++;
                    m1 += r[i].pCount[0];
                    m2 += r[i].pCount[1];
                    m3 += r[i].pCount[2];
                    m4 += r[i].pCount[3];
                    m5 += r[i].pCount[4];
                    m6 += r[i].pCount[5];
                    printf("%s(%s-%s)", r[i].aCode, r[i].oCode, r[i].dCode);
                }
            }
            break;
        case DESTINATION:
            for (i = 0; i < length; ++i) {
                if ((strcmp(key1, r[i].dCode) == 0)) {
                   count++;
                   m1 += r[i].pCount[0];
                   m2 += r[i].pCount[1];
                   m3 += r[i].pCount[2];
                   m4 += r[i].pCount[3];
                   m5 += r[i].pCount[4];
                   m6 += r[i].pCount[5];
                   printf("%s(%s-%s)", r[i].aCode, r[i].oCode, r[i].dCode);
                }
            }
            break;
        case AIRLINE:
            for (i = 0; i < length; ++i) {
                if ((strcmp(key1, r[i].aCode) == 0)) {
                    count++;
                    m1 += r[i].pCount[0];
                    m2 += r[i].pCount[1];
                    m3 += r[i].pCount[2];
                    m4 += r[i].pCount[3];
                    m5 += r[i].pCount[4];
                    m6 += r[i].pCount[5];
                    printf("%s(%s-%s)", r[i].aCode, r[i].oCode, r[i].dCode);
                }
            }
            break;
    }
    pTotal = m1 + m2 + m3 + m4 + m5 + m6;
    avg = pTotal / 6;
    /*
    for (i = 0; i < n; ++i) {
       if strcmp(
    }*/

    printf("\n%d matches were found.\n\n", count);
    printf("Statistics\n");
    printf("Total passengers:\t%d\n", pTotal);
    printf("Total passengers in Month 1: %d\n", m1);
    printf("Total passengers in Month 2: %d\n", m2);
    printf("Total passengers in Month 3: %d\n", m3);
    printf("Total passengers in Month 4: %d\n", m4);
    printf("Total passengers in Month 5: %d\n", m5);
    printf("Total passengers in Month 6: %d\n\n", m6);
    printf("Average Passengers per Month: %.0lf\n\n", avg);
}

void printMenu() {
    printf( "\n\n######### Airline Route Records Database MENU #########\n");
    printf("1. Search by Route\n");
    printf("2. Search by Origin Airport\n");
    printf("3. Search by Destination Airport\n");
    printf("4. Search by Airline\n");
    printf("5. Quit\n");
    printf("Enter your selection: " );
}

