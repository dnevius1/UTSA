#ifndef STUDENT_H
#define STUDENT_H

typedef struct Student {
    int id;
    char name[11];
} Student;

void sortStudents(Student[], int);
void print(Student[], int);
Student searchStudent(Student[], int, int);

#endif
