#必要なライブラリインポート
import pandas as pd
from apiclient.discovery import build
import networkx as nx 
import numpy as np
import numpy.random as random
import scipy as sp
from pandas import Series, DataFrame
import datetime
import matplotlib.pyplot as plt
import matplotlib as mpl
import seaborn as sns
import community
import json
import collections
import sys
import uuid


def get_video_info(part, q, order, type, num):
    dic_list = []
    search_response = youtube.search().list(part=part,q=q,order=order,type=type)
    output = youtube.search().list(part=part,q=q,order=order,type=type).execute()

    #一度に5件しか取得できないため何度も繰り返して実行
    for i in range(num):
        dic_list = dic_list + output['items']
        search_response = youtube.search().list_next(search_response, output)
        output = search_response.execute()

    df = pd.DataFrame(dic_list)
    #各動画毎に一意のvideoIdを取得
    df1 = pd.DataFrame(list(df['id']))['videoId']
    #各動画毎に一意のvideoIdを取得必要な動画情報だけ取得
    df2 = pd.DataFrame(list(df['snippet']))[['channelTitle']]
    df3 = pd.concat([df1,df2], axis = 1)
    
    return df3

def get_statistics(id):
    statistics = youtube.videos().list(part = 'snippet', id = id).execute()['items'][0]['snippet']
    
    return statistics

def dataframe_cleaning(df):
    df.loc[:,"publishedAt"] = pd.to_datetime(df["publishedAt"]).dt.date
    df.sort_values("publishedAt",inplace = True)
    df  = df.drop_duplicates(subset='title')
    df = df.dropna(how = 'any')
    df= df.reset_index(drop=True)
    
    return df

def overlap_coefficient(list_a,list_b):
    #集合Aと集合Bの積集合(set型)を作成
    set_intersection = set.intersection(set(list_a), set(list_b))
    #集合Aと集合Bの積集合の要素数を取得
    num_intersection = len(set_intersection)
 
    #集合Aの要素数を取得
    num_listA = len(list_a)
    #集合Bの要素数を取得
    num_listB = len(list_b)
 
    #定義式に従い，Simpson係数を算出
    try:
        return float(num_intersection) / min([num_listA,num_listB])
    except ZeroDivisionError:
        return 1.0 

def create_network(df):
    
    index = 0
    index_b = 0
    judge = 0
    empty_list = []
    G = nx.Graph() 
    
    for a in range(len(df['tags'])):
        G.add_nodes_from([(df.iloc[a,1])])
        a = a + 1
        
    for index in range(len(df_output2['tags'])):  
        for index_b in range(len(df_output2['tags'])):
            if index_b <= index:
                index_b = index_b + 1
            else:
                judge = (overlap_coefficient(list(df_output2.iloc[index,3]),list(df_output2.iloc[index_b,3])))
                if judge >= 0.4:
                    G.add_edges_from([(df_output2.iloc[index,1],df_output2.iloc[index_b,1])])
                index_b = index_b + 1       
    index = index + 1
    
    return G

def community_detecting(G, df):

    partition = community.best_partition(G)
    # ノードの並びと同じ順でグループのリストを配列として取得する。
    partition_list = [partition[n] for n in G.nodes]
    
    common_communities = collections.Counter(partition_list)
    common_communities = list(common_communities.most_common())
    common_communities = [list(i) for i in common_communities]
    
    common_list = []
    
    for i in range(len(common_communities)):
        if i < 5:
            common_list.append(common_communities[i][0])
        else:
            pass

    for i in range(len(partition_list)):

        flag = 0

        for m in common_list:
            if int(partition_list[i]) == int(m):
                pass
            else:
                flag+=1

        if flag==5:
            partition_list[i]= -1
            
            
    color_list = ['r' if i == common_list[0] else i for i in partition_list]
    color_list = ['b' if i == common_list[1] else i for i in color_list]
    color_list = ['y' if i == common_list[2] else i for i in color_list]
    color_list = ['g' if i == common_list[3] else i for i in color_list]
    color_list = ['magenta' if i == common_list[4] else i for i in color_list]
    color_list = ['gray' if i == -1 else i for i in color_list]
    
    
    
    df = df.assign(community=0)
    
    for i in range(len(partition_list)):
        df.iat[i,4] = partition_list[i]
        
    common_list.append(-1)
    common_list.append(-2)
    
    whole_community_dict = {}
    no1_community_dict = {}
    no2_community_dict = {}
    no3_community_dict = {}
    no4_community_dict = {}
    no5_community_dict = {}
    no6_community_dict = {}
    
    dict_list = [
        no1_community_dict,
        no2_community_dict,
        no3_community_dict,
        no4_community_dict,
        no5_community_dict,
        no6_community_dict,
        whole_community_dict
    ]
    
    for i in range(len(common_list)):
        if common_list[i] == -2:
            df_temp = df
        else:
            df_temp = df[df['community'] == common_list[i]]
            
        dict_list[i]['Rate'] = len(df_temp['community'])/len(df['community']) * 100
            
        temp_list = []
        
        for a in range(len(df_temp['tags'])):
            for b in range(len(df_temp.iloc[a,3])):
                temp_list.append(df_temp.iloc[a,3][b])
                
        c = collections.Counter(temp_list)
        
        
        Top20words_list = []
        Top20words_list = list(c.most_common())
        Top20words_list = [list(i) for i in Top20words_list]
        for l in Top20words_list:
            l[1] = l[1]/len(df_temp)*100

        for word in range(20):
            if word >= len(Top20words_list)-1:
                pass
            else:
                dict_list[i]['Top{}'.format(word+1)] = {'Word' : Top20words_list[word][0], 'Rate' : Top20words_list[word][1]}
    
    return [color_list, dict_list]

def graph_storing(G, color_list, img_store_path):
    fig = plt.figure(figsize=(20, 20))
    pos = nx.spring_layout(G, seed=3)
    nx.draw_networkx_edges(G, pos, edge_color='gray', width=0.3)
    nx.draw_networkx_nodes(G, node_color=color_list, pos=pos, node_size=10)
    plt.axis('off')
    file_name = str(uuid.uuid1())
    fig.savefig(img_store_path+"/{}.png".format(file_name))

    return '{}/{}.png'.format(img_store_path, file_name)

def return_json(component, 
                sort, 
                graph_path, 
                json_store_path,
                WholeWordList = {}, 
                No1WordList = {}, 
                No2WordList = {},
                No3WordList = {}, 
                No4WordList = {}, 
                No5WordList = {},
                No6WordList = {},):

    file_name = str(uuid.uuid1())

    json_path_in_file = "{}/{}.json".format(json_store_path, file_name)

    network_dict = {
        "component" : component,
        "sort" : sort,
        "graph_path" : graph_path,
        "json_path" : json_path_in_file,
        "community" : {
            "WholeNetwork" :  WholeWordList,
            "No1Community" :  No1WordList,
            "No2Community" :  No2WordList,
            "No3Community" :  No3WordList,
            "No4Community" :  No4WordList,
            "No5Community" :  No5WordList,
            "Others" :        No6WordList
        }
    }

    with open("{}/{}.json".format(json_store_path, file_name), 'w') as f:
        json.dump(network_dict, f, indent=2)
    
    return json_path_in_file


if __name__ == "__main__":

    argv = sys.argv
    keyword = str(argv[1])
    component = str(argv[2])
    sort = str(argv[3])
    YOUTUBE_API_KEY = str(argv[4])
    json_store_path = str(argv[5])
    img_store_path = str(argv[6])

    youtube = build('youtube', 'v3', developerKey=YOUTUBE_API_KEY)

    df = get_video_info(part='snippet',q=keyword,order=sort ,type=component ,num = 10)
    df_static = pd.DataFrame(list(df['videoId'].apply(lambda x : get_statistics(x))))
    df_output = pd.concat([df,df_static], axis = 1)
    df_output  = df_output.loc[:, ['videoId','title','publishedAt','tags']]

    df_output2 = dataframe_cleaning(df_output)
    G = create_network(df_output2)
    community_data = community_detecting(G, df_output2)
    graph_storing(G, community_data[0], img_store_path)

    path = return_json(component, 
            sort, 
            img_store_path, 
            json_store_path,
            WholeWordList = community_data[1][6], 
            No1WordList = community_data[1][0], 
            No2WordList = community_data[1][1],
            No3WordList = community_data[1][2], 
            No4WordList = community_data[1][3], 
            No5WordList = community_data[1][4],
            No6WordList = community_data[1][5],)
    
    print(path)