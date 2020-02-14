import pandas as pd
import numpy as np
from sklearn import svm

# from sklearn import model_selection
# from sklearn.linear_model import LogisticRegression
import pickle
from sklearn.externals import joblib

df0 = pd.read_csv("./TrainingSet.csv")
df1 = pd.read_csv("./TestSet.csv")
df1 = df1.append([df0])
#print df1
#df1[df1['cov']=='Yes']=1.0
#df1[df1['cov']=='No']=0.0

ttt1 = df1.loc[:,['cov','ENV1.All','ENV2.All','ENV3.All','ENV4.All','hbVR','hDVR','lipVR','QSASA','pka','pkdAve']]
ttt2 = df1.loc[:,df1.columns.str.contains('Tanaka')]
df2 = pd.merge(ttt1, ttt2, left_index=True, right_index=True, how='inner')
print df2

array = df2.values
(nrow,ncol)=df2.shape

Xarray2=array[:,1:ncol]
Yarray2=array[:,0]
#print Xarray2
#print Yarray2

# rng = np.random.RandomState(0)
# n_samples_1 = 1000
# n_samples_2 = 100
# X = np.r_[1.5 * rng.randn(n_samples_1, 2),
#           0.5 * rng.randn(n_samples_2, 2) + [2, 2]]
# y = [0] * (n_samples_1) + [1] * (n_samples_2)
#print X,y
#clf = svm.SVC(kernel='rbf', C=1.0)

#clf.fit(X,y)

clf = svm.SVC(kernel='rbf', C=1.0)
clf.fit(Xarray2,Yarray2)
filename = 'svm-model.sav'
#clf = joblib.load(filename)

y_predict=clf.predict(Xarray2)
Yarray2=np.array(Yarray2).reshape(-1,1)
print(Yarray2)
print(Yarray2.shape)
y_predict=np.array(y_predict).reshape(-1,1)
print np.hstack((Yarray2,y_predict))

# kkk = np.hstack(Yarray2,y_predict)
# print kkk.shape
ddd=pd.DataFrame(np.hstack((Yarray2,y_predict)),columns=['cov','pred'])
# print ddd.shape
# #exit(0)
# #ddd=pd.DataFrame([y_predict,Yarray2.T],columns=['pred','cov'])
# print ddd
ddd.to_csv('nnn.csv',index=False)
# print Yarray2,y_predict


#pickle.dump(clf, open(filename, 'wb'))
joblib.dump(clf, filename)