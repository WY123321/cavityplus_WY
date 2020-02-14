

typedef struct  {
  int   model ;
  char  chain ;
  char  resname[4] ;
  char  atomname[5] ;
  char  alter ;
  int   pdbcoornum ;      // record number from PDB
  char  insertioncode ;
  float coor[3] ;
  float centroid[3] ;
  float bfac ;
  float occupancy ;
  int   numberofatoms ;
} node ;

 
typedef struct  { 
  char  file[50] ;
  int numnodes ;
  node *nodes ; 
} net ;

void readnodes (char *pdbfile , net *netobj , char chain , int inputmodel , char **nodetypes , int nnodetypes) ;

#include "readnodes.c"
