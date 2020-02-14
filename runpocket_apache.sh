#!/bin/bash
# ./runpocket.sh [sessionid] [cavity_file] [vacant_file] [withLigand] [ligand_file] 
if [ $# -ne 5 ];then
    echo "Error."
    exit
fi
sessionid=$1
cavitypath=$2
vacantpath=$3
withLigand=$4
ligandpath=$5
cavityfile=${cavitypath##*/}
vacantfile=${vacantpath##*/}
sessiondir=$sessionid
if [ ! -d $sessiondir ];then
    echo "Create directory..."
    mkdir $sessiondir
fi
cp Pocket4/* $sessiondir

if [ $withLigand -eq 1 ];then
    ligandfile=${ligandpath##*/}
    cd $sessiondir
    ./genindex.sh $cavityfile $vacantfile $ligandfile
    echo "Run pocket..."
    ./pocket pocket.index
    cp pkout-pharmacophore.pdb pkout-pharmacophore-free.pdb
else
    cd $sessiondir
    ./genfreeindex.sh $cavityfile $vacantfile
    echo "Run pocket..."
    ./pocket pocket-free.index
fi



cat pkout-pharmacophore-free.pdb | grep HETATM | grep -B 1 F | awk '{print $4,$5,$3,$2}' > pkout-atoms.txt



