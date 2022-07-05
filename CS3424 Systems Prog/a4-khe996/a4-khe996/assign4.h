#define BUF_SIZE 80
#define COURSE_SCHED_SIZE 4
#define DATA_DIR "."
#define DATA_FILE DATA_DIR"/courses.dat"

typedef struct COURSE {
    char course_Name[BUF_SIZE];
    char course_Sched[COURSE_SCHED_SIZE];
    unsigned course_Hours;
    unsigned course_Size;
    unsigned padding;
} COURSE;

typedef enum { false=0, true } bool;

//void readRecord(FILE* f, long lLastByte);
void printRecord(COURSE * c);
