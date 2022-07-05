#include<stdio.h>
#include<stdlib.h>
#include"route-records.h"

int main(int argc, char *argv[]) {
    int userChoice = 0;
    enum SearchType st;
    //open file to read
    FILE* fileIn = NULL;
    if (argc != 2) {
        printf("ERROR: Missing file name");
        return 1;
    }
    printf("Opening data.csv...\n");
    fileIn = fopen(argv[1], "r");
    if (fileIn == NULL) {
        printf("ERROR: Could not open file");
    }
    RouteRecord* r = NULL;
    //calling creatRecords to allocate memory for array
    r = createRecords(fileIn);
   int n;
   //calling fillRecords to populate array without duplicates
    n = fillRecords(r, fileIn);
    fclose(fileIn);
    //user menu to search records
    while(userChoice != 5) {
        char keyOne[4];
        char keyTwo[4];
        const char *key1 = keyOne;
        const char *key2 = keyTwo;
        printMenu();
        scanf("%d", &userChoice);
        switch(userChoice) {
            case 1:
                printf("Enter origin: ");
                scanf("%s", keyOne);
                printf("Enter destination: ");
                scanf("%s", keyTwo);
                st = ROUTE;
                break;
            case 2:
                printf("Enter origin: ");
                scanf("%s", keyOne);
                st = ORIGIN;
                break;
            case 3:
                printf("Enter destination: ");
                scanf("%s", keyOne);
                st = DESTINATION;
                break;
            case 4:
                printf("Enter airline: ");
                scanf("%s", keyOne);
                st = AIRLINE;
                break;
            case 5:
                printf("Good-bye!\n");
                free(r);
                exit(0);
                break;
            default:
                printf("Invalid choice.\n");
        }
        searchRecords(r, n, key1, key2, st);
    }
    return 0;
}
