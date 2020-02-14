from prody import *
import sys,os,subprocess,re
import  numpy as np
#import wlutil
RESLIST = ['ALA','VAL','GLU','GLN','ASP','ASN','CYS','LYS',
'ARG','SER','THR','TYR','TRP','ILE','LEU','GLY','HIS','PHE','PRO','MET']
QUERYLIST = ['polar','neutral','charged','large','medium','small','acidic','basic','hydrophobic','aromatic']

DISTLIST = {'ENV1':4.0,'ENV2':6.0,'ENV3':8.0,'ENV4':10.0}
DENVLIST = {'DENV1':['ENV1','ENV2'],'DENV2':['ENV2','ENV3'],'DENV3':['ENV3','ENV4']}
# ENV:1,2,3,4: 4,6,8,10
# if dynamic will be meta program

def cmp_to_key(mycmp):
    'Convert a cmp= function into a key= function'
    class K:
        def __init__(self, obj, *args):
            self.obj = obj
        def __lt__(self, other):
            return mycmp(self.obj, other.obj) < 0
        def __gt__(self, other):
            return mycmp(self.obj, other.obj) > 0
        def __eq__(self, other):
            return mycmp(self.obj, other.obj) == 0
        def __le__(self, other):
            return mycmp(self.obj, other.obj) <= 0
        def __ge__(self, other):
            return mycmp(self.obj, other.obj) >= 0
        def __ne__(self, other):
            return mycmp(self.obj, other.obj) != 0
    return K

class ProtResList(object):
    # A list of potential residues
    def __init__(self,proteinFile):
        self.checkRes = []
        self.NoKeyRes = False
        self.BadPDB = False
        self.BadReason = ""
        self.noChain = False

        self.proteinFile = None
        self.protein = None
        self.popsResidues = {}
        self.keyResidues = {}
        #self.proteinFile = proteinFile
        try:
            self.protein = parsePDB(proteinFile)
            self.proteinFile = proteinFile
        except Exception as e:
            self.BadPDB = True
            self.BadReason = "%s"%(e)
            return 

        # clean nonstd aa has been done by clean_pdb.py

        nostdaa = self.protein.select('protein and nonstdaa')
        if  nostdaa != None:
            self.BadPDB = True
            tempstr = ""
            for nostd in set(nostdaa.getResnames()):
                tempstr = "%s %s" %(tempstr,nostd)
            self.BadReason = "Non std Residue %s" %(tempstr)

        if not self.BadPDB:

            # for pdb file without protein chain
            chainSet = list(set(self.protein.getChids()))
            if chainSet[0]==' ':
                chainSet = np.array(['A' for i in range(self.protein.numAtoms())])
                self.protein.setChids(chainSet)

            self.updatePops()

    def updatePops(self):
        try:
            # #os.unlink('pops.out')
            # cmd = "pops --pdb %s --residueOut --noHeaderOut --noTotalOut " %(self.proteinFile)
            # print cmd
            # with open('errPOP.err','w') as errFH:
            #     subprocess.Popen(cmd,shell=True,stdout = errFH,stderr = errFH).wait()

            with open('pops.out','r') as fh:
                allLines = fh.readlines()
        except Exception as e:
            self.BadPDB = True
            print(e)
            return -1

        for line in allLines:
            tempList = line.strip().split()
            tempkey = "%s_%s_%s"%(tempList[0],tempList[1],tempList[2])
            self.popsResidues[tempkey] = popsResidue(tempkey,tempList)


    def getPopRes(self,resid):
        # return a popResidue from popResidue dict by use resid
        return self.popsResidues[resid]

    def getKeyRes(self,resid):
        return self.keyResidues[resid]

    def updateKeyRes(self,keyresname):
        # refactor working process:
        # updateKeyRes with KeyRes parameter, do one key res at a time
        # out put result to certain directory
        # clean keyResidues for each key Residue

        self.keyResidues = {}
        self.NoKeyRes = False

        resname = keyresname

        querystr = "resname %s"%(resname)
        #print querystr
        resAtoms = self.protein.select(querystr)
        # if protein do not have certain Key residue, add a tag and skip the
        # following step
        if resAtoms == None:
         self.NoKeyRes = True
         return 0
        else:
         self.NoKeyRes = False

        #resIDList = self.createResID(resAtoms)
        #QueryrootList = self.createQueryroot(resAtoms)

        resQueryRootDict = self.createResQueryRoot(resAtoms)
        for resID in list(resQueryRootDict.keys()):

         #for i in range(len(resIDList)):
            #resID = resIDList[i]
            #queryroot = QueryrootList[i]
            queryroot = resQueryRootDict[resID]
            self.keyResidues[resID] = keyResidue(self,resID,self.getPopRes(resID).poplist)
            # At this step: it used to be pops could not be generted due to conformation effect
            # it has been solved by try pops twice.
            self.getKeyRes(resID).setQueryroot(queryroot)
            self.getKeyRes(resID).setQuerys(DISTLIST)
        self.searchEnv()


    
    def createResQueryRoot(self,resAtoms):
        resIDList=[]
        resQueryRootDict={}
        resnameList = resAtoms.getResnames()
        resnumList = resAtoms.getResnums()
        chainidList = resAtoms.getChids()

        for i in range(resAtoms.numAtoms()):
            resID = "%s_%s_%s" %(resnameList[i],chainidList[i],resnumList[i])
            if resID not in resIDList:
                resIDList.append(resID)
                resQueryRootDict[resID] =  "chain %s resnum %d" %(chainidList[i],resnumList[i])
        return resQueryRootDict

    def createResID(self, resAtoms):
        resIDList=[]
        resQueryRootDict={}
        resnameList = resAtoms.getResnames()
        resnumList = resAtoms.getResnums()
        chainidList = resAtoms.getChids()
        for i in range(resAtoms.numAtoms()):
            resID = "%s_%s_%s" %(resnameList[i],chainidList[i],resnumList[i])
            resIDList.append(resID)
        return resIDList

    def createResQueryRoot(self,resAtoms):
        resIDList=[]
        resQueryRootDict={}
        resnameList = resAtoms.getResnames()
        resnumList = resAtoms.getResnums()
        chainidList = resAtoms.getChids()

        for i in range(resAtoms.numAtoms()):
            resID = "%s_%s_%s" %(resnameList[i],chainidList[i],resnumList[i])
            if resID not in resIDList:
                resIDList.append(resID)
                resQueryRootDict[resID] =  "chain %s resnum %d" %(chainidList[i],resnumList[i])
        return resQueryRootDict



    def searchEnv(self):
        # If this is called by updateKeyRes. not need to check self.NoKeyRes??
        if self.NoKeyRes == True:
            return 0
        for resid in list(self.keyResidues.keys()):
            keyresidue = self.getKeyRes(resid)
            #print "keyresidue resid %s "%(resid)
            for env in list(DISTLIST.keys()):
                keyresidue.updateENV(self.protein,env)

            for denv in list(DENVLIST.keys()):
                envlist = DENVLIST[denv]
                keyresidue.updateDENV(denv,envlist)


    def sortKeyRes(self,item1,item2):
        # customerized sorting function for 
        # sorting keyresidues
        i1 = item1.split('_')
        i2 = item2.split('_')
       	return int(i1[2])-int(i2[2]) 
	#return cmp(int(i1[2]),int(i2[2]))

    def outKeyRes(self,dataFile):
        if self.NoKeyRes == True:
            return 0 
        fh=open(dataFile,'w')

        tempstr = "%-10s %4s %4s %5s" %(
                "resid",
                "SASA","Surf","QSASA")

  #      SASA Surf QSASA ENV1-SASA ENV1-Surf ENV1-QSASA ENV1-polar ENV1-neutral ENV1-charged 
        # tempstr = " %7d %7d %5.2f %s" %(int(currattr['Envsasa']),int(currattr['EnvTotal']),currattr['EnvQsasa'],tempstr)
        OUTLIST = sorted(DISTLIST.keys()) + sorted(DENVLIST.keys())
        #print OUTLIST
        for index in range(len(OUTLIST)):
            env = OUTLIST[index]
            #print env
            tempstr2 = ''
            if re.search('^ENV',env):
                tempstr2 = " %7s %7s %5s " %(env+'-SASA',env+'-Surf',env+'-QSASA')
            #for query in QUERYLIST:
            #    tempstr2 = "%s %12s " %(tempstr2,env+'-'+query)
                #print tempstr
            for residue in RESLIST:
                #print residue
                tempstr2 = "%s %12s " %(tempstr2,env+'-'+residue)
            #print tempstr2
            tempstr = "%s %s "%(tempstr,tempstr2)
            #print tempstr
        tempstr=re.sub(' +',',',tempstr.strip())
        fh.write(tempstr+"\n")

        # for resid in self.keyResidues.keys():
        #for resid in sorted(list(self.keyResidues.keys()),cmp=self.sortKeyRes):
        
        for resid in sorted(list(self.keyResidues.keys()),key=cmp_to_key(self.sortKeyRes)):
            keyresidue = self.getKeyRes(resid)
            #print "keyresidue resid %s "%(resid)
            #print sorted(DISTLIST.keys())
            # tempstr = "%4s %3s %4s %4s %-10s %4d %4d %5.2f" %(
            #     self.pdbID,keyresidue.chainid,keyresidue.Resname,keyresidue.ResNum,
            #     resid,
            #     keyresidue.SASA,keyresidue.Surf,keyresidue.Qsasa)
            tempstr = "%-10s %4d %4d %5.2f" %(
             resid,
             keyresidue.SASA,keyresidue.Surf,keyresidue.Qsasa)

            OUTLIST = sorted(DISTLIST.keys()) + sorted(DENVLIST.keys())
            for index in range(len(OUTLIST)):
                env = OUTLIST[index]
                # print "hello %s" %(env)
                tempstr = "%s %s" %(tempstr,keyresidue.outENV(env))
                #print tempstr
            tempstr="%s\n"%(tempstr)
            tempstr=re.sub(' +',',',tempstr)
            fh.write(tempstr)
        fh.close()

     #def breakprint(self,obj):
     #   print(obj)
     #   exit(0)


class popsResidue(object):

    def __init__(self,resid,poplist):
        self.resid = resid
        self.poplist = poplist
        #print poplist[0]
        if poplist[0] not in RESLIST:
            print("Warning not recognized residue %s"%(poplist[0]))
            print("Warning not recognized residue %s chainid %s resindes %s"%(poplist[0],poplist[1],poplist[2]))
        else:
            self.Resname = poplist[0]
            self.chainid = poplist[1]
            self.Resindex = int(poplist[2])
            #self.ResNum = int(poplist[-1])
    
            # POPS may out put a residue's total surface as zero
            # simply add a try except for this problem
            try:
                
                self.Phob = float(poplist[3])
                self.Phil = float(poplist[4])
                self.SASA = float(poplist[5])
                self.Qsasa = float(poplist[6])    
                self.Surf = float(poplist[8])
            except ValueError:
                self.Phob = 0.0
                self.Phil = 0.0
                self.SASA = 0.0
                self.Qsasa = 0.0    
                self.Surf = 0.0
                self.Qsasa = 1

        
class keyResidue(popsResidue):

    # Env4 = {}
    # Env6 = {}
    # Env8 = {}
    # Env10 = {}
    # 
    # querystr # dynamic or static?
    # query2 = "same residue as exwithin 4 of %s"%query1[0]
    #    envAtoms = protein.select(query2).copy()
    #    print envAtoms.getNames()
    #        print envAtoms.getResnums()
    #    print envAtoms.getChids()
    def __init__(self,protResList,resid,poplist):
        self.ENV1 = {}
        self.ENV2 = {}
        self.ENV3 = {}
        self.ENV4 = {}
        self.DENV1 = {}
        self.DENV2 = {}
        self.DENV3 = {}

        self.protResList = protResList

        super(keyResidue,self).__init__(resid,poplist)


    def setQueryroot(self,querystr):
        self.queryroot = querystr

    def setQuerys(self,distdict):

        for key in list(distdict.keys()):
            currattr=getattr(self,key,None)
            #print getattr(self,'eee',None)
            #print currattr,key
            if currattr != None:
                currattr['distance'] = distdict[key]
                querystr="same residue as exwithin %2.1f of %s and protein and not resname HET"%(distdict[key],self.queryroot)
                currattr['querystr'] = querystr
            #setattr(self,i,{'querystr':querystr})

    def updateENV(self,protein,dictkey):
        currattr = getattr(self,dictkey,None)
        if currattr != None:
            #print currattr
            currattr['hello'] = 'world'
            query2 = currattr['querystr']
            envAtoms = protein.select(query2).copy()
            # envAtoms, do we have nonstd residues?
            # we may do it even early for the entire structure.
            #print "query2 is %s" %query2
            
            #for query in QUERYLIST:
            #    currattr[query] = self.numofProp(envAtoms,query)

            for residue in RESLIST:
                 querystr = "resname %s"%residue
                 #print querystr
                 currattr[residue] = self.numofProp(envAtoms,querystr)
            [currattr['Envsasa'],currattr['EnvTotal'],currattr['EnvQsasa']] = self.computeSASA(envAtoms)
    def outENV(self,dictkey):
        currattr = getattr(self,dictkey,None)
        tempstr = ''
        #print dictkey
        if currattr != None:
            #for query in QUERYLIST:
            #    tempstr = "%s %2d" %(tempstr,currattr[query])
                #print tempstr
            for residue in RESLIST:
                #print residue
                tempstr = "%s %2d" %(tempstr,currattr[residue])
                 #print tempstr
        if re.search('^ENV',dictkey):
                tempstr = " %7d %7d %5.2f %s" %(int(currattr['Envsasa']),int(currattr['EnvTotal']),currattr['EnvQsasa'],tempstr)
                #print tempstr
        return tempstr

    def numofProp(self,envAtoms,string):
        # print string
        tempSele = envAtoms.select(string)
        if  tempSele != None:
            return tempSele.getHierView().numResidues()
        else:
            return 0

    def computeSASA(self,envAtoms):
        resIDList = self.protResList.createResID(envAtoms)
        sasa = 0.0
        total = 0.0
        qsasa = 0.0
        # for key in self.popResList.popResidues.keys():
        #     print key
        for resid in resIDList:
            # key residue env may contain non std residues
            # how to deal with such situation?
            # it may be better to deal it earlier when envAtoms are generated
            # envAtoms, do we have nonstd residues?
            # we may do it even early for the entire structure.
            sasa += self.protResList.getPopRes(resid).SASA
            #print resid
            total += self.protResList.getPopRes(resid).Surf
        qsasa = sasa/total
            #print "hello"
        # print qsasa
        # print sasa
        # print envAtoms.getResnums()
        #print ddd
        return [sasa,total,qsasa]

    def updateDENV(self,dictkey,envlist):
        currattr = getattr(self,dictkey,None)
        enva = getattr(self,envlist[0])
        envb = getattr(self,envlist[1])
        if currattr != None:
            #for query in QUERYLIST:
            #    currattr[query] = envb[query] - enva[query]
            for residue in RESLIST:
                currattr[residue] = envb[residue] - enva[residue]






class PotResCavity(ProtResList):
    def __init__(self,proteinFile):
        self.checkRes = []
        self.NoKeyRes = False
        self.BadPDB = False
        self.BadReason = ""
        self.noChain = False
        self.orgResnumList = []
        self.protein = None
        self.DISTLIST = {'CEN1':4.0,'CEN2':6.0,'CEN3':8.0,'CEN4':10.0}
        self.DENVLIST = {'CDE1':['CEN1','CEN2'],'CDE2':['CEN2','CEN3'],'CEN3':['CEN3','CEN4']}
        #self.proteinFile = proteinFile
        try:
            self.protein = parsePDB(proteinFile)
        except Exception as e:
            self.BadPDB = True
            self.BadReason = "%s"%(e)
            return 
        #self.fixResnum()

        print(self.orgResnumList)
        print(self.protein.getResindices())

        

        # clean nonstd aa
        if self.protein.select('resname MSE') != None:
            mse = self.protein.select('resname MSE')
            for atom in mse.iterAtoms():
                if atom.getName() == 'SE':
                    atom.setName('SD')            
                    atom.setElement('S')
                    #print "hello"
            het = np.zeros(mse.numAtoms(),dtype = bool)
            mse.setFlags('hetatm',het)
            mse.setResnames('MET')

        nostdaa = self.protein.select('protein and nonstdaa')
        if  nostdaa != None:
            self.BadPDB = True
            tempstr = ""
            for nostd in set(nostdaa.getResnames()):
                tempstr = "%s %s" %(tempstr,nostd)
            self.BadReason = "Non std Residue %s"%(tempstr)
        

        if not self.BadPDB:
            self.popResidues = {}
            self.keyResidues = {}


    def updateKeyRes(self,keyresname):
        # refactor working process:
        # updateKeyRes with KeyRes parameter, do one key res at a time
        # out put result to certain directory
        # clean keyResidues for each key Residue

        self.keyResidues = {}
        self.NoKeyRes = False

        resname = keyresname.split('_')

        querystr = "resname %s"%(resname)
        querystr = "resnum %s"%(resname[2])

        print(querystr)

        resAtoms = self.protein.select(querystr)
         #print resAtoms
         
        # if protein do not have certain Key residue, add a tag and skip the
        # following step
        if resAtoms == None:
            self.NoKeyRes = True
            return 0
        else:
            self.NoKeyRes = False

        resIDList = self.createResID(resAtoms)

        QueryrootList = self.createQueryroot(resAtoms)
        # self.breakprint(QueryrootList)
        for i in range(len(resIDList)):
            resID = resIDList[i]
            queryroot = QueryrootList[i]
            self.keyResidues[resID] = cavResidue(self,resID,[])
            # At this step: it used to be pops could not be generted due to conformation effect
            # it has been solved by try pops twice.
            self.getKeyRes(resID).setQueryroot(queryroot)
            self.getKeyRes(resID).setQuerys(self.DISTLIST)
        self.searchEnv()

    def searchEnv(self):
    # If this is called by updateKeyRes. not need to check self.NoKeyRes??
        if self.NoKeyRes == True:
            return 0
        for resid in list(self.keyResidues.keys()):
            keyresidue = self.getKeyRes(resid)
            #print "keyresidue resid %s "%(resid)
            for env in list(self.DISTLIST.keys()):
                keyresidue.updateENV(self.protein,env)

            for denv in list(self.DENVLIST.keys()):
                envlist = self.DENVLIST[denv]
                keyresidue.updateDENV(denv,envlist)

    def outKeyRes(self,dataFile):
        if self.NoKeyRes == True:
            return 0 
        fh=open(dataFile,'w')

        # for resid in self.keyResidues.keys():
        for resid in sorted(list(self.keyResidues.keys()),key=cmp_to_key(self.sortKeyRes)):
            keyresidue = self.getKeyRes(resid)
            #print "keyresidue resid %s "%(resid)
            #print sorted(DISTLIST.keys())
            # tempstr = "%4s %3s %4s %4s %-10s %4d %4d %5.2f"%(
            #     self.pdbID,keyresidue.chainid,keyresidue.Resname,keyresidue.ResNum,
            #     resid,
            #     keyresidue.SASA,keyresidue.Surf,keyresidue.Qsasa)
            tempstr = "%-10s "%(resid)
             
            OUTLIST = sorted(self.DISTLIST.keys()) + sorted(self.DENVLIST.keys())

            for index in range(len(OUTLIST)):
                env = OUTLIST[index]
                # print "hello %s"%(env)
                tempstr = "%s %s"%(tempstr,keyresidue.outENV(env))
                #print tempstr
            tempstr="%s\n"%(tempstr)
            fh.write(tempstr)
        fh.close()


class cavResidue(object):

    def __init__(self,popResList,resid,poplist):
        self.ENV1 = {}
        self.ENV2 = {}
        self.ENV3 = {}
        self.ENV4 = {}

        # self.CEN1 = {}
        # self.CEN2 = {}
        # self.CEN3 = {}
        # self.CEN4 = {}

        #self.CDE1 = {}
        #self.CDE2 = {}
        #self.CDE3 = {}
        self.popResList = popResList
        self.DISTLIST = {'CEN1':4.0,'CEN2':6.0,'CEN3':8.0,'CEN4':10.0}
        #self.DENVLIST = {'CDE1':['CEN1','CEN2'],'CDE2':['CEN2','CEN3'],'CEN3':['CEN3','CEN4']}

        #super(cavResidue,self).__init__(resid,poplist)
    def setQueryroot(self,querystr):
        self.queryroot = querystr
        print(querystr)
    def setQuerys(self,distdict):
        for i in list(distdict.keys()):
            currattr=getattr(self,i,None)
            #print "setQuerys"
            #print currattr,i
            if currattr != None:
                #print currattr,i
                currattr['distance'] = distdict[i]
                querystr="same residue as exwithin %2.1f of %s and protein and not resname HET"%(distdict[i],self.queryroot)
                currattr['querystr'] = querystr
            #setattr(self,i,{'querystr':querystr})

    def updateENV(self,protein,dictkey):
        currattr = getattr(self,dictkey,None)
        if currattr != None:
            #print currattr,dictkey
            currattr['hello'] = 'world'
            query2 = currattr['querystr']
            #print query2
            envAtoms = protein.select(query2).copy()
            # envAtoms, do we have nonstd residues?
            # we may do it even early for the entire structure.
            #print "query2 is %s" %query2
            #for query in QUERYLIST:
            #    currattr[query] = self.numofProp(envAtoms,query)

            for residue in RESLIST:
                querystr = "resname %s"%(residue)
                #print querystr
                currattr[residue] = self.numofProp(envAtoms,querystr)
                #print dictkey
                #print currattr[residue]
            #[currattr['Envsasa'],currattr['EnvTotal'],currattr['EnvQsasa']] = self.computeSASA(envAtoms)
    def outENV(self,dictkey):
        currattr = getattr(self,dictkey,None)
        tempstr = ''
        #print dictkey,currattr
        if currattr != None:
            #for query in QUERYLIST:
            #    tempstr = "%s %2d" %(tempstr,currattr[query])
            #    #print tempstr
            for residue in RESLIST:
                #print residue
                tempstr = "%s %2d" %(tempstr,currattr[residue])
                 #print tempstr
        #if re.search('^ENV',dictkey):
        #        tempstr = " %7d %7d %5.2f %s" %(int(currattr['Envsasa']),int(currattr['EnvTotal']),currattr['EnvQsasa'],tempstr)
                #print tempstr
        return tempstr

    def numofProp(self,envAtoms,string):
        # print string
        tempSele = envAtoms.select(string)
        if  tempSele != None:
            return tempSele.getHierView().numResidues()
        else:
            return 0


    def updateDENV(self,dictkey,envlist):
        currattr = getattr(self,dictkey,None)
        enva = getattr(self,envlist[0])
        envb = getattr(self,envlist[1])
        if currattr != None:
            #for query in self.QUERYLIST:
            #    currattr[query] = envb[query] - enva[query]
            for residue in RESLIST:
                currattr[residue] = envb[residue] - enva[residue]



class CavityObj(ProtResList):
    def __init__(self,proteinFile):
        self.checkRes = []
        self.NoKeyRes = False
        self.BadPDB = False
        self.BadReason = ""
        self.noChain = False
        self.orgResnumList = []
        self.protein = None
        self.DISTLIST = {'ENV1':4.0,'ENV2':6.0,'ENV3':8.0,'ENV4':10.0}    
        #self.DENVLIST = {'CDE1':['CEN1','CEN2'],'CDE2':['CEN2','CEN3'],'CDE3':['CEN3','CEN4']}
        # self.DISTLIST = {'CEN1':4.0,'CEN2':6.0,'CEN3':8.0,'CEN4':10.0}
        # self.DENVLIST = {'CDE1':['CEN1','CEN2'],'CDE2':['CEN2','CEN3'],'CDE3':['CEN3','CEN4']}
        self.popResidues = {}
        self.keyResidues = {}
        #self.proteinFile = proteinFile
        try:
            self.protein = parsePDB(proteinFile)
        except Exception as e:
            self.BadPDB = True
            self.BadReason = "%s"%(e)
            return 
        #print self.orgResnumList
        #print self.protein.getResindices()


    def updateKeyRes(self,keyresname):
        # refactor working process:
        # updateKeyRes with KeyRes parameter, do one key res at a time
        # out put result to certain directory
        # clean keyResidues for each key Residue

        self.keyResidues = {}
        self.NoKeyRes = False

        #resname = keyresname.split('_')
         #querystr = "resname %s" %(resname[1])
         #querystr = "resnum %s" %(resname[2])
        querystr = "resname %s" %(keyresname)
         #print querystr

        resAtoms = self.protein.select(querystr)
        #print resAtoms
        #print resAtoms.numAtoms()
        if resAtoms is None:
            print("hi no %s in this cavity"%(keyresname))
        #print "hello"
         
        # if protein do not have certain Key residue, add a tag and skip the
        # following step
        if resAtoms == None:
            self.NoKeyRes = True
            return 0
        else:
            self.NoKeyRes = False

        # resIDList = self.createResID(resAtoms)
        # #print resIDList
        # QueryrootList = self.createQueryroot(resAtoms)


        # # self.breakprint(QueryrootList)
        # for i in range(len(resIDList)):
        #     resID = resIDList[i]
        #     queryroot = QueryrootList[i]
        #     self.keyResidues[resID] = cavResidue(self,resID,[])
        #     # At this step: it used to be pops could not be generted due to conformation effect
        #     # it has been solved by try pops twice.
        #     self.getKeyRes(resID).setQueryroot(queryroot)
        #     self.getKeyRes(resID).setQuerys(self.DISTLIST)
        # self.searchEnv()
    
        resQueryRootDict = self.createResQueryRoot(resAtoms)
        for resID in list(resQueryRootDict.keys()):

         #for i in range(len(resIDList)):
             #resID = resIDList[i]
             #queryroot = QueryrootList[i]
            queryroot = resQueryRootDict[resID]
             # self.keyResidues[resID] = keyResidue(self,resID,self.getPopRes(resID).poplist)
            self.keyResidues[resID] = cavResidue(self,resID,[])
             # At this step: it used to be pops could not be generted due to conformation effect
             # it has been solved by try pops twice.
            self.getKeyRes(resID).setQueryroot(queryroot)
            self.getKeyRes(resID).setQuerys(DISTLIST)
        self.searchEnv()
         

    def searchEnv(self):
    # If this is called by updateKeyRes. not need to check self.NoKeyRes??
        if self.NoKeyRes == True:
            return 0
        for resid in list(self.keyResidues.keys()):
            keyresidue = self.getKeyRes(resid)
            #print "keyresidue resid %s "%(resid)
            for env in list(self.DISTLIST.keys()):
                keyresidue.updateENV(self.protein,env)
            #print keyresidue.CEN1
            #print keyresidue.CEN2
            #print keyresidue.CEN3
            #print keyresidue.CEN4
            #for denv in self.DENVLIST.keys():
            #    envlist = self.DENVLIST[denv]
            #    keyresidue.updateDENV(denv,envlist)

    def outKeyRes(self,dataFile):
        if self.NoKeyRes == True:
            return 0 
        fh=open(dataFile,'w')
        tempstr = outKeyResStr()
        fh.write(tempstr)
        fh.close()
    def outKeyResStr(self):
        if self.NoKeyRes == True:
            return [] 
        
        # for resid in self.keyResidues.keys():
        outList =[]
        for resid in sorted(list(self.keyResidues.keys()),key=cmp_to_key(self.sortKeyRes)):
            print(resid,"in outKeyResStr")
            keyresidue = self.getKeyRes(resid)
             #print "keyresidue resid %s "%(resid)
             #print sorted(DISTLIST.keys())
             # tempstr = "%4s %3s %4s %4s %-10s %4d %4d %5.2f" %(
             #     self.pdbID,keyresidue.chainid,keyresidue.Resname,keyresidue.ResNum,
             #     resid,
             #     keyresidue.SASA,keyresidue.Surf,keyresidue.Qsasa)
            tempstr = "%-10s " %(resid)
             #tempstr = "%s," %(resid)
             
             # OUTLIST = sorted(self.DISTLIST.keys()) + sorted(self.DENVLIST.keys())
            OUTLIST = sorted(self.DISTLIST.keys())
            #print OUTLIST
            for index in range(len(OUTLIST)):
                env = OUTLIST[index]
                #print env
                 #print "hello %s" %(env)
                tempstr = "%s %s" %(tempstr,keyresidue.outENV(env))
                 #tempstr = "%s,%s" %(tempstr,keyresidue.outENV(env))
                 #print tempstr
            tempstr="%s\n"%(tempstr)
            outList.append(tempstr)
        return outList
