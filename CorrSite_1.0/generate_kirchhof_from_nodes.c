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

void generate_kirchhof (net *netobj , char chain  , float **kirchhof ,char **nodetypes , int nnodetypes , float  *halfcutoffs )  {

int total_number_of_nodes ;
int i,j ;
float dist , thdist ;
float thdistnode[100000] ;

total_number_of_nodes = netobj->numnodes ;

for (i=0 ; i<total_number_of_nodes ; i++) kirchhof[i+1][i+1] = 0.0 ;

// A loop to get type and TH dist.

for (i=0 ; i<total_number_of_nodes ; i++) {
	for (j=0 ; j < nnodetypes ; j++)  {
		if (!strcmp(netobj->nodes[i].atomname , nodetypes[j])) {
			thdistnode[i] = halfcutoffs[j] ;
			break ;
		}
	}		
}			

for (i=0 ; i<total_number_of_nodes ; i++) {
	for (j=0 ; j<total_number_of_nodes ; j++) {
		if (i==j) continue ;
		thdist = thdistnode[i] + thdistnode[j] ;
		dist = cal_sqr_ca_dist(netobj,i,j) ;
		if (dist < thdist*thdist) {
			kirchhof[i+1][j+1] = -1.0 ;
			kirchhof[i+1][i+1] ++ ;
		}
		else {
			kirchhof[i+1][j+1] = 0.0  ;
		}	
	}
}

}
	
float cal_sqr_ca_dist(net *netobj , int i, int j) {
	return      ( (netobj->nodes[i].coor[0]-netobj->nodes[j].coor[0])*(netobj->nodes[i].coor[0]-netobj->nodes[j].coor[0]) +
	              (netobj->nodes[i].coor[1]-netobj->nodes[j].coor[1])*(netobj->nodes[i].coor[1]-netobj->nodes[j].coor[1]) +
		      (netobj->nodes[i].coor[2]-netobj->nodes[j].coor[2])*(netobj->nodes[i].coor[2]-netobj->nodes[j].coor[2]) ) ;
}
		
