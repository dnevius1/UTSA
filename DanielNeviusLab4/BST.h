/*
Author:Daniel Nevius
Assignment Number: Lab Assignment 4
File Name: BST.h
Course/Section: CS 2123 Section 0D1
Due Date:12/06/2021
Instructor: Dr. Ku
*/
#ifndef _BST_H
#define _BST_H

//structure for the tree nodes
typedef struct nodeT{
    struct nodeT *pLeft, *pRight;
    int value;
}nodeT;

//prototypes
nodeT* insert(nodeT *p, int x);
nodeT* newNodeT(int x);
void printTree(nodeT *p, int space);
void printInOrder(nodeT *p);
void printPreOrder(nodeT *p);
void printPostOrder(nodeT *p);
void report(nodeT *p);
int getHeight(nodeT *p);
int getNumberOfNodes(nodeT *p);
int getNumberOfLeaves(nodeT *p);
nodeT* deleteNode(nodeT *pRoot, int value);
nodeT *minValueNode(nodeT *p);
nodeT* build(int left, int mid, int right);

#endif
