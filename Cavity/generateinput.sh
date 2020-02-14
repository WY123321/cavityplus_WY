#!/bin/bash
if [ $# -ne 9 ];then
    echo "Error."
    exit
fi
mode=$1
receptorfile=$2
receptorname=${receptorfile##*/}
ligandfile=$3
ligandname=${ligandfile##*/}
separate_min_depth=$4
max_abstract_limit=$5
separate_max_limit=$6
min_abstract_depth=$7
ruler1=$8
output_rank=$9
echo $output_rank



echo "########################################################################
#	Include section
########################################################################
INCLUDE				./default/default.input
########################################################################
#	Input section
########################################################################
#-----------------------------------------------------------------------
#	Detect mode
#	-- 0: whole protein mode
#	   1: ligand detection mode
#	   2: area detection mode
#-----------------------------------------------------------------------
DETECT_MODE			$mode
#-----------------------------------------------------------------------
#	Input files
#	-- ligand_file should be assigned if detect_mode = 1
#-----------------------------------------------------------------------
RECEPTOR_FILE		 	example/AA/$receptorname
LIGAND_FILE			    example/AA/$ligandname
########################################################################
#	Parameter section
########################################################################
#-----------------------------------------------------------------------
#	Parameter for vacant/vacant-surface method
#	-- Standard :common cavity
#	-- Peptides :shallow cavity, e.g. piptides 
#		     binding site, protein-protein interface
#	-- Large    :complex cavity, e.g. multi function
#		     cavity, channel, nucleic acid site 
#	-- Super    :sized cavity
#-----------------------------------------------------------------------
INCLUDE				./default/standard.input
#INCLUDE				./default/peptide.input
#INCLUDE				./default/large.input
#INCLUDE				./default/super.input
" > example/cavity-AA.input

echo "########################################################################
#	Include section
########################################################################
#INCLUDE				./parameter/default.input
#AUTONAME			1a6w/1a6w
########################################################################
#	Input section
########################################################################
#-----------------------------------------------------------------------
#	Detect mode
#	-- 0: whole protein mode
#	   1: ligand detection mode
#	   2: area detection mode
#-----------------------------------------------------------------------
DETECT_MODE			$mode
#-----------------------------------------------------------------------
#	Input files
#	-- ligand_file should be assigned if ligand_mod = 1
#-----------------------------------------------------------------------
RECEPTOR_FILE		1db4/1db4.pdb	
LIGAND_FILE			1db4/1db4.mol2	
PARAMETER_DIRECTORY		./parameter/
#-----------------------------------------------------------------------
#	Area mode
#	-- the coordinates of manually assigned box
#-----------------------------------------------------------------------
MIN_X				9.50
MAX_X				33.50
MIN_Y				44.00
MAX_Y				74.00
MIN_Z				9.00
MAX_Z				32.00
#-----------------------------------------------------------------------
#	Input parameters
#	-- boundary: ligand and area mod boundary justify
#	-- single_ligand 1:only process the largest compoents of ligand
#	-- separate polymolecular to monomer
#	   -2 = exclude invalid chain (CHAIN_INVALID)
#	   -1 = only valid chain (CHAIN_VALID)
#	    0 = operating on all parts
#	    n = operating on n parts
#	-- use ligand to decide which monomers will be involved
#	   this switch will forbiden all hetatom exclude those around ligand
#	-- locate_distance: locate distance of ligand locate
#	-- hetmetal: metal irons /  hetwater: water molecules
#	   1 =allow 0 = forbiden
#-----------------------------------------------------------------------
BOUNDARY			0
SINGLE_LIGAND			1
MONOMER				0	
LIGAND_LOCATE			0
LOCATE_DISTANCE			5
HETMETAL			1
HETWATER			0
CHAIN_VALID			ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890
CHAIN_INVALID			ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890
#-----------------------------------------------------------------------
#	Rotate the protein
#-----------------------------------------------------------------------
ROTATE_X			0
ROTATE_Y			0
ROTATE_Z			0
#-----------------------------------------------------------------------
#	Special mode
#-----------------------------------------------------------------------
EXCHANGE			0
POINT				0
IN_SLOP				3
OUT_SLOP			3
########################################################################
#	Output section
########################################################################
#-----------------------------------------------------------------------
#	Output mode
#	-- run_info 1:open 0:close
#	-- visual_output  1:output visual results 0:close
#	-- pdb_output 1:output all atoms 2:output cavity atoms
#-----------------------------------------------------------------------
RUN_INFO			0
VISUAL_OUTPUT			1
PDB_OUTPUT			2
#-----------------------------------------------------------------------
#	Output files
#	-- use the basename of receptor file
#-----------------------------------------------------------------------
#V_SURFACE			default_surface.pdb
#V_CAVITY_VACANT		default_vacant.pdb
#V_CAVITY_ATOM			default_cavity.pdb
#POCKET_ATOM_FILE		default_pocket.txt
#POCKET_CAVITY_FILE		default_cavity.txt
#POCKET_GRID_FILE		default_grid.txt
#KEY_SITE_FILE			default_key_site.pdb
#PHARMACOPHORE_TXT_FILE		default_pharmacophore.txt
#PHARMACOPHORE_PDB_FILE		default_pharmacophore.pdb
#-----------------------------------------------------------------------
#	Output parameters
#	-- distance:output protein atom distance
#	-- v_point_num:lager for smaller visual pdb size
#	   smaller for better quality(min=1)
#	-- v_output_mod 0:random point 1:chips
#-----------------------------------------------------------------------
MINIMAL_FEATURE_DISTANCE	3.50
MAXIMAL_FEATURE_NUMBER		12
DISTANCE			5
V_POINT_NUM			1
V_OUTPUT_MOD			0	
#-----------------------------------------------------------------------
#	Output filter
#-----------------------------------------------------------------------
OUTPUT_RANK			$output_rank
RULER_1				$ruler1
########################################################################
#	Parameter section
########################################################################
#-----------------------------------------------------------------------
#	Detect method
#	-- judge 0=surface 1=vacant 2=vacant-surface
#	-- eraser shap 0=ball 1=cubic 2=global
#	-- radius_lenth : radius or half lenth [step:1A]
#	-- radius mis [step:1A],  bigger to flat and thick and slow,  
#	   smaller to opposite. Use bigger value when radius is bigger
#	-- edge adjust  [step:(+/-)0.5A]
#	-- vacant adjust [step:(+/-)0.5A]
#-----------------------------------------------------------------------
JUDGE				2
ERASER				2
RADIUS_LENTH			10.0
RADIUS_MIS			0.5
EDGE_ADJUST 			0
VACANT_ADJUST			0
#-----------------------------------------------------------------------
#	Parameter for surface method
# 	-- SCL: skip cavity separate step if surface < limit
#	-- SML, MAL: surface auto separate [step:0.5A]
#-----------------------------------------------------------------------
SEPARATE_CHIP_LIMIT		30
SEPARATE_MAX_LIMIT		$separate_max_limit
MAX_ABSTRACT_LIMIT		$max_abstract_limit
#-----------------------------------------------------------------------
#	Parameter for vacant/vacant-surface method
# 	-- SCLV: skip cavity separate step if vacant < limit
#	-- SCD: skip cavity fill step if depth < limit
#	-- SMD, MAD, MDV: vacant auto separate [step:0.5A]
#	-- MALV, SMLV, MAD, RL: vacant-surface separate  [step:0.5A]
#-----------------------------------------------------------------------
SEPARATE_CHIP_LIMIT_V		300
SEPARATE_CHIP_DEPTH		1
SEPARATE_MIN_DEPTH		$separate_min_depth
MAX_ABSTRACT_DEPTH		20
MAX_DEPTH_VACANT		100
MAX_ABSTRACT_LIMIT_V		1500
SEPARATE_MAX_LIMIT_V		6000
MIN_ABSTRACT_DEPTH		$min_abstract_depth
RIGID_LIMIT			0
#-----------------------------------------------------------------------
#	Solvent accessible radius
#	-- suggest 1.4A~1.6A
#-----------------------------------------------------------------------
ATOM_RADIUS_ADJUST		1.5
" > default/default.input

echo "########################################################################
#	Parameter section
########################################################################
#-----------------------------------------------------------------------
#	Parameter for vacant/vacant-surface method
#	-- Standard :8/1500/6000/2	//common cavity
#	-- Peptides :4/1500/6000/4	//shallow cavity, e.g. piptides 
#					  binding site, protein-protein interface
#	-- Large    :8/2500/8000/2	//complex cavity, e.g. multi function
#					  cavity, channel, nucleic acid site 
#	-- Super    :8/5000/16000/2	//super sized cavity
#-----------------------------------------------------------------------
SEPARATE_MIN_DEPTH		$separate_min_depth
MAX_ABSTRACT_LIMIT_V		1500
SEPARATE_MAX_LIMIT_V		6000
MIN_ABSTRACT_DEPTH		$min_abstract_depth
" > default/standard.input


