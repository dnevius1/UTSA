//Author:               Daniel Nevius
//Assignment Number:    Lab 1
//File Name:            fibonacci.c
//Course/Section:       CS 2124 Section 0DA
//Date:                 9/13/2021
//Instructor:           Dr. Ku

/*This program will take in a positive integer and compute the Fibonacci sequence up to that number recursively and
iteratively.*/

#include <stdio.h>
#include <time.h>

int FibRecursive(int);
int FibIterative(int);

//Takes in user input n and computes the Fibonacci sequence up to that number using recursion
int FibRecursive(int n) {
    if (n < 2) {
        return n;
    }
    else {
        return FibRecursive(n-1)+FibRecursive(n-2);
    }
}

//Takes in user input n and computes the Fibonacci sequence up to that number using iteration
int FibIterative(int n) {
    int i;
    int j = 1;
    int k = 0;
    int sum;
    for (i = 0; i < n-1; i++) {
        sum = k + j;
        k = j;
        j = sum;
    }
    return sum;
}

int main() {
    int n;       //Holds user input
    int fr;      //Result of recursive Fibonacci function
    int fi;      //Result of iterative Fibonacci function
    printf("Enter a number to compute the Fibonacci of that number: ");
    scanf("%d", &n);
    clock_t t;
    t = clock();
    fr = FibRecursive(n);
    t = clock() - t;
    double time_taken = ((double)t) / CLOCKS_PER_SEC;
    printf("The recursive Fibonacci of %d is %d.\n", n, fr);
    printf("FibRecursive() took %.12f seconds to execute \n", time_taken);
    t = clock();
    fi = FibIterative(n);
    t = clock() - t;
    time_taken = ((double)t) / CLOCKS_PER_SEC;
    printf("The iterative Fibonacci of %d is %d.\n", n, fi);
    printf("FibIterative() took %.12f seconds to execute \n\n", time_taken);
    return 0;
}
