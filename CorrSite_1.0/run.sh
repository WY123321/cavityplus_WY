#!/bin/sh

#/Step0: pdbfile, cavityfile, orthosteric site file should be prepared in one directory,and the directory is suggested be put into the same path with this running script in order to use this script conveniently./

#/Step1:calculate indexfile/
./gnm_index 1T49/1T49.pdb "*" 0 
cavitynum=`ls 1T49/1T49_cavity* | wc -l`

#/Step2:dealwithcavityfiles/
for dir in 1T49; do
   echo $dir 
   cd $dir
   #/rename the orthosteric site./
   #/Please make sure the residue order in the orthosteric site file is the same with pdbfile. In this sample, the orthosteric site is defined as the residues around the effector, which binds in the same site as the protein’s endogenous ligand, to within 5A. If there is no complex structure with this kind of effector binding, you can assign the orthosteric residue directly, please put these number into "1T49_cavity_0_num_uniq.dat" file, one line, one unique number.  The total residue number in the orthosteric sites is suggested more than three./   
   cp substrate_5.pdb 1T49_cavity_0.pdb
#/make residue number in cavity unique/   
   for file in 1T49_cavity_*.pdb; do
		   awk '{if($1=="ATOM") printf("%5s\n", substr($0,22,5))}' $file > ${file%.pdb}_num.dat
		   uniq ${file%.pdb}_num.dat > ${file%.pdb}_num_uniq.dat
		   sed -i s/[[:space:]]//g ${file%.pdb}_num_uniq.dat
   done
#/get useful information in indexfile/   
    for file in 1T49.pdb.index; do
        awk '{print $5 $4, $1}' $file > ${file%.pdb.index}_index_fix.dat
    done
#/renumber residues according to indexfile/	
    for file in 1T49_cavity_*_num_uniq.dat; do
        awk '{if(ARGIND==1) {val[$1]} else{if($1 in val)  print $2}}' $file 1T49_index_fix.dat >${file%.dat}_fix.dat
    done
#/remove cavities' residues which also belong in the orthosteric site/
	cp *_cavity_0_num_uniq_fix.dat list.out
    for file in 1T49_cavity_*_num_uniq_fix.dat; do
        diff $file list.out | grep \< > ${file%.dat}_test.dat
        awk '{print $2}' ${file%.dat}_test.dat > ${file%.dat}_2015.dat
        rm -r ${file%.dat}_test.dat
    done
    cd ..
done

#/Step3:run_gnm/

for dir in 1T49; do
    for((i=1;i<=$cavitynum;i++));do
        ./gnm_occ ./${dir}/${dir}.pdb "*" 0 ./${dir}/${dir}_cavity_0_num_uniq_fix.dat ./${dir}/${dir}_cavity_${i}_num_uniq_fix_2015.dat
        mv ./${dir}/${dir}.pdb.tc_as ./${dir}/${dir}.pdb.tc_as_a${i}_all
    done
done

#/Step4: tc_as to tc_as_fabs/

for dir in 1T49; do
    echo Summary $dir
    cd $dir
    for((i=1;i<=$cavitynum;i++));do
        awk '{print sqrt($1*$1)}' ${dir}.pdb.tc_as_a${i}_all > ${dir}.pdb.tc_as_a${i}_all_fabs
    done
    cd ..
done

#/Step5: summary_tc_fabs/

for dir in 1T49; do
    cd $dir
    cp ../sum_fabs_all.sh ./
    sh ./sum_fabs_all.sh > sum_tc_fabs_all_${dir}.dat
    cd ..
done

#/Step6: sort_summary_tc_fabs/

for dir in 1T49; do
    cd $dir
    cat sum_tc_fabs_all_${dir}.dat | sort -k2 -n > sum_tc_fabs_all_${dir}_sort.dat
    cd ..
done

#/Step7: normalization in summaryfile /
for dir in 1T49; do
		cd $dir
		cat sum_tc_fabs_all_${dir}_sort.dat | awk '{if($2!=0) print $0}' > sum_tc_fabs_all_${dir}_sort_correct.dat
cd ..
done

#/Step8: remove cavities which overlap with orthosteric site/
for dir in 1T49;
do
		cd $dir
		cp sum_tc_fabs_all_${dir}_sort_correct.dat sum_tc_fabs_all_${dir}_sort_fix_test.dat
		m=$(cat ${dir}_cavity_0_num_uniq_fix.dat | wc -l)
		echo The orthosteric site contains $m residues. 
		for((i=1;i<=$cavitynum;i++));do
				cat ${dir}_cavity_0_num_uniq_fix.dat ${dir}_cavity_${i}_num_uniq_fix.dat | sort | uniq -d | sort -n >common_0.dat
				n=$(cat common_0.dat | wc -l)
				echo $n >> ${dir}_common_0.dat
		done
		echo $m >> ${dir}_common_0.dat
		cat ${dir}_common_0.dat | awk '{print  $1/'$m'}' > ${dir}_common_0_fix.dat
		sed -i '$d' ${dir}_common_0_fix.dat
		rm ${dir}_common_0.dat
		cat ${dir}_common_0_fix.dat | awk '{if($1 >= 0.75 ) printf("%d\n", NR)}'> overlap.dat
		cat overlap.dat | while read line;
do
		echo The cavity$line is overlap with the orthosteric site.
		sed  -i '/1T49.pdb.tc_as_a'$line'_all_fabs/d' sum_tc_fabs_all_${dir}_sort_fix_test.dat
done
cd ..

for dir in 1T49;
do
		cd $dir
		cat sum_tc_fabs_all_${dir}_sort_fix_test.dat | awk '{print $2}' > average_delta.dat
		cat average_delta.dat | awk 'BEGIN{sum=0.0; sigma=0.0;} {sum=sum+$1; sigma=sigma+$1*$1;} END{sum=sum/NR; sigma=sqrt(sigma/NR-sum*sum); printf("%9.6f %9.6f\n",sum, sigma)}' > ${dir}_average_delta.dat
		ave=$(cat ${dir}_average_delta.dat | awk '{print $1}')
		sigma=$(cat ${dir}_average_delta.dat | awk '{print $2}')
		cat sum_tc_fabs_all_${dir}_sort_fix_test.dat | awk '{print $1, ($2-'$ave')/'$sigma'}'> ../summary_${dir}_all_fix1.out
		cat ../summary_${dir}_all_fix1.out| sort -k 2nr >../summary_${dir}_all_fix.out
		cat ../summary_${dir}_all_fix.out | awk '{if($2>=0.5) print $0}' > ../summary_${dir}_all_fix_cutoff0.5.out
done
		cd ..
		echo The summaryfile is in summary_${dir}_all_fix.out
		echo The potential allosteric sites are in summary_${dir}_all_fix_cutoff0.5.out
done


for dir in 1T49;
do
rm -f $dir/*.dat
rm -f $dir/${dir}.pdb.*
rm -f $dir/*.sh
done
