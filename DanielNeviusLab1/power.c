//Author:               Daniel Nevius
//Assignment Number:    Lab 1
//File Name:            power.c
//Course/Section:       CS 2124 Section 0DA
//Date:                 9/13/2021
//Instructor:           Dr. Ku

/*This program will take in a positive integer "base" and multiply it by itself "power" number of times
recursively and iteratively.*/

#include<stdio.h>
#include<time.h>

double RecPower(double a, int n);
double ItPower(double a, int n);

int main() {
    int power;
    double base;
    double itResult;
    double recResult;
    int quit = 0;
    char toQuit;
    while (quit != 1) {
        printf("Enter a number to compute the power of that number: \n");
        scanf("%lf", &base);
        printf("Enter the power: \n");
        scanf("%d", &power);
        clock_t t;
        t = clock();
        //Timed recursive function call
        recResult = RecPower(base, power);
        t = clock() - t;
        double time_taken = ((double)t) / CLOCKS_PER_SEC;
        printf("%f raised to the power %d is %f.\n", base, power, recResult);
        printf("RecPower() took %f seconds to execute \n\n", time_taken);
        t = clock();
        //Timed iterative function call
        itResult = ItPower(base, power);
        t = clock() - t;
        time_taken = ((double)t) / CLOCKS_PER_SEC;
        printf("%f raised to the power %d is %f.\n", base, power, itResult);
        printf("ItPower() took %f seconds to execute. \n", time_taken);
        printf("Enter 'q' for power and base to quit.\n");
        scanf("%c", &toQuit);
        if (toQuit == 'q')
            quit = 1;
    }
    return 0;
}
//Recursive function to compute a to the nth power
double RecPower(double a, int n) {
    if (n == 0){
        return 1;
    }
    else {
        if (n > 0)
            return a * RecPower(a, n - 1);
        if (n < 0)
            return 1/a * RecPower(a, n + 1);
    }
}
//Iterative function to compute a to the nth power
double ItPower(double a, int n) {
    int i = 0;
    int j = 0;
    double power = 1;
    double aa = a;
    if (n == 0) {
       return 1;
    }
    //If n is positive
    if (n > 0) {
        while (i < n) {
            power = power * a;
            i += 1;
        }
    }
    //If n is negative
    if (n < 0) {
        n = -1 * n;
        aa = 1 / aa;
        while (j < n) {
            power = power * aa;
            j += 1;
        }
    }
    return power;
}

