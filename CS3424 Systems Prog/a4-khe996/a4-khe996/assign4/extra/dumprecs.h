#define BUF_SIZE 80
#define COURSE_SCHED_SIZE 4
#define DATA_DIR "."
#define DATA_FILE DATA_DIR"/courses.dat"

typedef struct {
    char name[BUF_SIZE];
    char schedule[COURSE_SCHED_SIZE];
    unsigned hours;
    unsigned size;
    unsigned padding;
} COURSE;

typedef enum { false=0, true } bool;

int dumpRecords(FILE * fileCourses);
void printRecord(COURSE * course, unsigned courseNum, unsigned iCourse, off_t lRBA);
