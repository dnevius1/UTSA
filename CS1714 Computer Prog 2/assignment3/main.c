#include<stdio.h>
#include<stdlib.h>

int main(void) {

    int i;
    int size;
    double sum = 0.0;
    double avg;
    scanf("%d", &size);
    int* myData = NULL;
    myData = (int*)malloc(size * sizeof(int));
    if (myData == NULL) {
    return -1;
    }

    for (i = 0; i < size; ++i) {
    myData[i] = i;
    sum = sum + myData[i];
    }

    for ( i = 0; i < size; ++i) {
    printf("%d ", myData[i]);
    }

    printf("\n");
    avg = sum / size;
    printf("average: %0.2lf", avg);
    free(myData);


    return 0;
}

