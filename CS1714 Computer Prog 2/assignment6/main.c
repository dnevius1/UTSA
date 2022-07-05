#include<stdio.h>
#include<stdlib.h>
#include<string.h>
#include"employee.h"

int main (int argc, char* argv[]) {
    
    
    char fileName[] = "a6-input.txt";
    int size = 0;
    Employee* array = NULL;
    array = readData(fileName, &size);
    if (array == NULL) {
        return 1;
    }
    //int i;
    //for (i = 0; i < size; ++i) {
      // printf("In main: %s\t%d\t%.2lf\n", array[i].name, array[i].id, array[i].salary);
   // }
    Employee bestEmployee = getBestEmployee(array, size);
    char fileOutName[] = "a6-output.txt";
    writeData(fileOutName, bestEmployee);
    free(array);
    return 0;
}
