<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>YoutNetWork</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    
        <style>
        .button{
            display: flex;
            width: 10vw;
            height: 4vw;
            background-color: #ccc; 
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: bold;
            font-size: 1vw;
        }
            
        .body{
            background-color: #f0f8ff;
        }
            
        .main-container {
            margin-top: 5px;
            margin-left: 20%;
            margin-right: 20%;
        }
            
        .button-container {
            margin-left: 10%;
            margin-top: 1%;
            margin-bottom: 1%;
            margin-right: 10%;
        }
            
        .top-container {
            margin-left: 10%;
            margin-top: 1%;
            border-bottom: 3px solid #ccc;
            margin-right: 10%;
        }
            
        .title-text {
            font-size: 2vw;
        }
        
        .network-title {
            font-size: 1.5vw;
            text-decoration :underline;
        }
            
        .subtitle-text {
            font-size: 1vw;
            color: #333;
        }
        
        .image {
            margin-top: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .image img {
            max-width: 35vw;
            height: auto;
        }
        
        .board {
            width: 25vw;
            height: 10vw;
            position: relative;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 5px;
            padding: 20px;
            margin-left: 1;
            margin-right: 1vw;
            margin-top: 2vw;
            overflow: auto;
        }
        
        h1, h2, h3, h4, h5, h6 {
            margin-top: 0;
            margin-bottom: 0.2vw;
        }
        
        .table-container {
            margin-top: 10px;
            margin-left: 20%;
            margin-right: 20%;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .board h {
            width: 100%;
            text-align: center;
            margin-bottom: 2vw;
        }
    
        .color-sample {
            width: 0.8vw;
            height: 0.8vw;
            display: inline-block;
            margin-right: 0.8vw;
            border: 1px solid #000;
        } 
        
        table {
            width: 100%;
            border-collapse:  collapse;
        }
        
        .tr_0:nth-child(odd) {
            background-color:  #ddd;
            text-align: center;
        }
        
        .tr_1:nth-child(odd) {
            background-color:  #ed8282;
            text-align: center;
        }
        
        .tr_2:nth-child(odd) {
            background-color:  #c6d9ec;
            text-align: center;
        }
        
        .tr_3:nth-child(odd) {
            background-color:  #e2ed82;
            text-align: center;
        }
        
        .tr_4:nth-child(odd) {
            background-color:  #82eda2;
            text-align: center;
        }
        
        .tr_5:nth-child(odd) {
            background-color:  #ecc6dd;
            text-align: center;
        }
        
        .tr_6:nth-child(odd) {
            background-color:  #ddd;
            text-align: center;
        }
        
        th,td {
            padding: 0.2vw 0.4vw;
            text-align: center;
            font-size: 0.7vw;
            color: #333;
        }
        
    </style>
    
    
    <body class="body">
        
        <div class="top-container">
            <h1 class="title-text">Youtube SEO Network</h1>
        </div>
        
        <div class="button-container">
            <a href="/" class="button" >ホームへ戻る</a>
        </div>
        
        <div class="main-container">
            
            <h1 class="network-title">
                Network Title: {{ $network->title }}
            </h1>
            
            <h3 class="subtitle-text">
                このネットワークにつけられたタグ:
                @foreach($network->tags as $tag)
                    {{ $tag->name }}
                @endforeach
            </h3>
            
            <h3 class="subtitle-text">
                検索に使ったkeyword: {{ $network->keyword }}
            </h3>
            
            <h3 class="subtitle-text">
                作成日時: {{ $network->created_at }}
            </h3>
            <div class="image">
                <img src={{ $network->graph }}>
            </div>
        </div>
        <div class="table-container">
            @foreach($network->communities as $community)
                <div class="board">
                    <h>
                        @if ($community->rank === "1")
                            占有率1位のコミュニティ<br>占有率:{{$community->rate}}%<br>ノードカラー:赤<span class="color-sample" style="background-color: #FF0000;">
                        @elseif ($community->rank === "2")
                            占有率2位のコミュニティ<br>占有率:{{$community->rate}}%<br>ノードカラー:青<span class="color-sample" style="background-color: #0000FF;">
                        @elseif ($community->rank === "3")
                            占有率3位のコミュニティ<br>占有率:{{$community->rate}}%<br>ノードカラー:黄<span class="color-sample" style="background-color: #FFFF00;">
                        @elseif ($community->rank === "4")
                            占有率4位のコミュニティ<br>占有率:{{$community->rate}}%<br>ノードカラー:緑<span class="color-sample" style="background-color: #00FF00;">
                        @elseif ($community->rank === "5")
                            占有率5位のコミュニティ<br>占有率:{{$community->rate}}%<br>ノードカラー:マゼンタ<span class="color-sample" style="background-color: #FF00FF;">
                        @elseif ($community->rank === "6")
                            その他のコミュニティ<br>占有率:{{$community->rate}}%<br>ノードカラー:グレー<span class="color-sample" style="background-color: #808080;">
                        @else
                            コミュニティ全体
                        @endif
                    </h>
                        <table>
                            <thead>
                                <tr class="tr_{{$community->rank}}">
                                    <th>使用度ランク</th>
                                    <th>割合（％）</th>
                                    <th>名前</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($community->words as $index => $word)
                                    <tr class="tr_{{$community->rank}}">
                                        <td>{{ $index + 1 }}</td> <!-- 使用度（繰り返し回数+1） -->
                                        <td>{{ $word->rate }}</td> <!-- 割合（$word->rate） -->
                                        <td>{{ $word->name }}</td> <!-- 名前（$word->name） -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </p>
                </div>
            @endforeach
        </div>
    </body>
</html>