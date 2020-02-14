function useeigs(hes,neigen)
[A,num] =readhes(hes) ;

options.tol = 1e-5;
options.maxit = 300;
options.disp = 0;
subspace = 25;

tic
[V,D, FLAG] = eigs(A , neigen , 'SA' , options) ;
toc
DL = diag(D);

save -ascii gnmeigs.flag FLAG ;
save -ascii gnmeigs.eigenvectors V ;
save -ascii gnmeigs.eigenvalues  DL ;
