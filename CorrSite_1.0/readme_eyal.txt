C code to run GNM.
Matlab code to obtain subset of slow modes
 
The programs: 

1. Full GNM using SVD. Appropriate only to relatively small systems

Compilation:
cc -lm -O2 -o gnm_svd gnm_svd.c

Run:
gnm_svd [pdb_file] [chain] [model] 

Note:
The pdb file should be in the current directory. 
Chain must be specified. If the chain is the space character you have to put " " (you need to
put the "" in the command line) in the second parameter. To model all chains in the file use "*" (again, you need to
put the "" in the command line).
The model also nust be specified. If there is no model or you want to consider residues in
all models use the 0 value for the third argument.

Example:

gnm_svd 1atp.pdb "*" 0

will model all the nodes (as defined in nodes.txt) in all the chains and all nodels of pdb file 1atp.pdb.  

The input file nodes.txt defines the nodes in the system and the cutoffs. for example:
#ATM CUTOFF  
#%4S%5.2f
 CA  3.65
 P   5.00
defines that CA atoms and P atoms are nodes.
The cutoff distance of the program to determine contact between pairs of atoms is the sum of the atomic cutoffs in this file.
for example, here the interaction cutoff between two CA atoms will be 3.65A+3.65A=7.3A and for interactions between CA and P 
will be 3.65A+5A=8.65A

The output files include:

pdb_file.kirchhof:         the Kirchhof matrix of the system
pdb_file.sparsekirchhof:   the Kirchhof matrix of the system in a sparse format (i j value).
pdb_file.index:            defines the nodes and include also coordinates and b-factor information
pdb_file.log               give basic information about this run
pdb_file.invkirchhof       the psudo inverse of the Kirchhof (the covariance matrix)
pdb_file.modes             list the mean self square fluctuations of each residue in each mode 
                           (the diagonal of the outer product of each mode)
pdb_file.crosscorrelations normailzed covariance matrix:  crosscorrelations(i,j) = invkirchhof(i,j)/sqrt(invkirchhof(i,i)*invkirchhof(j,j))
pdb_file.eigenvectors      complete eigenvectors (including the first one). Eigenvectors are listed as columns.
pdb_file.eigenvalues       eigenvalues (including the first zero eigenvalue).


2.  Construction of a Kirchhof matrix. Appropriate for large systems, where the eigen problem should be solved by other
application

Compilation:
cc -lm -02 -o gnm_kirchhof_econo gnm_kirchhof_econo.c

Run:
gnm_kirchhof_econo [pdb_file] [chain] [model] 

Note:
The pdb file should be in the current directory. 
Chain must be specified. If the chain is the space character you have to put " " (you need to
put the "" in the command line) in the second parameter. To model all chains in the file use "*" (again, you need to
put the "" in the command line).
The model also nust be specified. If there is no model or you want to consider residues in
all models use the 0 value for the third argument.

Example:

gnm_kirchhof_econo 1atp.pdb "*" 0

will create the Kirchhof matrix based on the nodes (as defined in nodes.txt) in all the chains and all nodels of pdb file 1atp.pdb.  

The input file nodes.txt defines the nodes in the system and the cutoffs. for example:
#ATM CUTOFF  
#%4S%5.2f
 CA  3.65
 P   5.00
defines that CA atoms and P atoms are nodes.
The cutoff distance of the program to determine contact between pairs of atoms is the sum of the atomic cutoffs in this file.
for example, here the interaction cutoff between two CA atoms will be 3.65A+3.65A=7.3A and for interactions between CA and P 
will be 3.65A+5A=8.65A

The output files include
pdb_file.sparsekirchhof: the Kirchhof matrix of the system in a sparse format (i j value).
pdb_file.index:          defines the nodes and include also coordinates and b-factor information
pdb_file.log             give basic information about this run


3. A Matlab code to call the function the retrieve a subset of modes (eigenvalues and eigenvectors) .Uses the eigs function of Matlab (which uses ARPACK). The input is a sparse matrix.

To functions are 
useeigs.m  (call the eigs function)
readhes.m  (parse the Kirchhof matrix)

To call the function within matlab:

useeigs ('pdb_file.sparsekirchhof' , neigen) ;

'pdb_file.sparsekirchhof' is the file obtained from gnm_kirchhof_econo. neigen is the number of slow modes requested.

The matlab code creates 3 output files:

anmeigs.flag:            a flag to indicate a success run (0 value)
anmeigs.eigenvectors:    eigen vectors (listed as columns, including the first constant one)
anmeigs.eigenvalues:     eigen values  (including the zero eigenvalue).

Refer to the Matlab documentation for more help regarding the matlab code.


The code and documentation were written by Eran Eyal (2006) eyal@pitt.edu
Source code copyright University of Pittsburgh, released under the GPL terms,
see license.txt.





 

