#include<stdio.h>
#include<stdlib.h>
#include"bst.h"

/*
   Function: create 
   -------------------
   This function creates a new BSTNode.
      v: the value to be addeded to the tree
   Returns: New node for a Binary Search Tree 
*/
BSTNode* create(int v)
{
    BSTNode* n = (BSTNode*)malloc(sizeof(BSTNode));
    n->value = v;
    n->left = NULL;
    n->right = NULL;
    return n;
}

/*
   Function: insert 
   -------------------
   This function inserts a new BSTNode.
      root: root of current subtree
      n: node to be inserted
   Returns: Root a Binary Search Tree 
*/
BSTNode* insert(BSTNode* root, BSTNode* n)
{
   if(root == NULL)
      return n;
   else if(n->value <= root->value)
      root->left = insert(root->left, n);
   else
      root->right = insert(root->right, n);
   return root;
}

/*
   Function: deleteBST 
   -------------------
   This function deallocates all the nodes in the BST
      root: root of the tree/subtree
   Returns: NULL
*/
BSTNode* deleteBST(BSTNode* root)
{
   if(root == NULL)
      return NULL;
   deleteBST(root->left);
   deleteBST(root->right);
   /* if we reach here, root is a leaf, so free it */
   free(root);
   return NULL;
}

/*
   Function: find 
   -------------------
   This function finds if a key value exists in a binary search tree.
      root: root of the tree/subtree
      key: key value we are looking for
   Returns: pointer to the node in which the value x was found
*/
BSTNode* find(BSTNode* root, int key)
{
	if(root == NULL || root->value == key)
      return root;
   else if(key < root->value)
      return find(root->left, key);
   else
      return find(root->right, key);
}

/*
   Function: removeNode 
   -------------------
   This function removes a node with a specific value in a binary search tree.
      root: root of the tree/subtree
      key: key value we are looking for that will be removed
   Returns: root of the tree/subtree
*/
BSTNode* removeNode(BSTNode* root, int key)
{
   if(root == NULL )
      return NULL;
	
	/* if key value is less than the current root's value, search to left */
   if(key < root->value)
      root->left = removeNode(root->left, key);
	/* if key value is greater than the current root's value, search to right */
   else if(key > root->value)
      root->right = removeNode(root->right, key);
   /* if the value was found */
   else if(root->value == key)
   {
      /* the following if statements check the current root's descendents. 
         there is a different set of actions depending. */
      if(root->left == NULL && root->right == NULL)
      {
         free(root);
         return NULL;
      }
      /* if either of left or right child is null
         return the one that exists. */
      else if(root->left == NULL || root->right == NULL)
      {
         BSTNode* tmp;
         if(root->left == NULL)
            tmp = root->right;
         else
            tmp = root->left;
         free(root);
         return tmp;
      }
      /* find the left most  child.
         Assign that value to the root (the node) to be removed.
         Remove the actual successor node. */
	 	else
	 	{
         BSTNode* tmp = root->right;
         while(tmp->left != NULL)
            tmp = tmp->left;
         root->value = tmp->value;
         root->right = removeNode(root->right, tmp->value);
	 	}
   }
   return root;
}
void traverseBST(BSTNode* root, enum BSTOrder e) {
    if (e == PREORDER) {
        if(root == NULL)
            return;
        printf("%d\t", root->value);
        traverseBST(root->left, e);
        traverseBST(root->right, e);
    }
    else if (e == INORDER) {
        if(root == NULL)
            return;
        traverseBST(root->left, e);
        printf("%d\t", root->value);
        traverseBST(root->right, e);
    }
    else if(e == POSTORDER) {
        if(root == NULL)
            return;
        traverseBST(root->left, e);
        traverseBST(root->right, e);
        printf("%d\t", root->value);
    }
}
