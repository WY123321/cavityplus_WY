#!/bin/sh
#/calculate solvent accessible surface area/
cp example/1T49.pdb ./pops-1.6.4/src
cd pops-1.6.4/src
./pops --pdb 1T49.pdb --residueOut --popsOut 1T49_SASA.out
sed -i '1,4d' 1T49_SASA.out
sed -i -n -e :a -e '1,6!{P;N;D;};N;ba' 1T49_SASA.out
awk '{print NR, $7}' 1T49_SASA.out | sort -n -k2 > 1T49_SASA_order.out
#/choose residues over 50% fraction of solvent accessible surface area/
awk '{if($2 >= 0.5 ) print $1}' 1T49_SASA_order.out | sort -n  > 1T49_SASA_order_50.out
cd ../..
#/remove residues over 50% fraction of solvent accessible surface area which also belong to the orthosteric site/
cp ./pops-1.6.4/src/1T49_SASA_order_50.out ./example
cd example
diff 1T49_SASA_order_50.out list.out | grep \< > ${dir}_cavity_000_num_uniq.dat
awk '{print $2}' ${dir}_cavity_000_num_uniq.dat > ${dir}_cavity_000_num_uniq_fix_2015.dat
cd ..

