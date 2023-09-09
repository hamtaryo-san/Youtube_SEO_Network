<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Youtube SEO Network</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        
        <style>
            .button{
                display: flex;
                position: relative;
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
                margin-top: 10px;
                margin-left: 10%;
                margin-right: 10%;
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
            }
            
            .button-container {
                margin-left: 10%;
                margin-top: 1%;
                margin-bottom: 1%;
                margin-right: 10%;
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
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
            
            .board-text {
                font-size: 1vw;
                color: #1a1a1a;
                word-wrap: break-word;
                overflow-wrap: break-word;
                white-space: normal;
                margin: 0;
                padding: 0;
                line-height: 1.5;
                overflow: auto;
            }
            
            .board-text-small {
                font-size: 0.8vw;
                color: #333;
                word-wrap: break-word;
                overflow-wrap: break-word;
                white-space: normal;
                margin: 0;
                padding: 0;
                line-height: 1.5;
                overflow: auto;
            }
            
            .board {
                width: 20vw;
                height: 27vw;
                position: relative;
                border: 1px solid #ccc;
                background-color: #f9f9f9;
                border-radius: 1vw;
                padding: 1vw;
                margin-left: 2vw;
                margin-right: 2vw;
                margin-top: 2vw;
            }
            
            .image{
                object-fit: contain;
                object-position: center top;
                width: 100%;
                height: 75%;
            }
            
            .pagination {
                display: flex;
                list-style: none;
                padding: 0;
                justify-content: center;
                align-items: center;
            }
            
            .pagination li {
                margin: 0 5px;
                display: inline-block;
            }
            
            .pagination a {
                display: block;
                padding: 8px 16px;
                text-decoration: none;
                background-color: #f4f4f4;
                color: #333;
                border: 1px solid #ccc;
                border-radius: 4px;
                transition: background-color 0.3s ease-in-out;
            }
            
            .pagination a:hover {
                background-color: #333;
                color: #fff;
            }
        </style>
    </head>
    
    <body class="body">
        
        <div class="top-container">
            <h1 class="title-text">Youtube SEO Network</h1>
        </div>
        
        <div class="button-container">
            <a href="/networks/create" class="button" >新規作成</a>
            <a href="/profile" class="button" >アカウント情報</a>
        </div>
        
        <div class="main-container">
            @foreach($networks as $network)
                <div class="board">
                    <img src="{{ asset($network->graph) }}" class='image'>
                    <a href="/networks/{{ $network->id }}" class='board-text'>Network Title : {{ $network->title }}</a>
                    <p class='board-text-small'>Keyword : {{ $network->keyword }}</p>
                    <p class='board-text-small'>Created at : {{ $network->created_at }}</p>
                    <p class='board-text-small'>Component : {{ $network->component }}</p>
                    <p class='board-text-small'>Tags :
                    @foreach($network->tags as $tag)
                        {{ $tag->name }}
                    @endforeach
                    </p>
                </div>
            @endforeach
        </div>
        
        <div class = 'pagination'>
                {{ $networks->links() }}
        </div>
    </body>
</html>