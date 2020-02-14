import os,subprocess,sys,re,shutil,time,traceback
import errno,pickle
from glob import glob
import argparse

from ResEnv import *
from AminoAlphabet import *
import numpy as np
import pandas as pd 
from xlsxwriter.utility import xl_rowcol_to_cell


def init_options():
	usage = "% prog proteinFile"
	
	parser=argparse.ArgumentParser(description=usage)
	
	parser.add_argument("proteinFile",metavar="proteinFile",
		help="protein file to calculate propka2")
	return parser


options = init_options().parse_args()

stem = os.path.basename(options.proteinFile)
if stem[-4:] == '.pdb':
    stem = stem[:-4]

# Run propka2 for pKa	

#cmdline = "/lustre1/lhlai_pkuhpc/wlzhang/usr/local/bin/propka2.0.pl -i %s"%(options.proteinFile)
prefix = "propka2"
outname = "%s_%s.out"%(prefix,stem)   
#fh = open(outname,'w')
# # subprocess.Popen(cmdline,shell=True,stdout=fh,stderr=fh,close_fds=True).wait()
#subprocess.Popen(cmdline,shell=True,stdout=fh,stderr=fh).wait()
#fh.flush()
#time.sleep(1)
#fh.close()

outList = []
with open(outname,'r') as fh:
	readOut=False
	for line in fh.readlines():
		#print line
		#print re.search("SUMMARY OF THIS PREDICTION",line)
		if re.search("SUMMARY OF THIS PREDICTION",line):
			readOut=True
			#print readOut
		if readOut:
			if re.search("CYS",line):
				#print line
				outList.append(line.strip())	
			if re.search("Free energy of unfolding ",line):
				readOut=False
print(outList)
if len(outList)==0:
	#print "No %s in side cavity or no cavity %s %s"%(residue,pdbID,prefix)
	print("No %s in side cavity or no cavity.")
#for templine in stdout.strip().split('\n'):
pKaFile = "pka_CYS_%s.csv"%(stem)
pKaFH = open(pKaFile,'w')
headLine = "resid,pka,pka-model"
pKaFH.write(headLine+'\n')
for templine in outList:

	temparray = templine.split()
	# if len(temparray)==5:
	# 	newIndex = temparray[1]
	# 	newKey = "%s_%s_%s"%(residue,chainID,newIndex)
	# 	resultLine = "%s %s %s %s\n"%(pdbID,newKey,temparray[3],temparray[4])
	# else: 	 
	# 	#print templine
	# 	#print temparray
	match=re.search("([0-9]+)([A-Z])",temparray[1])
	newIndex=match.group(1)
	chainID=match.group(2)
	#print newIndex 

	newKey = "CYS_%s_%s"%(chainID,newIndex)
	#print newKey
	resultLine = "%s,%s,%s\n"%(newKey,temparray[2],temparray[3])
	pKaFH.write(resultLine)
pKaFH.close()
pKaDf = pd.read_csv(pKaFile)
print(pKaDf)


# Run pops for pops.out
#os.unlink('pops.out')
cmd = "pops --pdb %s --residueOut --noHeaderOut --noTotalOut " %(options.proteinFile)
print(cmd)
with open('errPOP.err','w') as errFH:
	subprocess.Popen(cmd,shell=True,stdout = errFH,stderr = errFH).wait()


# Generate ENV data
KEYRES = 'CYS'
Protlist = ProtResList(options.proteinFile)
EnvDataFile = "%s_%s.csv"%(stem,KEYRES)

Protlist.updateKeyRes(KEYRES)
Protlist.outKeyRes(EnvDataFile)

# Generate AA data
df = pd.read_csv(EnvDataFile)
df2 = df
df2 = TotalRes(df2)
df2 = aaAlphabet('A-CV-D-E-FMWY-G-HR-IL-K-N-PQS-T','Tanaka',df2)
df2 = eachRes('A-C-D-E-N-Q-F-W-Y-G-H-I-L-M-V-K-R-P-S-T',df2)
#df2.to_csv("%s_%s_AA.csv"%(stem,KEYRES),index=False)

# Join pka and env Data
df3 = pd.merge(pKaDf,df2,how='inner',on='resid')
print(df3)
df3.to_csv("%s_%s_AA.csv"%(stem,KEYRES),index=False)
# Grep Cavity Data
# This should be in different script as rename is needed there
# Join All Data


