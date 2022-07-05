/*
 * Sam Silvestro
 * CS 3424, Spring 2022
 * Version 1.0.2
 *
 * Warning: this version performs binary seeks by number rather than 
 *          record index. Thus, a course number input of 101 would
 *          be written to offset (101 * sizeof(COURSE))
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <sys/stat.h>
#include <sys/types.h>
#include "dumprecs.h"

static bool bIsSizeValid = false;
static bool bIsHoursValid = false;

int main(int argc, char ** argv) {

    char * filename = argv[1];
    int iCourses;
    int opt;
    FILE * fData;


    if(argc < 2) {
        fprintf(stderr, "Usage: %s <courses.dat> [-s|-h]\n", argv[0]);
        return EXIT_FAILURE;
    }

    while((opt = getopt(argc, argv, "sh")) != -1) {
        switch(opt) {
            case 's':
                bIsSizeValid = true;
                break;
            case 'h':
                bIsHoursValid = true;
                break;
        }
    }

	if(!bIsSizeValid && !bIsHoursValid) {
		bIsHoursValid = true;
	}

    // Open the courses file
    if((fData = fopen(filename, "rb+")) == NULL) {
        perror("unable to open file");
        return EXIT_FAILURE;
    }

    if((iCourses = dumpRecords(fData)) == -1) {
        fprintf(stderr, "an error occurred while reading courses, quitting...\n");
        fclose(fData);
        return EXIT_FAILURE;
    }

    printf("%d total courses found\n", iCourses);

    fclose(fData);

    return EXIT_SUCCESS;
}

int dumpRecords(FILE * fileCourses) {

    char strInput[BUF_SIZE];
    unsigned iCourseHours;
    unsigned iCourseNum = 0;
    unsigned iCourseSize;
    unsigned iCourses = 0;
    long pos;
    long lLastByte;
    size_t courseRecSz = sizeof(COURSE);
    size_t readRecs;

    COURSE read_course;


    if(fseek(fileCourses, 0, SEEK_END) == -1) {
        return -1;
    }
    lLastByte = ftell(fileCourses);
    if(fseek(fileCourses, 0, SEEK_SET) == -1) {
        return -1;
    }

    for(pos = 0; pos < lLastByte; pos += courseRecSz, iCourseNum++) {
        // Check to see if we've reached the end of the file
        if(fread(&read_course, courseRecSz, 1L, fileCourses) == 0) {
            // ...if so, return now with number of records found
            return iCourses;
        }
		if((bIsHoursValid && read_course.hours > 0) ||
				(bIsSizeValid && read_course.size > 0)) {
            printRecord(&read_course, iCourseNum, iCourses, pos);
            iCourses++;
        }
    }

    return iCourses;
}

void printRecord(COURSE * course, unsigned courseNum, unsigned iCourse, off_t lRBA) {
    if(course == NULL) {
        return;
    }

    printf("%3d: offset = %ld (%lx)\n", iCourse, lRBA, lRBA);
    printf("   Course number: %d\n", courseNum);
    printf("   Course name: %s\n", course->name);
    printf("   Scheduled days: %s\n", course->schedule);
    printf("   Credit hours: %u\n", course->hours);
    printf("   Enrolled students: %u\n\n", course->size);
}
