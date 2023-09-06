<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Network;
use App\Models\Tag;

class NetworkController extends Controller
{
    public function index(Network $network)
    {
        return view('networks.index')->with(['networks' => $network->get()]);
    }
    
    public function create(Tag $tag)
    {
        return view('networks.create')->with(['tags' => $tag->get()]);
    }
    
    public function proceed(Request $request)
    {
        $input = $request['network'];
        $title = $input["title"];
        $keyword = $input["keyword"];
        $component = $input["component"];
        $sort = $input["sort"];
        $tag = $request->tag_array;
        
        //$json_path = asset('/json');
        //$image_path = asset('/images');
        $json_path = './storage/json';
        $image_path = './storage/images';
        $api_key = config('app.youtube_api_key');
        
        $pythonPath =  "../app/Python/";
        //ここでnetworksのテーブルにkeyword,title,component,userid
        //tagsのてーぶるにもほぞんできるようにする
        //sep指定してtagつけてるようにする(explode)
        
        $results = [
            'resultB' =>  $api_key,
            'resultA' =>  'konnitiha'
            ];
        
        $pythonPath =  "../app/Python/";
        $command = "/usr/bin/python3 " . $pythonPath . "NetworkCreate.py " . $keyword . ' '. $component . ' ' . $sort . ' ' . $api_key . ' ' . $json_path . ' ' . $image_path;
        exec($command , $outputs);
        
        return view('networks.index', $results);
    }
}
