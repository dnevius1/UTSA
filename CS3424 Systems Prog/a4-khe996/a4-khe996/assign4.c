
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <sys/stat.h>
#include <sys/types.h>
#include "assign4.h"

static bool bIsSizeValid = false;
static bool bIsHoursValid = false;

int main(int argc, char ** argv) {
    char* filename=argv[1];
    FILE* f;
    int courseNumber;
    long lLastByte;
    size_t courseSz=sizeof(COURSE);
    if((f=fopen(filename, "rb+"))==NULL) {
        perror("unable to open file");
    }
    if(argc<2) {
        fprintf(stderr, "Usage: %s <courses.dat> [-s|-h]\n", argv[0]);
        return EXIT_FAILURE;
            }
    fseek(f,0,SEEK_END);
    lLastByte=ftell(f);
    fseek(f,0,SEEK_SET);
    //createRecord(f);
    //readRecord(f,lLastByte);
    COURSE c;
    fread(&c, sizeof(COURSE), 1, f);
    printRecord(&c);
    fclose(f);
}

/*void createRecord(FILE* f) {
    
}*/

/*void readRecord(FILE* f, long lLastByte) {
    COURSE c;
    //printf("%lu", sizeof(COURSE));
    int i;
    //for(i=0;i<lLastByte;i++) {
        fread(&c,sizeof(COURSE),1,f);
        printf("Course name: %s\n", c.course_Name);
    //}  
}*/

void printRecord(COURSE* c) {
    if(c==NULL) {
        return;
        }
        
        printf("    Course name: %s\n", c->course_Name);
        printf("    Scheduled days: %s\n", c->course_Sched);
        printf("    Credit hours: %u\n", c->course_Hours);
        printf("    Enrolled students: %u\n\n", c->course_Size);     
}

