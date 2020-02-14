/*********************************************************
/                                                        /
/ source code copyright University of Pittsburgh,        /
/ released under the terms of the GPL, see license.txt   /
/                                                        /
/********************************************************/

#include <stdio.h>
#include <math.h>
#include <string.h>
#include <stdlib.h>
#include <time.h>

#include "check_modified_aa.c"
#include "svd.c"

#include "read_node_types.c"
#include "pdbnodes.h"
#include "generate_econo_kirchhof_from_nodes.c"

int main (int argc , char *argv[])   {

void print_indexing(net *netobj , double mean , double std) ;
void print_log_file(char *file , char chain , int number_of_nodes) ; 
void calculate_bfac_stat(net *netobj , char chain , double *mean , double *std) ;


float **v ;
float *d ;
float *kirmat ;
int nrot ;
int num_of_nodes ;
int n,m ;
net *netobj ;
char **nodetypes ;
int nnodetypes ;
float halfcutoffs[10] ;
int model ;

double mean, std ;

nodetypes = malloc (10*sizeof(char *));
for (n = 0 ; n<10 ; n++) {
	nodetypes[n] = malloc (10*sizeof(char));
}
netobj = malloc (sizeof(net));
model = atoi(argv[3]) ;
readnodetypes ("nodes.txt", nodetypes , &nnodetypes  , halfcutoffs) ;

readnodes(argv[1] , netobj , argv[2][0] , model , nodetypes , nnodetypes) ;   // argv[1]: pdb file , argv[2][0] : chain , 
num_of_nodes = netobj->numnodes   ;

kirmat = malloc ((num_of_nodes+1)*sizeof(float)) ;
for (m=1 ; m<=num_of_nodes ; m++)  {
	kirmat[m] = 0.0 ;
}

calculate_bfac_stat(netobj , argv[2][0] , &mean , &std) ;

print_indexing(netobj , mean , std) ;
print_log_file(argv[1] , argv[2][0] , num_of_nodes) ;

generate_kirchhof(netobj , argv[2][0] , kirmat , nodetypes , nnodetypes  , halfcutoffs) ;

}



void print_indexing(net *netobj , double mean , double std)  {
int i ;
int num_of_nodes ;
FILE *fh ;	
char file[50] ;

strcpy(file , netobj->file) ;
	
num_of_nodes = netobj->numnodes ;

fh =  fopen(strcat(file, ".index") , "w") ;

for (i=0 ;  i<num_of_nodes ; i++)  {
	fprintf (fh , "%5d %3s %4s %5d%c %c %3d %8.3f %8.3f %8.3f %9.3f %9.3f\n" , i+1 , netobj->nodes[i].resname , netobj->nodes[i].atomname , netobj->nodes[i].pdbcoornum , 
	                  netobj->nodes[i].insertioncode , netobj->nodes[i].chain , netobj->nodes[i].model , 
			  netobj->nodes[i].coor[0] , netobj->nodes[i].coor[1] , netobj->nodes[i].coor[2] ,
			  netobj->nodes[i].bfac , (netobj->nodes[i].bfac-mean)/std ) ; 
}

fclose (fh) ;

}

void print_log_file(char *file , char chain , int number_of_nodes) {

time_t t ;
FILE *fh ;	
char tmpfile[50] ;
char *ts ;

strcpy(tmpfile , file) ;

fh =  fopen(strcat(file, ".log") , "w") ;
t = time(NULL) ;
ts = ctime(&t) ;

fprintf (fh , "%s" , ts) ;
fprintf (fh , "file: %s chain: %c\n" , tmpfile , chain ) ;
fprintf (fh , "nodes: %d\n" , number_of_nodes ) ;

fclose (fh) ;

}


void calculate_bfac_stat(net *netobj , char chain , double *mean , double *std) {

/*************************************************************************************************
//
// Calculate Mean and STD to the B-factor values of the CA atoms
//
//
// Eran (10/2005)
//
*************************************************************************************************/

int i ;
int num_of_nodes ;
int num_of_nodes_counted=0 ;
double sum_sqdev=0.0 ;

*mean=0.0 ;

num_of_nodes = netobj->numnodes ;
for (i=0 ; i<num_of_nodes ; i++)  {
	if (((chain == netobj->nodes[i].chain) || (chain == '*')) && (netobj->nodes[i].bfac  != -9999))  {
		*mean += netobj->nodes[i].bfac ;
		num_of_nodes_counted++ ;
	}
}
*mean /= num_of_nodes ;

for (i=0 ; i<num_of_nodes ; i++)  {
	if (((chain == netobj->nodes[i].chain) || (chain == '*')) && (netobj->nodes[i]. bfac  != -9999))  {
		sum_sqdev += (netobj->nodes[i].bfac-(*mean))*(netobj->nodes[i].bfac-(*mean)) ;
	}
}

*std = sqrt(sum_sqdev/num_of_nodes_counted) ;

}








