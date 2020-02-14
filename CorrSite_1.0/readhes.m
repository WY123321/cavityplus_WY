function [A,num] =readhes(hes)
[i,j,value]=textread(hes,'%d%d%f');
num=i(length(i)) 
A=sparse([i ; j] , [j ; i] ,[value ; value])  ;
for i=1:num
	A(i,i) = A(i,i) / 2 ;
end
