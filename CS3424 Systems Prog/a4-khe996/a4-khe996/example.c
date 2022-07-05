
#include <stdio.h>

/* random record description - could be anything */
struct rec
{
    int x,y,z;
};

/* writes and then reads 10 arbitrary records
   from the file "junk". */
int main()
{
    int i,j;
    FILE *f;
    struct rec r;

    /* create the file of 10 records */
    f=fopen("junk","w");
    if (!f)
        return 1;
    for (i=1;i<=10; i++)
    {
        r.x=i;
        r.y=i-1;
        r.z=i+10;
        fwrite(&r,sizeof(struct rec),1,f);
    }
    fclose(f);

    /* read the 10 records */
    f=fopen("junk","r");
    if (!f)
        return 1;
    for (i=1;i<=10; i++)
    {
        fread(&r,sizeof(struct rec),1,f);
        printf("%d %d %d\n",r.x, r.y, r.z);
    }
    fclose(f);
    printf("\n");

    /* use fseek to read the 10 records
       in reverse order */
    f=fopen("junk","r");
    if (!f)
        return 1;
    for (i=9; i>=0; i--)
    {
        fseek(f,sizeof(struct rec)*i,SEEK_SET);
        fread(&r,sizeof(struct rec),1,f);
        printf("%d\n",r.x);
    }
    fclose(f);
    printf("\n");

    /* use fseek to read every other record */
    f=fopen("junk","r");
    if (!f)
        return 1;
    fseek(f,0,SEEK_SET);
    for (i=0;i<5; i++)
    {
        fread(&r,sizeof(struct rec),1,f);
        printf("%d\n",r.x);
        fseek(f,sizeof(struct rec),SEEK_CUR);
    }
    fclose(f);
    printf("\n");

    /* use fseek to read 4th record,
       change it, and write it back */
    f=fopen("junk","r+");
    if (!f)
        return 1;
    fseek(f,sizeof(struct rec)*3,SEEK_SET);
    fread(&r,sizeof(struct rec),1,f);
    r.x=100;
    r.y=105;
    r.z=110;
    printf("%d %d %d", r.x, r.y, r.z);
    fseek(f,sizeof(struct rec)*3,SEEK_SET);
    fwrite(&r,sizeof(struct rec),1,f);
    fclose(f);
    printf("\n");

    /* read the 10 records to insure
       4th record was changed */
    f=fopen("junk","r");
    if (!f)
        return 1;
    for (i=1;i<=10; i++)
    {
        fread(&r,sizeof(struct rec),1,f);
        printf("%d\n",r.x);
    }
    fclose(f);
    return 0;
}
