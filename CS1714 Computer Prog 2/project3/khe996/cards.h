#ifndef CARDS_H
#define CARDS_H

typedef enum CardType {ATTACK, DEFEND, RUN} CardType;

typedef struct Card {
    int val;
    enum CardType c;
    struct Card* next;
} Card;

Card* createCard();
Card* removeCard(Card*);
Card* addCard(Card*,Card*);
int getLength(Card*);
void printCard(Card*);
void printCards(Card*);
Card* buildCards(int);
Card* destroyCards(Card*);

#endif
