#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include "monsterbattle.h"

int main(int argc, char* argv[]) {
    Character player;
    Character monster;
    Room* rooms= NULL;
    int userNum;
    int resultHP;
    int resultXP;
    int i;

    srand(time(0));
    player.hitPoints = 50;
    player.experiencePoints = 0;
    printf("Welcome to the MONSTER BATTLE rooms v.1\n");
    printf("Enter the number of rooms you want to endure: ");
    scanf("%d", &userNum);     //Acquiring number of rooms from user                                              
    rooms = (Room*)malloc(sizeof(Room) * userNum);
    printf("You have chosen to endure %d rooms. Let the game begin.\n", userNum);
    fillRooms(rooms, userNum); //Populating the rooms
    printCharacter(player);

    /*Traversing the rooms*/
    for(i = 0; i < userNum; ++i) {
        printf("-----ROOM %d of %d-----\n", i + 1, userNum);
        enterRoom(rooms[i], player, &resultHP, &resultXP);
        if (rooms[i].type == EMPTY) {
            printf("You lost %d hitpoints while in this room.\n", resultHP);
        }
        if (rooms[i].type == PRIZE) {
            printf("You gained %d hitpoints while in this room.\n", resultHP);
            player.hitPoints += resultHP;
        }
        if(rooms[i].type == MONSTER) {
            printf("You lost %d hitpoints while in this room.\n", abs(resultHP));
            printf("You gained %d experience while in this room.\n", resultXP);
            player.hitPoints += resultHP;
            player.experiencePoints += resultXP;
            if (player.hitPoints < 0) {
                player.hitPoints = 0;
                printCharacter(player);
                printf("\n");
                break;
            }
        }
        printCharacter(player);
        printf("\n\n");
    }
    /*Printing result*/
    if (player.hitPoints == 0) {
        printf("You did not survive the monster battle! GAME OVER!\n");
    }
    else {
        printf("You have survived the monster battle! CONGRATULATIONS!\n");
    }
    return 0;
}
