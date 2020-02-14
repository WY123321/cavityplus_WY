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
#include "generate_kirchhof_from_nodes.c" 

int main (int argc , char *argv[])   {

void print_kirchhof(net *netobj , float **kirchhof) ;
void print_sparse_kirchhof(net *netobj , float **kirchhof) ;
void print_pseudoinverse(net *netobj , float **invkirmat) ;
void print_eigenvalues (net *netobj , float *d) ;
void print_eigenvectors (net *netobj , float *d , float **v) ;
void print_crosscorrelations(net *netobj , float **cc) ;
void print_modes(net *netobj , float **cc) ;
void print_indexing(net *netobj , double mean , double std) ;
void print_log_file(char *file , char chain , int number_of_nodes) ; 
void print_tc_as(net *netobj, float *d, float **v, float **invkirmat, float *tc_as);

void pseudoinverse(float d[], float **v, float **crc, int n) ;
void normalizedcc (float **invkir, float **cc, int n) ;
void normalizedtc_as (char *flie1, char *file2, float *d, float **v, float **invkir, float *tc_as, int n);
void calculatemodes (float **v, float **modes, int n) ;
void calculate_bfac_stat(net *netobj , char chain , double *mean , double *std) ;


float **v ;
float *d , *tc_as;
float **kirmat , **invkirmat , **cc ,  **modes ;
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

readnodes(argv[1] , netobj , argv[2][0] , model  , nodetypes , nnodetypes) ;   // argv[1]: pdb file , argv[2][0] : chain , argv[3]: allossubsindex file 
num_of_nodes = netobj->numnodes   ;

kirmat = malloc ((num_of_nodes+1)*sizeof(float *)) ;
invkirmat = malloc ((num_of_nodes+1)*sizeof(float *)) ;
cc = malloc ((num_of_nodes+1)*sizeof(float *)) ;
v = malloc ((num_of_nodes+1)*sizeof(float *)) ;
d = malloc ((num_of_nodes+1)*sizeof(float)) ;
modes = malloc ((num_of_nodes+1)*sizeof(float)) ;
tc_as = malloc ((num_of_nodes+1)*sizeof(float)) ;
for (n=1 ; n<=num_of_nodes ; n++)  {
        kirmat[n] = malloc ((num_of_nodes+1)*sizeof(float));
        invkirmat[n] = malloc ((num_of_nodes+1)*sizeof(float));
        cc[n] = malloc ((num_of_nodes+1)*sizeof(float));
        v[n]   = malloc ((num_of_nodes+1)*sizeof(float));
        modes[n]   = malloc ((num_of_nodes+1)*sizeof(float));
	for (m=1 ; m<=num_of_nodes ; m++)  {
		kirmat[n][m] = 0.0 ;
	}
}

generate_kirchhof(netobj , argv[2][0] , kirmat , nodetypes , nnodetypes  , halfcutoffs) ;



print_kirchhof(netobj , kirmat) ;
print_sparse_kirchhof(netobj , kirmat) ;
svdcmp(kirmat, num_of_nodes , num_of_nodes , d , v) ;

v = kirmat ; // the svdcmp function  assigns the orthogonal basis to the input pointer (kirmat)

eigsrt(d, v, num_of_nodes) ;
pseudoinverse(d, v, invkirmat , num_of_nodes) ;
normalizedcc (invkirmat, cc, num_of_nodes) ;
normalizedtc_as (argv[4], argv[5], d, v, invkirmat, tc_as, num_of_nodes);
calculate_bfac_stat(netobj , argv[2][0] , &mean , &std) ;

print_indexing(netobj , mean , std) ;
print_log_file(argv[1] , argv[2][0] , num_of_nodes) ;
print_eigenvalues (netobj , d)  ;
print_eigenvectors (netobj , d , v) ;
print_pseudoinverse (netobj , invkirmat) ;
print_crosscorrelations (netobj , cc) ;
print_tc_as(netobj, d, v, invkirmat, tc_as);

}


void print_eigenvalues (net *netobj , float *d)  {
	int n ;
	int num_of_nodes ;
	FILE *fh ;	

	char file[50] ;
	
	num_of_nodes = netobj->numnodes ;
	
	strcpy(file , netobj->file) ;
	fh =  fopen(strcat(file, ".eigenvalues") , "w") ;
	for (n=1 ;  n<=num_of_nodes ; n++)  {
		fprintf (fh , "%10.5f\n" , d[n]) ;
	}
	fclose (fh) ;
}

void print_tc_as(net *netobj, float *d, float **v, float **invkirmat, float *tc_as) {
    int n ;
    int num_of_nodes ;
    FILE *fh ;

    char file[50] ;
    num_of_nodes = netobj->numnodes ;

    strcpy(file, netobj->file);
    fh = fopen(strcat(file, ".tc_as") , "w");
    for (n=1 ;  n<=num_of_nodes ; n++) {
        fprintf (fh, "%10.5f\n", tc_as[n]) ;
    }
    fclose (fh) ;
}
void print_eigenvectors (net *netobj , float *d , float **v)  {
	int m,n ;
	int num_of_nodes ;
	FILE *fh ;
	char file[50] ;
	int filenamelength ;
	
	num_of_nodes = netobj->numnodes ;
	
	strcpy(file , netobj->file) ;
	filenamelength = strlen(file) ;
	
	fh =  fopen(strcat(file, ".eigenvectors") , "w") ;
	for (n=1 ;  n<=num_of_nodes ; n++)  {
		for (m=1 ;  m<=num_of_nodes ; m++)  {
			fprintf (fh , "%10.5f " , v[n][m]) ;
		}
		fprintf (fh , "\n") ;
	}
	fclose (fh) ;
}

void print_kirchhof(net *netobj , float **kirchhof)  {
int m,n ;
int num_of_nodes ;
FILE *fh ;	
char file[50] ;

strcpy(file , netobj->file) ;
	
num_of_nodes = netobj->numnodes ;

fh =  fopen(strcat(file, ".kirchhof") , "w") ;

for (n=1 ;  n<=num_of_nodes ; n++)  {
	for (m=1 ;  m<=num_of_nodes ; m++)  {
		fprintf (fh , "%10.5f " , kirchhof[n][m]) ;
	
	}
	fprintf (fh ,"\n") ;
}

fclose (fh) ;

}

void print_sparse_kirchhof(net *netobj , float **kirchhof)  {
int m,n ;
int num_of_nodes ;
FILE *fh ;	
char file[50] ;

strcpy(file , netobj->file) ;
	
num_of_nodes = netobj->numnodes ;

fh =  fopen(strcat(file, ".sparsekirchhof") , "w") ;

for (n=1 ;  n<=num_of_nodes ; n++)  {
	for (m=n ;  m<num_of_nodes ; m++)  {
		if (kirchhof[n][m] != 0.0)  {
			fprintf (fh , "%8d%8d% 25.15e\n" , n , m , kirchhof[n][m]) ;
		}
	}
}

fclose (fh) ;

}

void print_pseudoinverse(net *netobj , float **invkirmat)  {
int m,n ;
int num_of_nodes ;
FILE *fh ;	
char file[50] ;

strcpy(file , netobj->file) ;
	
num_of_nodes = netobj->numnodes ;

fh =  fopen(strcat(file, ".invkirchhof") , "w") ;

for (n=1 ;  n<=num_of_nodes ; n++)  {
	for (m=1 ;  m<=num_of_nodes ; m++)  {
		fprintf (fh , "%10.5f " , invkirmat[n][m]) ;
	
	}
	fprintf (fh ,"\n") ;
}

fclose (fh) ;

}

void print_crosscorrelations(net *netobj , float **cc)  {
int m,n ;
int num_of_nodes ;
FILE *fh ;	
char file[50] ;

strcpy(file , netobj->file) ;
	
num_of_nodes = netobj->numnodes ;

fh =  fopen(strcat(file, ".crosscorrelations") , "w") ;

for (n=1 ;  n<=num_of_nodes ; n++)  {
	for (m=1 ;  m<=num_of_nodes ; m++)  {
		fprintf (fh , "%10.5f " , cc[n][m]) ;
	
	}
	fprintf (fh ,"\n") ;
}

fclose (fh) ;

}

void print_modes(net *netobj , float **modes)  {
int i,k ;
int num_of_nodes ;
FILE *fh ;	
char file[50] ;

strcpy(file , netobj->file) ;
	
num_of_nodes = netobj->numnodes ;

fh =  fopen(strcat(file, ".modes") , "w") ;

for (i=1 ;  i<=num_of_nodes ; i++)  {
	for (k=2 ;  k<=num_of_nodes ; k++)  {
		fprintf (fh , "%10.5f " , modes[i][k]) ;
	
	}
	fprintf (fh ,"\n") ;
}

fclose (fh) ;

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
// fprintf (fh , "th: %f\n" , th) ;

fclose (fh) ;

}

void pseudoinverse(float d[], float **v, float **crc, int n)  {

/**********************************************************************************************
// 
// Given the eigenvalues d[2..n] and eigenvectors v[2..n][1..n] 
// calculate the psedo inverse of the original symmetrical matrix.
// This inverse - crc corresponds to the correlation and the crosscorrelations as:
// <DrTi*Drj> = 3kbT/Gamma * crc(i,j)
//
// Eran (9/2005) 
//
**********************************************************************************************/


int k,j,i;

for (i=1;i<=n;i++)   {		      // index for row
	for (j=1;j<=i;j++)    {        // index for column
		crc[i][j] = 0.0 ;
		for (k=2;k<=n;k++)  {  // index for Eigenvalue and corresponding eigen vector ignoring the first
			crc[i][j] += (v[i][k]*v[j][k]/d[k]) ;
			crc[j][i] = crc[i][j] ;
		}
	}
}

}

void normalizedcc (float **invkir, float **cc, int n)  {


/**********************************************************************************************
// 
// Given the inverse-kirchhof matrix - calculate normalized cross-correlations by the 
// Equation;  CCij = invk(ij)/sqrt(invk(ii)*invk(jj))
//
// Eran (9/2005) 
//
**********************************************************************************************/

int k,j,i;

for (i=1;i<=n;i++)   {		      // index for row
	for (j=1;j<=i;j++)    {        // index for column
		cc[i][j] = 0.0 ;
		for (k=2;k<=n;k++)  {  // index for Eigenvalue and corresponding eigen vector igmoring the first
			cc[i][j] = invkir[i][j]/sqrt(invkir[i][i]*invkir[j][j]) ;
			cc[j][i] = cc[i][j] ;
		}
	}
}

}

void normalizedtc_as (char *file1, char *file2, float *d, float **v, float **invkir, float *tc_as, int n) {
/**********************************************************************************************
//
// Given the inverse-kirchhof matrix - calculate normalized tc by the
// Equation;  (TCij)k = v(ik)*v(jk)/d[k]/sqrt(v(ik)*v(ik)/d[k]*v(jk)*v(jk)/d[k])
//
// xmma (10/2014)
//
**********************************************************************************************/
printf("normalizedtc\n");
FILE *fp1=NULL, *fp2=NULL;
int a=0;
int b=0;
int k;

for(k=2;k<=n;k++) {
	
	fp1 = fopen(file1, "r");
	if(NULL==fp1)printf("can't open file!\n");
    do
    {
        fscanf(fp1, "%d\n", &a);
        fp2 = fopen(file2, "r");
        do
        {
            fscanf(fp2, "%d\n", &b);
            if(b == a) continue;
            else 
            {
                tc_as[k] = tc_as[k] + v[a][k]*v[b][k]/d[k]/sqrt(v[a][k]*v[a][k]/d[k]*v[b][k]*v[b][k]/d[k]);
            }
        }
        while(1 != feof(fp2));
            fclose(fp2);
    }
    while(1 != feof(fp1));
    fclose(fp1);
}

}

void calculatemodes (float **v, float **modes, int n)  {

/**********************************************************************************************
// 
// Given the inverse-kirchhof matrix - calculate the modes  
// Equation;  MODEk(i) = invk(ki)*invk(ki)
//
// Eran (9/2005) 
//
**********************************************************************************************/

int k,j,i;

for (i=1;i<=n;i++)   {		      // index for row
	for (k=2;k<=n;k++)  {  // index for Eigenvalue and corresponding eigen vector igmoring the first
		modes[i][k] = v[i][k]*v[i][k] ;
	}
}

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








