import os,sys,shutil,subprocess,re
import errno
from glob import glob
import sys

proteinFile = sys.argv[1]
cavityPath = sys.argv[2]

workDir = "CysCov"
#scriptDir = "../../script"
scriptDir = "/work01/home/yjxu/covCys/script"



try:
	os.makedirs(workDir)
except OSError as exc: # Python >2.5 (except OSError, exc: for Python <2.5)
	if exc.errno == errno.EEXIST and os.path.isdir(workDir):
		pass
	else: raise

topDir = os.getcwd()
if re.match('^\.',cavityPath):
	cavityPath = os.path.join(topDir,cavityPath)
	print(cavityPath)
	# print "hello"
	# exit(0)
proteinPath = "%s/%s"%(cavityPath,proteinFile)
stem = proteinFile[:-4]

os.chdir(workDir)

if os.path.isfile('./pops.out'):
	print("WARNING: pops.out is already here. Check s2-process-protein.py for pops path")

if os.path.isfile('./propka2_protein_renumber.out'):
	print("WARNING: propka2_protein_renumber.out is already here. Check s2-process-protein.py for propka2 path")

if os.path.isfile('./renumber_protein_CYS_AA.csv'):
	print("WARNING: renumber_protein_CYS_AA.csv is already here. Check s2-process-protein.py for module prody")

if os.path.isfile('./cavityRes.csv'):
	print("WARNING: cavityRes.csv is already here. Check s2-process-protein.py for module prody")

if os.path.isdir('./cavity'):
	print("WARNING: a precomputed cavity dir is here. Check s3-grep-cavityInfo.py for cavity process")


cleanPython = False
if cleanPython:
	for filePath in glob("./*.py"):
		try:
			print(filePath)
			os.unlink(filePath)
		except Exception as e:
			pass
	#os.unlink("./svm-model.sav")

for filePath in glob("%s/*.py"%(scriptDir)):
	print(filePath)
	shutil.copy(filePath,".")
shutil.copy("%s/svm-model.sav"%(scriptDir),".")

# try:
# 	os.unlink('renumber_protein.csv')
# except Exception,e:
# 	print "no renumber_protein.csv here"

### Step 1 clean protein for renumber ####

cmd = "python s1-clean_pdb.py %s"%(proteinPath)
print(cmd)
with open('s1.err','w') as errFH:
	subprocess.Popen(cmd,shell=True,stdout = errFH,stderr = errFH).wait()

if not os.path.isfile('renumber_protein.csv'):
	print("error renumber_protein.csv should be generted in s1 step")
	exit(-1)
##########################################


### Step 2 propKa, pops, #####################
cmd = "python s2-process-protein.py %s_renumber.pdb"%(stem)
print(cmd)
with open('s2.err','w') as errFH:
	subprocess.Popen(cmd,shell=True,stdout = errFH,stderr = errFH).wait()

with open('s2.err','r') as fh:
	for line in fh.readlines():
		if re.search('ImportError: No module named prody',line):
			print("ImportError: No module named prody")

if not os.path.isfile('%s_renumber_CYS_AA.csv'%(stem)):
	print("error %s_renumber_CYS_AA.csv should be generted in s2 step"%(stem))

### Step 3 grep cavity information and cavity based env-data #####################

cmd = "	python s3-grep-cavityInfo.py -d %s -p %s "%(cavityPath,stem)
print(cmd)
with open('s3.err','w') as errFH:
	subprocess.Popen(cmd,shell=True,stdout = errFH,stderr = errFH).wait()

with open('s3.err','r') as fh:
	for line in fh.readlines():
		if re.search('ImportError: No module named prody',line):
			print("ImportError: No module named prody")

if not os.path.isfile('cavityRes.csv'):
 	print("error cavityRes.csv should be generted in s3 step")

### Step 4 run svm prediction #####################

cmd = "	python s4-join-cavity-env.py -cav cavityRes.csv -env %s_renumber_CYS_AA.csv -ren renumber_protein.csv"%(stem)
print(cmd)
with open('s4.err','w') as errFH:
	subprocess.Popen(cmd,shell=True,stdout = errFH,stderr = errFH).wait()

with open('s4.err','r') as fh:
	for line in fh.readlines():
		if re.search('from .classes import SVC, NuSVC, SVR, NuSVR, OneClassSVM, LinearSVC',line):
			print("sklearn module error")

if not os.path.isfile('svmResult.csv'):
 	print("error svmResult.csv should be generted in s4 step")
else:
	os.unlink("svm-model.sav")
	print("finished calculation")

os.chdir(topDir)
