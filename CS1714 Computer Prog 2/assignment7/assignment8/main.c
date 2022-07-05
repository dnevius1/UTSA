#include <stdio.h>
#include <stdlib.h>
#include <string.h>

//Function that recursively prints passwords of a given length
void printAllKLength(char s[], int M, int k, char *curPass) {
    

    if (k == 0) {
        printf("%s\n",curPass);
        return;
    }
    //options to decide the value for the position after the curPass "a" -> "aa","ab","ac"
    int i;
    for(i = 0; i < M; i++) {
        int x = strlen(curPass) + 2;
        char *newPass = (char*)malloc(sizeof(char) * x);
        newPass[strlen(newPass) + 1] = '\0';
        //char *tmpString = (char*)malloc(sizeof(char) * x);
        //char tmpChar = *s[i];  //s[i]
        char tmpString[2] = "";
        //char *end = NULL;
        tmpString[0] = s[i];
        tmpString[1] = '\0';
        //strncat(tmpString, (s + i), 1);
        //strcat(tmpString, );
        strcat(curPass, tmpString);
        strcpy(newPass, curPass);
        //newPass = curPass + s[i]; // "cs 17" + 'a' = "cs 17" + "a\0" = "cs 17a"
        

        //recurse to do the exact same thing
        printAllKLength(s, M, k-1, newPass);
    }
}

//Deciding the length of the password - helper function
void printPasswords(int N, int M, char s[]) {
    int k = 1;
    for (k = 1; k <= N; k++) {
        printAllKLength(s, M, k, "");
    }

}

int main(int argc, char* argv[]) {
    int M = atoi(argv[1]);
    char *s = (char*)malloc(sizeof(char) * M);
    /* 3 a b c 2
    s[0] = 'a' -> argv[2] = "a\0"
    s[1] = 'b' -> argv[3] = "b\0"
    s[2] = 'c' -> argv[4] = "c\0"
    strcpy(s[i], argv[2+i];
    char x[10];
    x[j];
    char *argv[2];
    argv[2][j];
    */
    int i = 0;
    for(i = 0; i < M; i++)
        s[i] = argv[2+i][0];
    int N = atoi(argv[2+i]);
    printPasswords(N, M, s);


    return 0;


}







