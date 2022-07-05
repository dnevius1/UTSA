#include<stdio.h>
#include<stdlib.h>
#include"bst.h"

int main(int argc, char *argv[]) {
    BSTNode* root = NULL;
    BSTNode* new = NULL;
    //root = (root*)malloc(sizeof(root));
    enum BSTOrder e;
    int userNum;
    int i;
    int val;
    int orderNum;
    printf("Enter the number of nodes for the tree: ");
    scanf("%d", &userNum);
    for (i = 0; i < userNum; ++i) {
        printf("Enter a node value: ");
        scanf("%d", &val);
        new = create(val);
        root = insert(root, new);
    }
    printf("Enter the order for traversal and printing (0-Preorder, 1-Inorder, 2-Postorder): ");
    scanf("%d", &orderNum);
    if (orderNum == 0)
        e = PREORDER;
    if (orderNum == 1)
        e = INORDER;
    if (orderNum == 2)
        e = POSTORDER;
    traverseBST(root, e);
    deleteBST(root);
    return 0;
}
