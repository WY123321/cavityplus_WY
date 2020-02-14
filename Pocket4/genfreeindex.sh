#!/bin/bash
if [ $# -ne 2 ];then
    echo "Error occured when run $0"
    exit
fi
cavityfile=$1
vacantfile=$2
cavityname=${cavityfile##*/}
vacantname=${vacantfile##*/}
name="pkout"

echo "### INPUT PARAMETER ###
POCKET_FILE                  $cavityname
GRID_FILE                    $vacantname
#SURFACE_FILE                 example/1m49_surface_3.pdb

GRID_CLOSE_LIGAND            NO

SPITBALLPOINT_FILE           ./data438.pts
CUTOFF_DIST                  5.0

### OUTPUT PARAMETER ###
KEY_SITE_FILE                ${name}-key-site.pdb
#EXCLUDED_VOLUME             ${name}-excluded-volume.pdb
#EXCLUDEDVOL_PHARM           ${name}-excludedvol-pharm.pdb
PHARMACOPHORE_PDB_FILE       ${name}-pharmacophore-free.pdb
#PHARMACOPHORE_TXT_FILE      ${name}-pharmacophore-free.txt
#PHARMACOPHORE_CHM_FILE      ${name}-pharmacophore-free.chm

#ANALYSISDISTANCE_TXT_FILE   ${name}-analysis_dist.txt
" > pocket-free.index

