#!/bin/bash

sessiondir=$1



cp ./CorrSite_1.0/* ${sessiondir}
cd $sessiondir
selectcavityid=`cat orthonum.txt`

sh run.sh
cat summary_1T49_all_fix_cutoff0.5.out

echo -n "OrthSite|Cavity${selectcavityid}|" > output.txt
echo `cat 1T49/1T49_cavity_0.pdb | awk 'BEGIN{FIELDWIDTHS = "6 5 1 4 1 3 1 1 4 1 3 8 8 8 6 6 6 4"}{if ($1 == "ATOM  "){print($6,$9,$8)}}' |awk '{print($1":"$2":"$3)}'|uniq`>>output.txt
cat summary_1T49_all_fix.out|sed s/'1T49.pdb.tc_as_a'//g| sed s/'_all_fabs'//g | while read LINE 
do
arr=($LINE)
cavityid=${arr[0]}
corrScore=${arr[1]}
echo -n "Cavity$cavityid|$corrScore|" >> output.txt
echo `cat 1T49/1T49_cavity_${cavityid}.pdb | awk 'BEGIN{FIELDWIDTHS = "6 5 1 4 1 3 1 1 4 1 3 8 8 8 6 6 6 4"}{if ($1 == "ATOM  "){print($6,$9,$8)}}' | awk '{print($1":"$2":"$3)}'|uniq`>>output.txt
done
cat output.txt
rm -f summary*.out

