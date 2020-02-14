#!/bin/sh
# input is a file named '*.htmlinput', which saved the parameters from html.
if [ $# -ne 10 ];then
    echo "Error. Parameter is not right."
    exit
fi
sessionid=$1
mode=$2
receptorfile=$3
ligandfile=$4
separate_min_depth=$5
max_abstract_limit=$6
separate_max_limit=$7
min_abstract_depth=$8
ruler1=$9
output_rank=${10}

sessiondir="user_sess/"$sessionid
receptorfile="../../"$receptorfile
ligandfile="../../"$ligandfile
receptorname=${receptorfile##*/}
ligandname=${ligandfile##*/}

if [ ! -d $sessiondir ];then
    echo "Make session dir..."
    mkdir $sessiondir
fi
echo "Prepare for $sessionid"
echo "movefile into your session..."
cp -r Cavity/* $sessiondir/
cd $sessiondir
echo "Configure cavity files..."
rm -f example/AA/*
cp $receptorfile example/AA/
if [ $mode -eq "1" ];then
    cp $ligandfile example/AA/
fi
echo "generate input file..."
./generateinput.sh $mode $receptorfile $ligandfile $separate_min_depth $max_abstract_limit $separate_max_limit $min_abstract_depth $ruler1 $output_rank
echo "run cavity..."
#cp cavity.input$ example/cavity-AA.input$
#chmod 777 example/cavity-AA.input$
./cavity64 example/cavity-AA.input > output.log

cavitynum=`ls example/AA/thischains_cavity*|wc -l`

echo "Number:"$cavitynum > example/AA/outputcavity.txt

for ((i=1; i<=$cavitynum; ++i))
do
      echo -n "Cavity$i|" >> example/AA/outputcavity.txt
      echo `cat example/AA/thischains_cavity_${i}.pdb| awk 'BEGIN{FIELDWIDTHS = "6 5 1 4 1 3 1 1 4 1 3 8 8 8 6 6 6 4"}{if ($1 == "ATOM  "){print($6,$9,$8)}}' |awk '{print($1":"$2":"$3)}'|uniq`>> example/AA/outputcavity.txt
done



