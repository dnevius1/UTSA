        #include "stackar.h"
        #include "fatal.h"
        #include <stdlib.h>
        #include <stdio.h>
        #include <ctype.h>
        #include <string.h>
        #define EmptyTOS ( -1 )
        #define MinStackSize ( 3 )

        struct StackRecord
        {
            int Capacity;
            int TopOfStack;
            ElementType *Array;
        };
//Print error function
void printError(char* buffer) {
    printf("There is an invalid character in string: %s\n", buffer);
}
/*Checks buffer string for any invalid characters. If any errors are
encountered, generates an error and prevents processing.*/
int checkInvalidChar(char* buffer) {
    int i;
    int j;
    int flag = 0;
    int n = strlen(buffer);
    int digitCount = 0;
    /* Checks if characters at element 0 and 1 are digits. If they are
    not digits, generates an error and prevents processing*/
    if (isdigit(buffer[0]) == 0 || isdigit(buffer[1]) == 0) {
        printError(buffer);
        flag = 1;
    }
    //Prevents duplicate errors
    if (flag == 0) {
        for (i = 0; i < n; i++) {
            //Checks if digit is a positive integer between 0-9
            if (isdigit(buffer[i])) {
                ++digitCount;
                if (buffer[i] < '0' || buffer[i] > '9') {
                    printError(buffer);
                    flag = 1;
                    break;
                }    
            }
            /*Not sure why I wrote this one. Looking back, it's not
            necessary but I'm just gonna leave it*/
            else if (buffer[i] == '(') {
                j = i;
                flag = 1;
                while (buffer[j]) {
                    if (buffer[j] == ')') {
                        flag = 0;
                    }
                    ++j;
                }
                if (flag == 1)
                    printError(buffer);
                    break;
            }
            /*Checks if character is a valid non-digit character*/
            else if (buffer[i] != '+' && buffer[i] != '-' && 
                    buffer[i] != '*' && buffer[i] != '/') {
                        printError(buffer);
                        flag = 1;
                        break;
            }
            /*Checks if there are too many operators in the string*/
            else if (buffer[i] == '+' || buffer[i] == '-' || 
                    buffer[i] == '*' || buffer[i] == '/') {
                        --digitCount;
                        if (digitCount <= 0) {
                            printError(buffer);
                            flag = 1;
                            break;
                        }
            }
        }
    }
    return flag;
}
//Removes any spaces found in input string
void removeSpaces(char* buffer) {
    char* d = buffer;
    do {
        while (*d == ' ') {
            ++d;
        }
    } while (*buffer++ = *d++);
}

int evaluatePostfix(char* exp) {
    //Create a stack equal to the size of exp
    Stack S = CreateStack(strlen(exp));
    int i;
    //Check if the stack was successfully created
    if (!S) return -1;

    //Scan through each element in the array
    for (i = 0; exp[i]; ++i) {
        /*If the character at current element is
        an operand, push it to stack*/
        if (isdigit(exp[i]))
            Push(exp[i] - '0', S);
        /* If the character at current element is
        an operator, pop two elements from stack
        and calculate using operator*/
        else {
            ElementType val1 = Top(S);
            Pop(S);
            ElementType val2 = Top(S);
            Pop(S);
            switch (exp[i]) {
            case '+': Push(val2 + val1, S);
                break;
            case '-': Push(val2 - val1, S);
                break;
            case '*': Push(val2 * val1, S);
                break;
            case '/': Push(val2 / val1, S);
                break;
            }
        }
    }
    //Error if more than one element on stack
    if (S->TopOfStack > 0) {
        printf("Error: More numbers remain on stack\n");
        
    }
    return Top(S);
}

/* START: fig3_48.txt */
        int
        IsEmpty( Stack S )
        {
            return S->TopOfStack == EmptyTOS;
        }
/* END */

        int
        IsFull( Stack S )
        {
            return S->TopOfStack == S->Capacity - 1;
        }

/* START: fig3_46.txt */
        Stack
        CreateStack( int MaxElements )
        {
            Stack S;

/* 1*/      if( MaxElements < MinStackSize )
/* 2*/          Error( "Stack size is too small" );

/* 3*/      S = malloc( sizeof( struct StackRecord ) );
/* 4*/      if( S == NULL )
/* 5*/          FatalError( "Out of space!!!" );

/* 6*/      S->Array = malloc( sizeof( ElementType ) * MaxElements );
/* 7*/      if( S->Array == NULL )
/* 8*/          FatalError( "Out of space!!!" );
/* 9*/      S->Capacity = MaxElements;
/*10*/      MakeEmpty( S );

/*11*/      return S;
        }
/* END */

/* START: fig3_49.txt */
        void
        MakeEmpty( Stack S )
        {
            S->TopOfStack = EmptyTOS;
        }
/* END */

/* START: fig3_47.txt */
        void
        DisposeStack( Stack S )
        {
            if( S != NULL )
            {
                free( S->Array );
                free( S );
            }
        }
/* END */

/* START: fig3_50.txt */
        void
        Push( ElementType X, Stack S )
        {
            if( IsFull( S ) )
                Error( "Full stack" );
            else
                S->Array[ ++S->TopOfStack ] = X;
        }
/* END */


/* START: fig3_51.txt */
        ElementType
        Top( Stack S )
        {
            if( !IsEmpty( S ) )
                return S->Array[ S->TopOfStack ];
            Error( "Empty stack" );
            return 0;  /* Return value used to avoid warning */
        }
/* END */

/* START: fig3_52.txt */
        void
        Pop( Stack S )
        {
            if( IsEmpty( S ) )
                Error( "Empty stack" );
            else
                S->TopOfStack--;
        }
/* END */

/* START: fig3_53.txt */
        ElementType
        TopAndPop( Stack S )
        {
            if( !IsEmpty( S ) )
                return S->Array[ S->TopOfStack-- ];
            Error( "Empty stack" );
            return 0;  /* Return value used to avoid warning */
        }
/* END */
