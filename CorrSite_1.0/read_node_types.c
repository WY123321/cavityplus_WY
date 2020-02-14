/*********************************************************
/                                                        /
/ source code copyright University of Pittsburgh,        /
/ released under the terms of the GPL, see license.txt   /
/                                                        /
/********************************************************/

void readnodetypes (char *nodesfile, char **nodetypes , int *nnodetypes , float  *halfcutoffs) {

/*************************************************************
//  
// Read the atom types defined as nodes and the half cut off associated
// woth each of them.
//
// Eran 11/2006
// 
//***********************************************************/

FILE *fp ;
int n = 0 ;
char atomtype[5] ;
char halfcutoff[6] ;
char buffer[30] ;
int i ;
fp = fopen(nodesfile , "r") ;
while (fgets(buffer, sizeof(buffer),fp)) {
	if (buffer[0] == '#') continue ;
	strncpy (atomtype , buffer , 4) ;      // fields 0-3
	atomtype[4] = '\0' ;
	strcpy (nodetypes[n],atomtype) ;
	strncpy (halfcutoff , buffer+4 , 5) ; // fields 4-8
	halfcutoff[5] = '\0' ;
	halfcutoffs[n] = atof(halfcutoff) ;
	
	n++ ;
	
}
fclose (fp) ;

// for (i=0 ; i< n ; i++) {
// 	printf ("*%s*%5.2f*\n" , nodetypes[i] , halfcutoffs[i]) ;
// }

*nnodetypes = n ;

}
