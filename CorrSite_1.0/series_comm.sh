#!/bin/sh
for dir in 1YBA;
do
echo $dir
cd $dir
cp sum_tc_fabs_all_${dir}_999_sort_fix.dat sum_tc_fabs_${dir}_sort_fix_test.dat
m=$(cat ${dir}_cavity_0_num_uniq_fix.dat | wc -l)
echo $m 
for((i=1;i<=26;i++));
do
cat ${dir}_cavity_0_num_uniq_fix.dat ${dir}_cavity_${i}_num_uniq_fix.dat | sort | uniq -d | sort -n >common_0.dat
n=$(cat common_0.dat | wc -l)
echo $n >> ${dir}_common_0.dat
done
echo $m >> ${dir}_common_0.dat
cat ${dir}_common_0.dat | awk '{print $1/'$m'}' > ${dir}_common_0_fix.dat
#for((j=24;j<=26;j++));
#do
#m1=$(cat ${dir}_cavity_${j}_num_uniq_fix.dat | wc -l)
#for((i=1;i<=23;i++));
#do
#cat ${dir}_cavity_${j}_num_uniq_fix.dat ${dir}_cavity_${i}_num_uniq_fix.dat | sort | uniq -d | sort -n >common_${j}.dat
#n1=$(cat common_${j}.dat | wc -l)
#echo $n1 >> ${dir}_common_${j}.dat
#done
#echo $m1 >> ${dir}_common_${j}.dat
#cat ${dir}_common_${j}.dat | awk '{print $1/'$m1'}' > ${dir}_common_${j}_fix.dat
#done

#for file in sum_tc_fabs_k25_${dir}_sort_fix_test.dat;
#do
#awk '/^[^a999]/ {print $0}' $file > ${file%.dat}_nocavity999.dat
#awk '{print $2}' ${file%.dat}_nocavity999.dat > test.dat
#awk 'BEGIN{sum=0.0;} {sum=sum+$1;} END{print sum/NR}' test.dat
#a=$(awk 'BEGIN{sum=0.0; sigma=0.0;} {sum=sum+$1;} END{print sum/NR}' test.dat)
#awk 'BEGIN{sigma=0.0;} {sigma=($1-'$a')*($1-'$a');}END{print sqrt(sigma/NR)}' test.dat
#done
rm ${dir}_common_0.dat
cd ..
done
