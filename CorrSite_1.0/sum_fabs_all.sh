#!/bin/sh
for f in *.pdb.tc_as_a*_all_fabs
do
awk 'BEGIN{total=0}{total+=$1}END{print "'$f'", total}' $f 
done
