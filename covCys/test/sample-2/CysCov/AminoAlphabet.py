import numpy as np
import pandas as pd 
import re
#from xlsxwriter.utility import xl_rowcol_to_cell

aaDict = {'A':'ALA','V':'VAL','E':'GLU','Q':'GLN','D':'ASP',
'N':'ASN','C':'CYS','K':'LYS','R':'ARG','S':'SER',
'T':'THR','Y':'TYR','W':'TRP','I':'ILE','L':'LEU',
'G':'GLY','H':'HIS','F':'PHE','P':'PRO','M':'MET'}

def aaAlphabet(pattern,prefix,df):
	cList=pattern.split('-')
	df2=df
	for index in range(0,len(cList)):
		#print index,cList[index]
		#print list(cList[index])
		for i in range(1,5):
			#print i
			attrAll='ENV%d-All'%(i)
			attr='ENV%d-%s%d'%(i,prefix,index+1)
			df2[attr]=0
			#print cList[index]
			for char in list(cList[index]):
				col='ENV%d-%s'%(i,aaDict.get(char))
				#print col
				df2[attr]=df2[attr]+df[col]
			df2[attr]=df2[attr]/df[attrAll]
			#df2['temp']=df2[attr]
			#df2[df2[attrAll]==0][attrAll]=31415926
			#f2.loc[df2[attrAll]==0,[attrAll]]=31415926
			#df2=df2.assign(temp=lambda df: df2[attr]/df[attrAll] if df[attrAll]
			#	!=0 else 0)
			#df2=df2.round({attr:2})		
	return df2

def TotalRes(df2):
	#df2 = df
	for i in range(1,5):
		attr='ENV%d-All'%(i)
		df2[attr]=0
		#print cList[index]
		for char in list(aaDict.keys()):
			col='ENV%d-%s'%(i,aaDict.get(char))
			#print col
			df2[attr]=df2[attr]+df2[col]

	return df2

def eachRes(pattern,df):
	cList=pattern.split('-')
	df2=df
	for AA in cList:
		#print index,cList[index]
		#print list(cList[index])
		for i in range(1,5):
			#print i
			attrAll='ENV%d-All'%(i)
			attr='ENV%d.%s'%(i,AA)
			df2[attr]=0
			#print cList[index]
			col='ENV%d-%s'%(i,aaDict.get(AA))
			df2[attr]=df2[col]/df[attrAll]
			#df2['temp']=df2[attr]
			#df2[df2[attrAll]==0][attrAll]=31415926
			#f2.loc[df2[attrAll]==0,[attrAll]]=31415926
			#df2=df2.assign(temp=lambda df: df2[attr]/df[attrAll] if df[attrAll]
			#	!=0 else 0)
			#df2=df2.round({attr:2})		
	return df2
if __name__=="__main__":
	print("hello")
	exit(0)
