#include<stdio.h>
#include<stdlib.h>
#include<string.h>
#include"student.h"

int main(int argc, char *argv[]) {
    int n = 0;
    Student match;
    int toSearch;
    FILE *fileIn = NULL;
    if (argc != 2) {
        printf("ERROR NO ARGS");
        return -1;
    }
    fileIn = fopen(argv[1], "r");
    if (fileIn == NULL) {
        printf("ERROR FILE NOT OPEN");
        return -1;
    }
    char buffer[50];
    while(fgets(buffer, 50, fileIn) != NULL) {
        n++;
    }
    rewind(fileIn);
    Student *s;
    s = (Student*)malloc(sizeof(Student) * n);
    int i = 0;
    while(fgets(buffer, 50, fileIn) != NULL) {
        sscanf(buffer, "%d,%s", &s[i].id, s[i].name);
        ++i;
    }
    fclose(fileIn);
    print(s, n);
    sortStudents(s, n);
    print(s, n);
    scanf("%d", &toSearch);
    match = searchStudent(s, n, toSearch);
    printf("(%d,%s)", match.id, match.name);
    free(s);
    return 0;
}
