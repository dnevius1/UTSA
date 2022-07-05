#include<stdio.h>
#include<stdlib.h>
#include<string.h>
#include"student.h"

void sortStudents(Student s[], int n) {
    int i, j, sIdx;
    Student temp;
    for (i = 0; i < n - 1; i++) {
        sIdx = i;
        for (j = i + 1; j < n; j++) {
            if (s[j].id < s[sIdx].id) 
                sIdx = j;
        }
        temp.id = s[i].id;
        strcpy(temp.name, s[i].name);
        s[i].id = s[sIdx].id;
        strcpy(s[i].name,s[sIdx].name);
        s[sIdx].id = temp.id;
        strcpy(s[sIdx].name,temp.name);
    }
}
void print(Student s[], int n) {
    int i;
    for (i = 0; i < n; i++) {
        printf("(%d,%s) -> ", s[i].id, s[i].name);
    }
    printf("\n");
}
Student searchStudent(Student s[], int n, int key) {
    int low = 0;
    int high = n - 1;
    int mid;
    while (low <= high) {
    mid = (high + low) / 2; 
    if (s[mid].id < key)
        low = mid + 1;
    else if (s[mid].id > key)
        high = mid - 1;
    else 
        return s[mid];
    }
    return s[0];
}


