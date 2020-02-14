#!/usr/bin/env python
''' 
This script cleans PDBs for Rosetta by removing extraneous information, 
converting residues names and renumbering.

It outputs both the cleaned PDB and a fasta file of the cleaned sequence.
Required parameters are the name of the PDB you want to clean, 
and the chain ids of the chains you want.

The PDB name may be specified with or without the .pdb file handle and 
may be provided as a gziped file.
If the PDB isn't found locally, the given 4 letter code will be fetched from the internet.

Chain id: only the specified chains will be extracted. 
You may specify more than one: "AB" gets you chain A and B,
and "C" gets you just chain C. 

Special notations are "nochain" to remove chain identiry from the output, 
and "ignorechain" to get all the chains.

(Script written by Phil Bradley, Rhiju Das, Michael Tyka, 
    TJ Brunette, and James Thompson from the Baker Lab. 
    Edits done by Steven Combs, Sam Deluca, Jordan Willis and Rocco Moretti 
    from the Meiler Lab.)
'''

# Function of this script: "clean" raw pdb file by following tasks so that rosetta modeling becomes easier

## starts residue number at 1
## translates certain residues to their cannonical amino acid equivalents
## removes unknown residues
## removes residues with 0 occupancy
## generates a fasta file
## and leaves the 1st model among many NMR models

import sys
import os
from sys import argv, stderr, stdout
from os import popen, system
from os.path import exists, basename
#from optparse import OptionParser
import argparse

# Local package imports

from amino_acids import longer_names
from amino_acids import modres

# remote host for downloading pdbs
remote_host = ''

shit_stat_insres = False
shit_stat_altpos = False
shit_stat_modres = False
shit_stat_misdns = False  # missing density!

fastaseq = {}
pdbfile = ""


def check_and_print_pdb(count, residue_buffer, residue_letter):
    global pdbfile
  # Check that CA, N and C are present!def check_and_print_pdb( outid, residue_buffer )
    hasCA = False
    hasN = False
    hasC = False
    for line in residue_buffer:
        atomname = line[12:16]
        # Only add bb atoms if they have occupancy!
        occupancy = float(line[55:60])
        if atomname == " CA " and occupancy > 0.0:
            hasCA = True
        if atomname == " N  " and occupancy > 0.0:
            hasN = True
        if atomname == " C  " and occupancy > 0.0:
            hasC = True

  # if all three backbone atoms are present withoccupancy proceed to print the residue
    if hasCA and hasN and hasC:
        for line in residue_buffer:
            # add linear residue count
            newnum = '%4d ' % count
            line_edit = line[0:22] + newnum + line[27:]
            # write the residue line
            pdbfile = pdbfile + line_edit

    # finally print residue letter into fasta strea
        chain = line[21]
        try:
            fastaseq[chain] += residue_letter
        except KeyError:
            fastaseq[chain] = residue_letter
    # count up residue number
        count = count + 1
        return True
    return False

def get_pdb_filename( name ):
    '''Tries various things to get the filename to use.
    Returns None if no acceptable file exists.'''
    if( os.path.exists( name ) ):
        return name
    if( os.path.exists( name + '.pdb' ) ):
        return name + '.pdb'
    if( os.path.exists( name + '.pdb.gz' ) ):
        return name + '.pdb.gz'
    if( os.path.exists( name + '.pdb1.gz' ) ):
        return name + '.pdb1.gz'
    name = name.upper()
    if( os.path.exists( name ) ):
        return name
    if( os.path.exists( name + '.pdb' ) ):
        return name + '.pdb'
    if( os.path.exists( name + '.pdb.gz' ) ):
        return name + '.pdb.gz'
    if( os.path.exists( name + '.pdb1.gz' ) ):
        return name + '.pdb1.gz'
    # No acceptable file found
    return None


def open_pdb( name ):
    '''Open the PDB given in the filename (or equivalent).
    If the file is not found, then try downloading it from the internet.

    Returns: (lines, filePrefix)
    '''
    filename = get_pdb_filename( name )
    if filename is not None:
        print "Found existing PDB file at", filename
    else:
        #print "File for %s doesn't exist, downloading from internet." % (name)
        #filename = download_pdb(name[0:4].upper(), '.')
        #global files_to_unlink
        #files_to_unlink.append(filename)
        print "File for %s doesn't exist, exit." % (name)
        exit(-1)

    stem = os.path.basename(filename)
    
    if stem[-3:] == '.gz':
        stem = stem[:-3]
    if stem[-5:] == '.pdb1':
        stem = stem[:-5]
    if stem[-4:] == '.pdb':
        stem = stem[:-4]

    if filename[-3:] == '.gz':
        lines = popen('zcat '+filename, 'r').readlines()
    else:
        lines = open(filename, 'r').readlines()

    return lines, stem

#############################################
# Program Start
#############################################


# parser = argparse.ArgumentParser(usage="% prog [options] <pdb> <chain id>",
        # description=)
parser = argparse.ArgumentParser(description="% prog [options] <pdb> <chain id>" )
parser.add_argument("--nopdbout", action="store_true",
        help="Don't output a PDB.")
parser.add_argument("--allchains", action="store_true",
        help="Use all the chains from the input PDB.")
parser.add_argument("--removechain", action="store_true",
        help="Remove chain information from output PDB.")
parser.add_argument("--keepzeroocc", action="store_true",
        help="Keep zero occupancy atoms in output.")

parser.add_argument("pdbFile",metavar="pdbFile",help="Keep zero occupancy atoms in output.")
parser.add_argument("chainID",metavar="chainID",nargs="?",help="chainID",type=str)
#options, args = 
options = parser.parse_args()
print options
#print args


if options.chainID == None:
    options.allchains=True
    options.chainID=' '

files_to_unlink = []
chainID = options.chainID 
print options
print chainID






lines, filePrefix = open_pdb( options.pdbFile )
print filePrefix

oldresnum = '   '
count = 1

residue_buffer = []
residue_letter = ''

if chainID == '_':
    chainID = ' '

#ready to process pdb file
resRenameDict={}

for line in lines:

    if line.startswith('ENDMDL'): break  # Only take the first NMR model
    if len(line) > 21 and ( line[21] in chainID or options.allchains):
        if line[0:4] != "ATOM" and line[0:6] != 'HETATM':
            continue
        # keep templine for editing

        line_edit = line
        resn = line[17:20]

        # Is it a modified residue ?
        # (Looking for modified residues in both ATOM and HETATM records is deliberate)

        if modres.has_key(resn):
            # if so replace it with its canonical equivalent !
            orig_resn = resn
            resn = modres[resn]
            line_edit = 'ATOM  '+line[6:17]+ resn + line[20:]
            
            #print "MOD Residue detected %s"%(orig_resn)

            if orig_resn == "MSE":
                # don't count MSE as modified residues for flagging purposes (because they're so common)
                # Also, fix up the selenium atom naming
                if (line_edit[12:14] == 'SE'):
                    line_edit = line_edit[0:12]+'SD'+line_edit[14:]
                if len(line_edit) > 75:
                    if (line_edit[76:78] == 'SE'):
                        line_edit = line_edit[0:76]+' S'+line_edit[78:]
            else:
                shit_stat_modres = True
                if orig_resn not in longer_names.keys():
                    print "MOD Residue detected %s"%(orig_resn)

        # Only process residues we know are valid.
        if not longer_names.has_key(resn):
            continue

        resnum = line_edit[22:27]
        #print resnum

        # Is this a new residue
        # previous residue or new residue
        if not resnum == oldresnum:
            # residue_buffer contain previous residue
            # residue_letter = previous residue
            # An rename info should be kept at this stage.

            if residue_buffer != []:  # is there a residue in the buffer ?
                if not check_and_print_pdb(count, residue_buffer, residue_letter):
                    # if unsuccessful
                    shit_stat_misdns = True
                    print "shit_stat_misdns happen"

                else:
                    count = count + 1
                    resRenameDict[resNew]=resOrg

            # after process, clean residue buffer and assign residue letter to new residue

            residue_buffer = []
            residue_letter = longer_names[resn]

            resOrg = resn+"_"+line[21]+'_'+resnum.strip()
            resNew = resn+"_"+line[21]+'_'+str(count)

        
        # For same residue, check other issues:
        oldresnum = resnum

        # check insert residue?
        insres = line[26]
        #print insres
        if insres != ' ':
            shit_stat_insres = True

        # check alternative positions
        # only keep A position
        altpos = line[16]
        if altpos != ' ':
            shit_stat_altpos = True
            if altpos == 'A':
                line_edit = line_edit[:16]+' '+line_edit[17:]
            else:
                # Don't take the second and following alternate locations
                continue

        if options.removechain:
            line_edit = line_edit[:21]+' '+line_edit[22:]

        if options.keepzeroocc:
            line_edit = line_edit[:55] +" 1.00"+ line_edit[60:]

        # put this line into residue_buffer 
        # when it is a new residue, the residue buffer will be processed.
        residue_buffer.append(line_edit)

print "finish status process"
print len(resRenameDict)

if residue_buffer != []: # is there a residue in the buffer ?
    if not check_and_print_pdb(count, residue_buffer, residue_letter):
        # if unsuccessful
        shit_stat_misdns = True
    else:
        count = count + 1
        resRenameDict[resNew]=resOrg
print len(resRenameDict)
flag_altpos = "---"

if shit_stat_altpos:
    flag_altpos = "ALT"
flag_insres = "---"

if shit_stat_insres:
    flag_insres = "INS"
flag_modres = "---"
if shit_stat_modres:
    flag_modres = "MOD"
flag_misdns = "---"
if shit_stat_misdns:
    flag_misdns = "DNS"

nres = len("".join(fastaseq.values()))

flag_successful = "OK"
if nres <= 0:
    flag_successful = "BAD"

#if chainid == ' ':
#   chainid = '_'

if chainID == ' ':
   chainID = '_'


print filePrefix, "".join(chainID), "%5d" % nres, flag_altpos,  flag_insres,  flag_modres,  flag_misdns, flag_successful

with open("renumber_protein.csv",'w') as fh:
    fh.write("resid,resCavID\n")
    for key in resRenameDict.keys():
        tempLine = "%s,%s\n"%(key,resRenameDict[key])
        fh.write(tempLine)

#exit(-1)
if nres > 0:
    if not options.nopdbout:
        # outfile = string.lower(pdbname[0:4]) + chainid + pdbname[4:]

        if chainID != '_':
            outfile = filePrefix + "_" + chainID + ".pdb"
        else:
            outfile = filePrefix + "_renumber.pdb"

        outid = open(outfile, 'w')
        outid.write(pdbfile)
        outid.write("TER\n")
        outid.close()

    fastaid = stdout
    if not options.allchains:
        for chain in fastaseq:
            fastaid.write('>'+filePrefix+"_"+chain+'\n')
            fastaid.write(fastaseq[chain])
            fastaid.write('\n')
            handle = open(filePrefix+"_"+"".join(chain) + ".fasta", 'w')
            handle.write('>'+filePrefix+"_"+"".join(chain)+'\n')
            handle.write(fastaseq[chain])
            handle.write('\n')
            handle.close()
    else:
        fastaseq = ["".join(fastaseq.values())]
        fastaid.write('>'+filePrefix+"_"+chainID+'\n')
        fastaid.writelines(fastaseq)
        fastaid.write('\n')
        handle = open(filePrefix+"_"+chainID + ".fasta", 'w')
        handle.write('>'+filePrefix+"_"+chainID+'\n')
        handle.writelines(fastaseq)
        handle.write('\n')
        handle.close()


if len(files_to_unlink) > 0:
    for file in files_to_unlink:
        os.unlink(file)
