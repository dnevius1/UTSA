#include<stdio.h>
#include<stdlib.h>
#include<time.h>
#include<string.h>
#include"cards.h"

int main(int argc, char* argv[]) {
    Card* head = NULL;
    Card* add = NULL;
    Card* player1 = NULL;
    Card* player2 = NULL;
    int roundNum = 1;
    int userNum;
    int p1Length;
    int p2Length;
    srand(time(0));
    //Checking if user entered number of cards to play.
    if (argc != 2) {
        printf("ERROR: NO COMMAND LINE ARGUMENT\n");
        return 1;
    }
    userNum = atoi(argv[1]);
    if (userNum <= 0) {
        printf("ERROR: REQUIRES NUMBER GREATER THAN ZERO\n");
        return 1;
    }
    //Building the decks of cards.
    player1 = buildCards(userNum);
    player2 = buildCards(userNum);
    printf("=============PLAYER 1 V PLAYER 2 SHOWDOWN============\n");
    printf("Start size: %d cards\n", userNum);
    printf("Player 1 starting cards: ");
    printCards(player1);
    printf("Player 2 starting cards: \n");
    printCards(player2);
    //Starting the game.
    while(getLength(player1) >= 1 && getLength(player2) >= 1) {
        printf("-----ROUND %d-----\n", roundNum);
        ++roundNum;
        p1Length = getLength(player1);
        p2Length = getLength(player2);
        printf("Player 1 (%d): ", p1Length);
        printCard(player1);
        printf("\n");
        printf("Player 2 (%d): ", p2Length);
        printCard(player2);
        printf("\n");
        //Deciding outcomes based on encounter possibilities.
        if (player1->c == ATTACK && player2->c == ATTACK) {
            printf("Both players ATTACK.\n");
            if(player1->val > player2->val) {
                player1 = removeCard(player1);
                player2 = removeCard(player2);
                player2 = removeCard(player2);
                add = createCard();
                player1 = addCard(player1, add);
                printf("Player 1 wins and gets a new card.\n");
                printf("Player 2 loses their next card into the abyss.\n");
            }
            else if (player1->val < player2->val) {
                player1 = removeCard(player1);
                player2 = removeCard(player2);
                player1 = removeCard(player1);
                add = createCard();
                player2 = addCard(player2, add);
                printf("Player 2 wins and gets a new card.\n");
                printf("Player 1 loses their next card into the abyss.\n");
            }
            else {
                player1 = removeCard(player1);
                player2 = removeCard(player2);
                printf("It's a draw. Nothing happens.\n");
            }
        }
        else if (player1->c == DEFEND && player2->c == DEFEND) {
            printf("Both players DEFEND.*YAWN*\n");
                player1 = removeCard(player1);
                player2 = removeCard(player2);
                printf("Nothing happens.\n");
            
        }
        else if (player1->c == RUN && player2->c == RUN) {
            printf("Both players RUN away.*BOO*\n");
                player1 = removeCard(player1);
                player2 = removeCard(player2);
                player1 = removeCard(player1);
                player2 = removeCard(player2);
                printf("both lose their next card into the abyss.\n");
        }
        else if (player1->c == ATTACK && player2->c == DEFEND) {
            printf("Player 1 ATTACKs and Player 2 DEFENDs.\n");
            if(player1->val > player2->val) {
                player1 = removeCard(player1);
                player2 = removeCard(player2);
                add = createCard();
                player1 = addCard(player1, add);
                printf("Player 1 wins and gets a new card.\n");
                printf("Nothing happens to Player 2.\n");
            }
            else if (player1->val < player2->val) {
                player1 = removeCard(player1);
                player2 = removeCard(player2);
                player1 = removeCard(player1);
                printf("Player 1 loses and Player 2 survives.\n");
                printf("Player 1 loses their next card into the abyss.\n");
            }
            else {
                player1 = removeCard(player1);
                player2 = removeCard(player2);
                player1 = removeCard(player1);
                printf("It's a tie. Player 1 loses their next card into the abyss.\n");
            }
        }
        else if (player1->c == DEFEND && player2->c == ATTACK) {
            printf("Player 2 ATTACKs and Player 1 DEFENDs.\n");
            if(player1->val > player2->val) {
                player1 = removeCard(player1);
                player2 = removeCard(player2);
                player2 = removeCard(player2);
                printf("Player 2 loses and Player 1 survives.\n");
                printf("Player 2 loses their next card into the abyss.\n");
            }
            else if (player1->val < player2->val) {
                player1 = removeCard(player1);
                player2 = removeCard(player2);
                add = createCard();
                player2 = addCard(player2, add);
                printf("Player 2 wins and gets a new card.\n");
                printf("Nothing happens to Player 1.\n");
            }
            else {
                player1 = removeCard(player1);
                player2 = removeCard(player2);
                player2 = removeCard(player2);
                printf("It's a tie. Player 2 loses their next card into the abyss.\n");
            }
        }
        else if (player1->c == ATTACK && player2->c == RUN) {
            printf("Player 1 ATTACKs and Player 2 RUNs.\n");
            player1 = removeCard(player1);
            player2 = removeCard(player2);
            player2 = removeCard(player2);
            printf("Player 2 loses their next card into the abyss.\n");
        }
        else if (player1->c == RUN && player2->c == ATTACK) {
            printf("Player 2 ATTACKs and Player 1 RUNs.\n");
            player1 = removeCard(player1);
            player2 = removeCard(player2);
            player1 = removeCard(player1);
            printf("Player 1 loses their next card into the abyss.\n");
        }
        else if (player1->c == DEFEND && player2->c == RUN) {
            printf("Player 1 DEFENDs and Player 2 RUNs.\n");
            player1 = removeCard(player1);
            player2 = removeCard(player2);
            add = createCard();
            player1 = addCard(player1, add);
            player2 = removeCard(player2);
            printf("Player 1 gets a new card.\nPlayer 2 loses their next card into the abyss.\n");
        }
        else if (player1->c == RUN && player2->c == DEFEND) {
            printf("Player 2 DEFENDs and Player 1 RUNs.\n");
            player1 = removeCard(player1);
            player2 = removeCard(player2);
            add = createCard();
            player2 = addCard(player2, add);
            player1 = removeCard(player1);
            printf("Player 2 gets a new card.\nPlayer 1 loses their next card into the abyss.\n");
        }
        printf("\n");
    }
    //The game has ended. Displaying the results and winner/loser.
    printf("============GAME OVER============\n");
    printf("Player 1 ending cards: ");
    printCards(player1);
    printf("\n");
    printf("Player 2 ending cards: ");
    printCards(player2);
    printf("\n\n");
    if (getLength(player1) < 1 && getLength(player2) >= 1) {
        printf("Player 1 ran out of cards. Player 2 wins.\nThe end.\n");
    }
    if (getLength(player1) >= 1 && getLength(player2) < 1) {
        printf("Player 2 ran out of cards. Player 1 wins.\nThe end.\n");
    }
    if (getLength(player1) < 1 && getLength(player2) < 1) {
        printf("Both players ran out of cards, so both players lose.\nThe end.\n");
    }
    player1 = destroyCards(player1);
    player2 = destroyCards(player2);
    return 0;
}
