#ifndef MONSTERBATTLE_H
#define MONSTERBATTLE_H

typedef enum TYPE {EMPTY, PRIZE, MONSTER} TYPE;

/*Struct definitions*/
typedef struct Character
{
    int hitPoints;
    int experiencePoints;
} Character;

typedef struct Prize
{
    int points;
} Prize;

typedef struct Room
{
    TYPE type;
    Character monster;
    Prize prize;
} Room;

/*Function prototypes*/
int getRandomNumber(int, int);
void fillRooms(Room*, int);
void enterRoom(Room, Character, int*, int*);
void printCharacter(Character);

#endif
