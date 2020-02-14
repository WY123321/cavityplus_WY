/*********************************************************
/                                                        /
/ source code copyright University of Pittsburgh,        /
/ released under the terms of the GPL, see license.txt   /
/                                                        /
/********************************************************/

/****************************************************************************
//
// Get an pdb object and caculate Kirchhof matrix based on Ca
// information. 
// First residue is in index 1.
//
// Eran, 9/2005
//
****************************************************************************/

// #define THDIST 7.3 

float cal_sqr_ca_dist(net *netobj , int i, int j) ;

void generate_kirchhof (net *netobj , char chain  , float *kirchhof ,char **nodetypes , int nnodetypes , float  *halfcutoffs )  {

int total_number_of_nodes ;
int i,j ;
float distsqr , thdist ;
char file[50] ;
float thdistnode[100000] ;
FILE *fh ;	

strcpy(file , netobj->file) ;
total_number_of_nodes = netobj->numnodes ;

// A loop to get type and TH dist.

for (i=0 ; i<total_number_of_nodes ; i++) {
	for (j=0 ; j < nnodetypes ; j++)  {
		if (!strcmp(netobj->nodes[i].atomname , nodetypes[j])) {
			thdistnode[i] = halfcutoffs[j] ;
			break ;
		}
	}		
}			

fh =  fopen(strcat(file, ".sparsekirchhof") , "w") ;

for (i=0 ; i<total_number_of_nodes ; i++) {
	for (j=0 ; j<total_number_of_nodes ; j++) {
		if (i==j) continue ;
		thdist = thdistnode[i] + thdistnode[j] ;
		distsqr = cal_sqr_ca_dist(netobj,i,j) ;
		if (distsqr < thdist*thdist) {
			if (j>i)  {
				fprintf (fh , "%8d%8d% 25.15e\n" , i+1 , j+1 , -1.0 ) ;
			}
			kirchhof[i+1]++ ;
		}
	}
}

for (i=0 ; i<total_number_of_nodes ; i++) {
	fprintf (fh , "%8d%8d% 25.15e\n" , i+1   , i+1     , kirchhof[i+1]) ;
}

fclose (fh) ;

}
	
float cal_sqr_ca_dist(net *netobj , int i, int j) {
	return      ( (netobj->nodes[i].coor[0]-netobj->nodes[j].coor[0])*(netobj->nodes[i].coor[0]-netobj->nodes[j].coor[0]) +
	              (netobj->nodes[i].coor[1]-netobj->nodes[j].coor[1])*(netobj->nodes[i].coor[1]-netobj->nodes[j].coor[1]) +
		      (netobj->nodes[i].coor[2]-netobj->nodes[j].coor[2])*(netobj->nodes[i].coor[2]-netobj->nodes[j].coor[2]) ) ;
}
		
