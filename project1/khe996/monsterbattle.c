#include <stdio.h>
#include "monsterbattle.h"

/*Randomize the rooms, monster stats, prize stat*/
int getRandomNumber(int min, int max) {
    int randomNum = (rand() % (max - min + 1)) + min;
    return randomNum;
}
/*Fills each room a prize, monster or nothing*/
void fillRooms(Room* rooms, int length) {
    int i;
    for(i = 0; i < length; ++i) {
        int num = getRandomNumber(0, 9);
        if (num == 0) {
            rooms[i].type = EMPTY;
        }
        if ((num > 0) && (num < 5)) {
            rooms[i].type = PRIZE;
            rooms[i].prize.points = getRandomNumber(5, 15);
        }
        if ((num >= 5) && (num < 10)) {
            rooms[i].type = MONSTER;
            rooms[i].monster.hitPoints = getRandomNumber(10, 30);
            if (rooms[i].monster.hitPoints % 3 == 0) {
                rooms[i].monster.experiencePoints = 3;
            }
            else {
                rooms[i].monster.experiencePoints = 1;
            }
        }
    }
}
/*Makes changes to player's health and XP based on which room was encountered */
void enterRoom(Room room, Character player, int *resultHP, int *resultXP) {
    if (room.type == EMPTY) {
        printf("The room is EMPTY.\n");
        *resultHP = 0;
        *resultXP = 0;
    }
    else if (room.type == PRIZE) {
        printf("This room has a PRIZE (PTS: %d).\n", room.prize.points);
        *resultHP = room.prize.points;
    }
    else if (room.type == MONSTER) {
        printf("This room contains a MONSTER! (HP: %d, XP: %d).\n", room.monster.hitPoints, room.monster.experiencePoints        );
        if (room.monster.hitPoints >= player.experiencePoints) {
            *resultHP = player.experiencePoints - room.monster.hitPoints; 
        }
        *resultXP = room.monster.experiencePoints;
    }
}
/*Gives status of the players health and XP*/
void printCharacter(Character c) {
    printf("Player (HP: %d, XP: %d)\n", c.hitPoints, c.experiencePoints);

}
