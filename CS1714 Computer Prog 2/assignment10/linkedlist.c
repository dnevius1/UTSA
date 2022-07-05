#include<stdio.h>
#include<stdlib.h>
#include<string.h>
#include"linkedlist.h"

LLNode* createNode(int newId, char newName[], double newGpa) {
    LLNode* p = (LLNode*)malloc(sizeof(LLNode));
    p->id = newId;
    strcpy(p->name, newName);
    p->gpa = newGpa;
    p->next = NULL;
    return p;
}
LLNode* insertNode(LLNode* head, LLNode* new) {
    LLNode* cur = head;
    LLNode* prev = NULL;
    while(cur != NULL && strcmp(cur->name,new->name) <= 0){
        prev = cur;
        cur = cur->next;
    }
    if(prev == NULL) {
        new->next = cur;
        return new;
    }
    else {
        prev->next = new;
        new->next = cur;
    }
    return head;
}
double averageGPA(LLNode* head) {
    LLNode *t = head;
    double sum = 0;
    double avg = 0;
    int length = 0;
    while(t != NULL) {
        sum += t->gpa;
        t = t->next;
        length++;
    }
    avg = sum / length;
    return avg;
}
void printLL(LLNode* head) {
    LLNode *t = head;
    while(t != NULL) {
        printf("(%d,%s,%.2lf) -> ", t->id, t->name, t->gpa);
        t = t->next;
    }
}
LLNode* destroyLL(LLNode* head) {
    LLNode* t = head;
    if (head == NULL)
        return t;
    head = head->next;
    free(t);
    destroyLL(head);
}
