/*
Author: Daniel Nevius
Assignment Number: Lab Assignment 4
File Name: driver.c
Course/Section: CS 2123 Section 0D1
Due Date:12/06/2021
Instructor: Dr. Ku
*/

#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include "BST.h"



/*
 *
 */
int main(int argc, char** argv) {
    nodeT *pRoot = NULL;        //root
    int data;                   //holds the int data
   report(pRoot);
    //Insertion of new items, reports when done
    printf("Items to insert (-999 to stop): ");
    scanf("%d", &data);
    while(data != -999){
        pRoot = insert(pRoot, data);
        printf("The height is %d\n", getHeight(pRoot));
        printf("The number of nodes is %d\n", getNumberOfNodes(pRoot));
        printf("The number of leaves is %d\n", getNumberOfLeaves(pRoot));
        printf("Items to insert (-999 to stop): ");
        scanf("%d", &data);
    }
    report(pRoot);
    //deletion of items, reports after each deletion
    printf("Items to delete (-999 to stop): ");
    scanf("%d", &data);
    while(data != -999){
        pRoot = deleteNode(pRoot, data);
        report(pRoot);
        printf("Items to delete (-999 to stop): ");
        scanf("%d", &data);
    }
    return 0;
}




