#include<stdio.h>
#include<stdlib.h>
#include"flights.h"

int main(int argc, char* argv[]) {
    if (argc != 2) {
        printf("ERROR NO ARGS");
        return 1;
    }
    
    FILE* fIn = NULL;
    fIn = fopen(argv[1], "r");
    if (fIn == NULL) {
        printf("ERROR FILE NOT OPEN");
        return 1;
    }
    
    Flight* f;
    int i = 0;
    char buffer[1000];
    f = (Flight*)malloc((sizeof(Flight) * NUM_FLIGHTS));
    while(fgets(buffer, NUM_FLIGHTS, fIn) != NULL) {
        sscanf(buffer, "%[^,], %[^,], %[^,], %d", f[i].origin, f[i].destination, f[i].airline,
        &(f[i].passengers));
        //printf("%s %s %s %d\n", f[i].origin, f[i].destination, f[i].airline, f[i].passengers);
        ++i;
    }
    char usrIn[3];
    scanf("%s", usrIn);
    int count = 0;
    int sum = 0;
    int j;
    for (j = 0; j < NUM_FLIGHTS; ++j) {
        if (strcmp(f[j].airline, usrIn) == 0) {
            sum += f[j].passengers;
            ++count;
        }
    }
    printf("airline: %s\nflights: %d\npassengers: %d", usrIn, count, sum);

    free(f);
    fclose(fIn);
    
    return 0;
}
