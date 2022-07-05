#include<stdio.h>
#include<stdlib.h>
#include<time.h>
#include"cards.h"
//Creates a new, randomized card.
Card* createCard() {
    Card* new =(Card*)malloc(sizeof(Card));
    int random;
    int chooseType = (rand() % (9 - 0 + 1)) + 0;
    if (chooseType >= 0 && chooseType <= 3) {
        random = (rand() % (5 - 1 + 1)) + 1;
        new->c = ATTACK;
        new->val = random;
    }
    if (chooseType >= 4 && chooseType <= 8) {
        random = (rand() % (8 - 3 + 1)) + 3;
        new->c = DEFEND;
        new->val = random;
    }
    if (chooseType == 9) {
        random = (rand() % (8 - 1 + 1)) + 3;
        new->c = RUN;
        new->val = random;
    }
    return new;
    
}
//Removes a card from a player's deck.
Card* removeCard(Card *head) {
    if (head != NULL) {
        Card *cur = head;
        head = head->next;
        free(cur);
    }
    return head;
}
//Adds a newely created card to a player's deck in decending order.
Card* addCard(Card *head, Card *c) {
    Card* cur = head;
    Card* prev = NULL;
    while(cur != NULL && cur->val >= c->val) {
        prev = cur;
        cur = cur->next;
    }
    if (prev == NULL) {
        c->next = cur;
        return c;
    }
    prev->next = c;
    c->next = cur;
    return head;
}
//Gets the length of a player's deck of cards.
int getLength(Card *head) {
    int n = 0;
    Card *t = head;
    while(t != NULL) {
        t = t->next;
        n++;
    }
    return n;
}
//Prints a single card.
void printCard(Card *head) {
    char t;
    if (head->c == ATTACK)
        t = 'A';
    if (head->c == DEFEND)
        t = 'D';
    if (head->c == RUN)
        t = 'R';
    printf("%c%d", t, head->val);
}
//Prints a player's entire deck of cards.
void printCards(Card *head) {
    Card *p = head;
    char t;
    while(p != NULL) {
        if (p->c == ATTACK)
            t = 'A';
        if (p->c == DEFEND)
            t = 'D';
        if (p->c == RUN)
            t = 'R';
        printf("%c%d ", t, p->val);
        p = p->next;
    }
    printf("\n");
}
//Creates the user specified amount of cards and builds an ordered deck out of them.
Card* buildCards(int n) {
    int i;
    Card *head = NULL;
    Card *c = NULL;
    for (i = 0; i < n; ++i) {
       c = createCard();
       head = addCard(head, c);
    }
    return head;
}
//Frees the memory utilized by the deck of cards.
Card* destroyCards(Card *head) {
    while(head != NULL) {
        Card *t = head;
        head = head->next;
        free(t);
    }
}
