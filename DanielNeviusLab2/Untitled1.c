#include <stdio.h>

int bar(int n);

int main()
 {
     int n;
     n = bar(4);
printf("%d", n);
return 0;
 }

int bar(int n) {
    if( n <= 0 )
        return -1;
    else
      return (6 + bar(n-1) + bar(n-2));
}


