<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Network</title>
    </head>
    <body>
        <h1>NetworkName</h1>
        <form action="/networks/create" method="POST">
            @csrf
            <div class="keyword">
                <h2>keyword</h2>
                <input type="text" name="network[keyword]" placeholder="keyword"/>
            </div>
            <div class="title">
                <h2>Title</h2>
                <input type="text" name="network[title]" placeholder="title"/>
            </div>
            <div class="sort">
                <h2>Sort</h2>
                <select name="network[sort]">
                    <option value="">--Please choose an option--</option>
                      <option value="date">日付順</option>
                </select>
            </div>
            <div class="component">
                <h2>Component</h2>
                <select name="network[component]">
                    <option value="">--Please choose an option--</option>
                      <option value="video">ビデオタグ</option>
                </select>
            </div>
            <div class="tag">
                <h2>tag</h2>
                @foreach($tags as $tag)
                <input type="checkbox" value="{{ $tag->id }}" name="tag_array[]">
                    {{ $tag->name }}
                </input>
                @endforeach
            </div>
            <input type="submit", id="submit", value="submit"/>
        </form>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
        
    </body>
</html>