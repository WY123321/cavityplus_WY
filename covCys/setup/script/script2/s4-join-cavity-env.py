import os,subprocess,sys,re,shutil,time,traceback
import errno,pickle
from glob import glob
import argparse

#from ResEnv import *
#from AminoAlphabet import *
import numpy as np
import pandas as pd
from sklearn.externals import joblib 
# from xlsxwriter.utility import xl_rowcol_to_cell

def init_options():
	usage = "% prog -cav cavData -env envData -ren renumberFile"
	
	parser=argparse.ArgumentParser(description=usage)
	
	parser.add_argument("-cav","--cavityFile",dest="cavityFile",
		help="cavity data file",required = True)

	parser.add_argument("-env",dest="envFile",
		help="env data file",required = True)
	parser.add_argument("-ren",dest="renumberFile",
		help="renumber File",required = False,default="renumber_protein.csv")
	return parser

options = init_options().parse_args()


df1 = pd.read_csv(options.cavityFile)

df2 = pd.read_csv(options.envFile)
df3 = pd.read_csv(options.renumberFile)

resid = pd.DataFrame(df2.loc[:,'resid'])
resid2 = pd.merge(resid,df3,how='inner',on='resid')
resJoin = pd.merge(resid2,df1,how='left',on='resCavID')

pkaData = pd.DataFrame(df2.loc[:,['resid','pka','QSASA']])

resCav = resJoin.dropna(axis=0)
# resNot = resJoin[pd.isnull(resJoin['cavityPDB']),:]
# print resCav
# print pd.isnull(resJoin['cavityPDB'])
# print resJoin[pd.isnull(resCav)]
#print resJoin[pd.isnull(resJoin['cavityPDB'])]

resRaw = pd.merge(resJoin,pkaData,how="left",on="resid")


#print respKaError
#print resnoCav
pKaError=12
ttt = resRaw[pd.notnull(resRaw['cavityPDB'])]

respKaError = ttt[ttt['pka']>pKaError]
respKaError['Note']='pKa calculation failed'
respKaError['cov']='Not determined'

resnoCav = resRaw[pd.isnull(resRaw['cavityPDB'])]
resnoCav['Note']='Not in a cavity'
resnoCav['cov']='Not determined'
resnoCav['cavityPDB']='None'


ttt2 = ttt[ttt['pka']<pKaError]
ttt3 = ttt2.loc[:,['resid','resCavID','cavityPDB','ENV1-All','ENV2-All','ENV3-All','ENV4-All','hbVR','hDVR','lipVR','QSASA','pka','pkdAve']]
ttt4 = ttt2.loc[:,ttt2.columns.str.contains('Tanaka')]
forSVM = pd.merge(ttt3, ttt4, left_index=True, right_index=True, how='inner');
forSVM.to_csv("forSVM.csv",index=False)

#print resRaw
# print df3

##### Make Prediction Here ####### 
def runSVM(dframe):
	ttt1 = dframe.loc[:,['ENV1-All','ENV2-All','ENV3-All','ENV4-All','hbVR','hDVR','lipVR','QSASA','pka','pkdAve']]
	ttt2 = dframe.loc[:,forSVM.columns.str.contains('Tanaka')]
	df2 = pd.merge(ttt1, ttt2, left_index=True, right_index=True, how='inner')
	#print df2
	array = df2.values
	(nrow,ncol)=df2.shape	

	Xarray2=array[:,0:ncol]
	# filename = '..\svm-model\svm-model.sav'
	filename = '.\svm-model.sav'
	clf = joblib.load(filename)

	y_predict=clf.predict(Xarray2)
	ttt3 = dframe.loc[:,['resid','resCavID','cavityPDB']]
	ttt4 = pd.DataFrame(np.array(y_predict).reshape(-1,1),columns=['cov'])
	df3 = pd.merge(ttt3, ttt4, left_index=True, right_index=True, how='inner')

	return df3

svmResult = runSVM(forSVM)
print svmResult

svmResult['Note'] ='None'
eee1 = resnoCav.loc[:,['resid','resCavID','cavityPDB','cov','Note']]
eee2 = respKaError.loc[:,['resid','resCavID','cavityPDB','cov','Note']]
svmResult = svmResult.append([eee1,eee2])
print svmResult
svmResult.to_csv("svmResult.csv",index=False)

