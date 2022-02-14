//Author:               Daniel Nevius
//Assignment Number:    Lab 3
//File Name:            lab3a.c
//Course/Section:       CS 2124 Section 0DA
//Date:                 11/7/2021
//Instructor:           Dr. Ku

//This is the driver for a program that takes in a user's postfix expression 
//and calculates the answer. The functions are in stackar.c
#include <stdio.h>
#include "stackar.h"
#include <string.h>

main ( ) {
    //Variable definitions
    char userPostfix[50];
    int userChoice = 1;
    //Menu
    while (userChoice == 1) {
        printf("Press 1 to enter a postfix expression.\nPress 2 to Exit.\n");
        scanf("%d", &userChoice);
        getchar();
        //If user enters anything other than 1 the program will exit
        if (userChoice != 1) 
            return -1;
        printf("Enter postfix expression: ");
        //Storing the postfix expression entered by the user
        scanf("%[^\n]%*c", userPostfix);
        //Removing any spaces entered in the string
        removeSpaces(userPostfix);
        //Calling the evaluatePostfix function to calculate and print answer
        printf("Postfix expression:%s\nResult: %d\n", userPostfix, evaluatePostfix(userPostfix)); 
    }
    return 0;
}
