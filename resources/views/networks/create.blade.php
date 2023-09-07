<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Youtube SEO Network</title>
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
            margin-top: 10px;
            margin-left: 30%;
            margin-right: 30%;
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
            
        .question-text {
            font-size: 1vw;
            color: #333;
            margin-bottom: 0.5vw;
        }
            
        .google-form-text {
            border: none;
            border-bottom: 1px solid #000;
            outline: none;
            padding: 0.5vw;
            font-size: 0.8vw;
            background-color: #f0f8ff;
            width : 40vw;
        }
            
        .google-form-text:focus {
            border-bottom: 2px solid #007bff;
        }
            
        .select {
            position: relative;
            width: 20vw;
            font-size: 0.8vw;
        }
        
        .checkbox {
            position: relative;
            font-size: 0.8vw;
        }
        
        .checkbox-input {
            -webkit-transform: scale(1.5); 
            transform: scale(1.5);
        }
        
        .submit-button {
            background-color: #ccc;
            color: #000;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1vw;
            transition: background-color 0.3s ease;
            float: right;
        }
        
        .submit-button:hover {
            background-color: #0056b3; /* ホバー時の背景色 */
        }
                    
    </style>
    
    <body class="body">
        
        <div class="top-container">
            <h1 class="title-text">Youtube SEO Network</h1>
        </div>
        
        <div class="button-container">
            <a href="/" class="button" >ホームへ戻る</a>
        </div>
        
        <div  class="main-container">
            <form action="/networks/create" method="POST">
                @csrf
                
                <div class="keyword">
                    <h2 class='question-text'>keyword（動画を検索する際のキーワード)</h2>
                    <input type="text" class="google-form-text" name="network[keyword]" placeholder="keyword"/>
                </div>
                
                <div class="title">
                    <h2 class='question-text'>Title（作成したネットワークにつけるキャプション名）</h2>
                    <input type="text" class="google-form-text" name="network[title]" placeholder="title"/>
                </div>
                
                <div class="sort">
                    <h2 class='question-text'>Sort（動画を検索するときの条件※現在は日付順のみ）</h2>
                    <select name="network[sort]" class="select">
                        <option value="" disabled selected>--Please choose an option--</option>
                          <option value="date">日付順</option>
                    </select>
                </div>
                
                <div class="component">
                    <h2 class='question-text'>Component（何を対象にネットワークを作成するか※現在はビデオタグのみ）</h2>
                    <select name="network[component]" class="select">
                        <option value="" disabled selected>--Please choose an option--</option>
                          <option value="video">ビデオタグ</option>
                    </select>
                </div>
                
                <div class="tag">
                    <h2 class='question-text'>tag</h2>
                    @foreach($tags as $tag)
                    <div class="checkbox">
                        <input type="checkbox" value="{{ $tag->id }}" name="tag_array[]" class="checkbox-input">
                            {{ $tag->name }}
                        </input>
                        @endforeach
                    </div>
                </div>
                
                <input type="submit" id="submit" class="submit-button" value="submit"/>
            </form>
        </div>
    </body>
</html>