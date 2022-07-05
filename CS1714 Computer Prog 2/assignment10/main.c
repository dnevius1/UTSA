#include<stdio.h>
#include<stdlib.h>
#include<string.h>
#include"linkedlist.h"

int main(int argc, char *argv[]) {
    int id;
    char name[11];
    double gpa;
    double avg;
    LLNode* head = NULL;
    LLNode* new = NULL;
    FILE* fileIn = NULL;
    if (argc != 2) {
        printf("ERROR NO ARGS");
        return 1;
    }
    fileIn = fopen(argv[1], "r");
    if (fileIn == NULL) {
        printf("ERROR FILE NOT OPEN");
        return 1;
    }
    char buffer[50];
    while(fgets(buffer, 50, fileIn) != NULL) {
        sscanf(buffer, "%d,%[^,],%lf", &id, name, &gpa);
        new = createNode(id, name, gpa);
        head = insertNode(head, new);
    }
    fclose(fileIn);
    avg = averageGPA(head);
    printf("Average = %.2lf\n", avg);
    printLL(head);
    head = destroyLL(head);



return 0;
}
