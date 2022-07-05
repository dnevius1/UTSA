#include<stdio.h>
#include<stdlib.h>
#include<string.h>
#include"employee.h"

Employee* readData(char fileName[], int* size) {
    FILE* fileIn = NULL;
    int inputCount;
    fileIn = fopen(fileName, "r");
    if (fileIn == NULL) {
        return NULL;
    }
    int n = 0;
    char buffer[500];
    while(fgets(buffer, 500, fileIn) != NULL) {
        n++;
    }
    *size = n;
    Employee* array;
    array = (Employee*)malloc(n * sizeof(Employee));
    rewind(fileIn);
    int i = 0;
    while(fgets(buffer, 500, fileIn) != NULL && i < n) {
        inputCount = sscanf(buffer, "%s %d %lf", array[i].name, &(array[i].id), &(array[i].salary)); 
        //printf("%s\t %d\t%lf\n", array[i].name, array[i].id, array[i].salary);
        i++;
    }
    if (inputCount != 3) {
        exit(1);
    }
    fclose(fileIn);
    return array;
}
Employee getBestEmployee(Employee array[], int size) {
    int i;
    double highestSalary = array[0].salary;
    Employee bestEmployee = array[0];
    for (i = 0; i < size; ++i) {
        if (array[i].salary > highestSalary) {
            highestSalary = array[i].salary;
            bestEmployee = array[i];
        }
    }
    return bestEmployee;
}
void writeData(char fileOutName[], Employee bestEmployee) {
    FILE* fileOut = NULL;
    fileOut = fopen(fileOutName, "w");
    fprintf(fileOut, "%s %d %.0lf", bestEmployee.name, bestEmployee.id, bestEmployee.salary);
    fclose(fileOut);
}
