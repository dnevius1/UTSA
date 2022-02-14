//Author:               Daniel Nevius
//Assignment Number:    Lab 3
//File Name:            lab3b.c
//Course/Selection:     CS 2124 Section 0DA
//Date:                 11/7/2021
//Instructor:           Dr. Ku

/*This is the driver for a program that takes in Postfix.txt 
and calculates the answer for each postfix expresson read 
in the file. It can also take a single expression from user.
The functions are in stackar.c*/
#include <stdio.h>
#include "stackar.h"
#include <string.h>

main( )
{
    int i;
    int checkReturn;
    int lineCount = 0;
    int userChoice = 0;
    char buffer[50];
    char userPostfix[50];
    //User menu
    printf("1. Enter a single postfix expression.\n2. Pull expressions from Postfix.txt.\n3. Exit.\n");
    scanf("%d", &userChoice);
    getchar();
    //Exits if user chooses 3
    while (userChoice != 3) {
        //If user choice is 1, processes a single postfix expression from user
        if (userChoice == 1) {
            printf("Enter postfix expression: \n");
            //grabs user input
            fgets(userPostfix, 50, stdin);
            //Trimming any excess characters
            userPostfix[strlen(userPostfix)-1] = '\0';
            //Removes any spaces
            removeSpaces(userPostfix);
            //Checks in string is valid postfix expression
            checkReturn = checkInvalidChar(userPostfix);
            //If valid, processes and prints result
            if (checkReturn == 0) {
                printf("User's postfix expression %s = %d\n", userPostfix, 
                evaluatePostfix(userPostfix));
            }
        }
        else if (userChoice == 2) {
            //If user choice is 2. Processes postfix expressions from file Postfix.txt
            FILE* fp = fopen("Postfix.txt", "r");
            //Checks in the file is NULL
            if (!fp) {
                printf("File cannot be read");
                return -1;
            }
            //Tracking how many lines are in the file
            while (fgets(buffer, 50, fp) != NULL) {
                lineCount++;
            }
            rewind(fp);
            //Rewinding and reading file data to buffer one line at a time
            for (i = 0; i < lineCount; i++) {
                fgets(buffer, 50, fp);
                //Trimming excess characters
                if (i < lineCount - 1)
                    buffer[strlen(buffer)-2] = '\0';
                    //Removing spaces
                removeSpaces(buffer);
                //Checking for errors in string
                checkReturn = checkInvalidChar(buffer);
                //If no error, process and print
                if (checkReturn == 0) {
                    printf("Postfix expression: %s = %d\n", buffer, evaluatePostfix(buffer));
                }   
            }
            lineCount = 0;
            //Closing file when done
            fclose(fp);
        }
        //Program starts again with menu
        printf("1. Enter a single postfix expression.\n2. Pull expressions from Postfix.txt.\n3. Exit.\n");
        scanf("%d", &userChoice);
        getchar();
    }
    printf("\n"); 

    return 0;
}
