from sklearn.model_selection import train_test_split
import joblib 
import numpy as np # linear algebra
import pandas as pd # data processing, CSV file I/O (e.g. pd.read_csv)
import matplotlib.pyplot as plt
import seaborn as sns
import plotly.express as px
from sklearn.svm import SVC
from collections import Counter

def detect_outliers(df,features):
    outlier_indices = []
    for c in features:
        # 1st quartile
        Q1 = np.percentile(df[c],25)
        # 3rd quartile
        Q3 = np.percentile(df[c],75)
        # IQR
        IQR = Q3 - Q1
        # Outlier step
        outlier_step = IQR * 1.5
        # detect outlier and their indeces
        outlier_list_col = df[(df[c] < Q1 - outlier_step) | (df[c] > Q3 + outlier_step)].index #filtre
        # store indeces
        outlier_indices.extend(outlier_list_col) #The extend() extends the list by adding all items of a list (passed as an argument) to the end
    outlier_indices = Counter(outlier_indices)
    multiple_outliers = list(i for i, v in outlier_indices.items() if v > 2) 
    
    return multiple_outliers

def change_type(song_data, var):
    song_data[var]=song_data[var].apply(lambda x: int(x))

def data_cleaning(song_data):
    #song_data.duration_ms= song_data.duration_ms.astype(float)
    #song_data.time_signature= song_data.time_signature.astype(float)
    #song_data.mode= song_data.mode.astype(float)
    song_data['duration_ms']=song_data['duration_ms'].apply(lambda x: float(x))
    song_data['mode']=song_data['mode'].apply(lambda x: float(x))
    song_data['time_signature']=song_data['time_signature'].apply(lambda x: float(x))

    #song_data["popularity"]= [ 1 if i>=66.5 else 0 for i in song_data.song_popularity ]
    song_data.drop(detect_outliers(song_data,["duration_ms","danceability","energy","instrumentalness","liveness","loudness","speechiness","valence"]),axis = 0).reset_index(drop = True)
    
    list_change_datatype= ["duration_ms",'tempo','acousticness',"danceability","energy","instrumentalness","liveness","loudness","speechiness","valence"]
    for column in list_change_datatype:
        song_data[column] = song_data[column].fillna(np.mean(song_data[column]))
        
    #list_dummy = ['key', 'mode', 'time_signature']
    #for i in list_dummy:
    #   song_data[i] = song_data[i].astype("category")
    #    song_data = pd.get_dummies(song_data, columns=[i], dtype=int)
        
    #column= ["key_0","key_1.0","key_2","key_3","key_4","key_5","key_6","key_7","key_8","key_9","key_10","key_11","mode_0.0","mode_1.0","time_signature_0.0","time_signature_1.0","time_signature_3.0","time_signature_4.0","time_signature_5.0"]
    #for i in column:
    #    change_type(song_data, i)

    return song_data


def predict(song_data):
    k = joblib.load("svm.pkl")
    song_data1 = song_data
    song_data1.drop('uri',axis=1,inplace=True)
    song_data1.drop('id',axis=1,inplace=True)
    song_data1 = (song_data1- np.min(song_data1))/(np.max(song_data1)-np.min(song_data1)).values
    predi = k.predict_proba(song_data1)#left = not popular , right = popular
    song_data["predict_1"]= predi[:,1]
    return song_data
   
def predict_popularity(song_data):
    song_data = data_cleaning(song_data)
    song_data = predict(song_data)
    return song_data

