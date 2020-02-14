#!/bin/bash
if [ $# -ne 3 ];then
    echo "Error occured when run $0"
    exit
fi
cavityfile=$1
vacantfile=$2
ligandfile=$3
cavityname=${cavityfile##*/}
vacantname=${vacantfile##*/}
ligandname=${ligandfile##*/}
name="pkout"

echo "### INPUT PARAMETER ###
POCKET_FILE                  $cavityfile
GRID_FILE                    $vacantfile
#SURFACE_FILE                 ${name}_surface_3.pdb

GRID_CLOSE_LIGAND            YES 
LIGAND_FILE                  $ligandfile

SPITBALLPOINT_FILE           ./data438.pts
CUTOFF_DIST                  5.0

### OUTPUT PARAMETER ###
KEY_SITE_FILE                ${name}-key-site.pdb
PHARMACOPHORE_PDB_FILE       ${name}-pharmacophore.pdb
PHARMACOPHORE_TXT_FILE       ${name}-pharmacophore.txt
PHARMACOPHORE_CHM_FILE       ${name}-pharmacophore.chm

INTERACT_PDB_FILE            ${name}-interact.pdb
INTERACT_TXT_FILE            ${name}-interact.txt
PHARMACOPHORE_KEY_PDB        ${name}-key-pharmacophore.pdb

ANALYSISDISTANCE_TXT_FILE    ${name}-analysis_dist.txt
" > pocket.index

