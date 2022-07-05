#ifndef LINKEDLIST_H
#define LINKEDLIST_H

typedef struct LLNode {
    int id;
    char name[11];
    double gpa;
    struct LLNode* next;

} LLNode;

LLNode* createNode(int, char[], double);
LLNode* insertNode(LLNode*, LLNode*);
double averageGPA(LLNode*);
void printLL(LLNode*);
LLNode* destroyLL(LLNode*);

#endif
