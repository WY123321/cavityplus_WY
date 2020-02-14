import os,subprocess,sys,re,shutil,time,traceback
import errno,pickle
from glob import glob
import argparse

from ResEnv import *
from AminoAlphabet import *
import numpy as np
import pandas as pd 
#from xlsxwriter.utility import xl_rowcol_to_cell

def init_options():
	usage = "% prog -d cavityDir -p cavityPrefix -res CYS -ren renumberFile"
	
	parser=argparse.ArgumentParser(description=usage)
	
	parser.add_argument("-d","--cavityDir",dest="cavityDir",
		help="cavityDir",required = True)

	parser.add_argument("-p","--cavityPrefix",dest="cavityPrefix",
		help="cavity prefix for vacant and surface file ",
		default="protein",required = True)

	#parser.add_argument("-env",dest="envFile",
	#	help="number of processors",default="protein_rename_CYS_AA.csv",required = True)


	parser.add_argument("-res",dest="residue",
		help="residue name",default="CYS",required = False)

	parser.add_argument("-ren",dest="renumberFile",
		help="renumber File",default="renumber_protein.csv",required = False)

	return parser

options = init_options().parse_args()

print("hello 1")
def grep_cavity_detail(fileName):
	with open(fileName,'r') as fh:
		AllLines = fh.readlines()


	outListS=['Surface','Hydrophobic','Acceptor','Donor','Bind','Dep1']
	outListV=['Vacant','Hydrophobic','Acceptor','Donor','Bind','Dep2','Area','Step','pkdMax','pkdAve','drugScore']

	if re.search('surface',fileName):
		outList = outListS
	else:
		outList = outListV


	outDict = {}
	#for line in AllLines:
	for i in range(0,50):
		line = AllLines[i]
		for key in outList:
			if key=='Surface' or key == 'Vacant':
				searchKey = "Total %s num is ([0-9]+)"%(key)

			#print searchKey
			#print line
			elif key=='Step':
				searchKey = "Step (.+)"
			elif key=='pkdAve':
				searchKey = "Predict Average pKd:\s+(.+)"
			elif key=='pkdMax':
				searchKey = "Predict Maximal pKd:\s+(.+)"
			elif key=='drugScore':
				searchKey = "DrugScore :\s(.+)"
			else:
				searchKey = "%s\s+=\s(.+)"%(key)
			#print searchKey
			#print line
			if re.search(searchKey,line):
				reg = re.search(searchKey,line);
				outDict[key]=reg.group(1)

	if re.search('surface',fileName):
		outStr = "%s,%s,%s,%s,%s,%s"%(outDict['Surface'],outDict['Hydrophobic'],outDict['Acceptor'],outDict['Donor'],outDict['Bind'],outDict['Dep1'])
	else:
		#tempstr = ',',join(outDict['Step'].split('_'))
		tempstr = outDict['Step'].split('_')
		tempstr = ','.join(tempstr)
		#outStr = "%s,%s,%s,%s,%s,%s,%s,%s"%(outDict['Vacant'],outDict['Hydrophobic'],outDict['Acceptor'],outDict['Donor'],outDict['Bind'],outDict['Dep2'],outDict['Area'],tempstr)
		outStr = "%s,%s,%s,%s,%s,%s,%s,%s,%s,%s"%(outDict['Vacant'],outDict['Hydrophobic'],outDict['Acceptor'],
			outDict['Donor'],outDict['Bind'],outDict['Dep2'],outDict['Area'],
			outDict['pkdMax'],outDict['pkdAve'],outDict['drugScore'])
		#print outStr
	return outStr


cavDetailOutFile = 'cavity_details.csv'
fh = open(cavDetailOutFile,'w')
fileList = glob("%s/*_cavity_*.pdb"%(options.cavityDir))
orgPDBFile = "%s/%s.pdb"%(options.cavityDir,options.cavityPrefix)
#print fileList
headLine="cavityPDB,surfN,hbS,acceptorS,donorS,bindS,depS,comment,volN,hbV,acceptorV,donorV,bindV,depV,areaV,pkdMax,pkdAve,drugScore\n"
fh.write(headLine)
for fileName in fileList:
	#print fileName
	joinKey = os.path.basename(fileName)
	vData = grep_cavity_detail(re.sub('_cavity_','_vacant_',fileName))
	sData = grep_cavity_detail(re.sub('_cavity_','_surface_',fileName))
	tempstr = joinKey+','+sData+',o,'+vData
	#print joinKey
	#print tempstr
	fh.write(tempstr+'\n')
fh.close()




residue = options.residue

resListName = 'Cav_%s.csv'%(residue)
resListNameNone = 'Cav_%s_None.csv'%(residue)



cavEnvFile = "cavEnv.csv"
fh2 = open(cavEnvFile,'w')
propertyKey = ['ALA','VAL','GLU','GLN','ASP','ASN','CYS','LYS','ARG','SER','THR','TYR','TRP','ILE','LEU','GLY','HIS','PHE','PRO','MET']
propertyList = []
for i in range(1,5):
	prefix = 'ENV'+str(i)
	for j in range(len(propertyKey)):
		propertyList.append(prefix+'-'+propertyKey[j])
fh2.write('cavityPDB,resCavID,'+','.join(propertyList)+'\n')

cavResLineList = []
for fileName in fileList:
	#print fileName
	tempCav=[]
	with open(fileName,'r') as fh:
		for line in fh.readlines():
			if re.search(residue,line) and re.search('^ATOM',line):
				cavResLineList.append([os.path.basename(fileName),line])
		
			temparray=line
			if re.search('^ATOM',line):
				tempKey = temparray[17:20]+'_'+temparray[21]+'_'+temparray[22:26].strip()
				if tempKey not in tempCav:
					tempCav.append(tempKey)

	tempCavFile = 'tempCav.pdb'
	tempCavFH = open(tempCavFile,'w')
	with open(orgPDBFile,'r') as fh:
		for line in fh.readlines():
			temparray=line
			tempKey = temparray[17:20]+'_'+temparray[21]+'_'+temparray[22:26].strip()
			if re.search('^ATOM',line) and tempKey in tempCav:
				tempCavFH.write(line)
	tempCavFH.close()

	Protlist = CavityObj(tempCavFile)
	#Protlist = CavityObj(fileName)	
	Protlist.updateKeyRes(residue)
	outList = Protlist.outKeyResStr()
	#if re.search("protein_cavity_7.pdb",fileName):
	#	print "protein_cavity_7.pdb"
	#print outStr
	if len(outList)!=0:
		#print outList
		for outStr in outList:
			outStr = re.sub('  +',' ',outStr.strip()).split(' ')
			outStr = ','.join(outStr)
			outStr = "%s,%s"%(os.path.basename(fileName),outStr)
			fh2.write(outStr+'\n')
		#	print outStr
	#if re.search("protein_cavity_7.pdb",fileName):
	#	print "protein_cavity_7.pdb"
	#	exit(-1)
	#tempstr = "%s,%s,%s"%(proteinInfo,cavFile,outStr)
	#print tempstr
print("cav Env finished")
fh2.close()

#print cavResLineList
cavFH = open(resListName,'w')
cavNFH = open(resListNameNone,'w')
headLine = "resCavID,cavityPDB"
cavFH.write(headLine+'\n')

if len(cavResLineList)==0:
    print("No %s in side cavity or no cavity"%(residue))
    resultLine = "%s\t%s\t%s\t%d\n"%(pdbID,prefix,'None',len(fileList))
    cavNFH.write(resultLine)
    # this change is for previous code 
    # without loop over summaryList
    # os.chdir(topDir)


ResList = []
for tempItem in cavResLineList:
    # print templine
    # Parse each line
    # some continue will corrupt the cavityList
    if len(fileList)>0:
        cavityFile = tempItem[0]
        temparray = tempItem[1].strip()

        try:
            queryKey = temparray[17:20]+'_'+temparray[21]+'_'+temparray[22:26].strip()
            queryKey2 = queryKey+'-'+cavityFile
        except:
            print("index error")
            print(temparray)
            print(tempItem)
    else:
        resultLine = "%s %s %d\n"%(pdbID,'None',len(glob('*_cavity_*.pdb')))
        cavNFH.write(resultLine)
        break

    # check if it is new
    if queryKey2 not in ResList:
        ResList.append(queryKey2)
        # print CYSList
        #print pdbID,cavityFile,queryKey,index
        try:
            # resultLine = "%s%s %s %s\n"%(pdbID,queryKey,cavityFile,allCavity[index].strip())
            resultLine = "%s,%s\n"%(queryKey,cavityFile)
            #resultLine.replace('\t',' ')
        except:
            #print index,allCavity,pdbID
            exit(1)
        cavFH.write(resultLine)
    else:
        continue
cavFH.close()
cavNFH.close()

df1 = pd.read_csv(cavDetailOutFile)
df2 = pd.read_csv(resListName)
df3 = pd.read_csv(cavEnvFile)
# Join pka and env Data
temp = pd.merge(df2,df1,how='inner',on='cavityPDB')
df4 = pd.merge(temp,df3,how='left',on=['resCavID','cavityPDB'])
print(df4)
df4 = TotalRes(df4)
df4 = aaAlphabet('A-CV-D-E-FMWY-G-HR-IL-K-N-PQS-T','Tanaka',df4)
df4 = eachRes('A-C-D-E-N-Q-F-W-Y-G-H-I-L-M-V-K-R-P-S-T',df4)




df4['hbVR']=df4['hbV']/df4['volN']
df4['hDVR']=df4['donorV']/df4['volN']
df4['lipVR']=df4['areaV']/df4['volN']
print(df4)
df4.to_csv("cavityRes.csv",index=False)




