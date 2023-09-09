<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Network;
use App\Models\Tag;
use App\Models\User;
use App\Models\Community;
use App\Models\Word;

class NetworkController extends Controller
{
    public function index(Network $network)
    {
        return view('networks.index')->with(['networks' => $network->getByLimit()]);
    }
    
    public function create(Tag $tag)
    {
        return view('networks.create')->with(['tags' => $tag->get()]);
    }
    
    public function show(Network $network)
    {
        return view('networks.show')->with(['network' => $network]);
    }
    
    public function proceed(Request $request)
    {
        $input = $request['network'];
        $title = $input["title"];
        $keyword = $input["keyword"];
        $component = $input["component"];
        $sort = $input["sort"];
        $tag_arr = $request->tag_array;
        
        //$json_path = asset('/json');
        //$image_path = asset('/images');
        $image_path = '.';
        $api_key = config('app.youtube_api_key');
        
        $pythonPath =  "../app/Python/";
        //ここでnetworksのテーブルにkeyword,title,component,userid
        //tagsのてーぶるにもほぞんできるようにする
        //sep指定してtagつけてるようにする(explode)
        
        $pythonPath =  "../app/Python/";
        $command = "python3 " . $pythonPath . "NetworkCreate.py " . $keyword . ' '. $component . ' ' . $sort . ' ' . $api_key . ' '. $image_path;
        exec($command , $outputs);
        
        dd($outputs, $api_key);
        
        $tmp = json_encode($outputs[0]);
        $network_arr = json_decode($outputs[0], true);
        
        //networkを保存
        $network = new Network;
        $user = auth()->user(); // ログインユーザーを取得
        
        $network->title = $title;
        $graph_path = $network_arr['graph_path'];
        $network->graph = $graph_path;
        $network->sort = $sort;
        $network->keyword = $keyword;
        $network->component = $component;
        
        $user->networks()->save($network);//userテーブルと紐づけ
        $network->save();
        
        
        //各コミュニティの保存
        $rank = 0;
        $AllCommunities = $network_arr['community'];
        
        foreach ($AllCommunities as $community_info){
            $community = new Community;
            $community-> rank = $rank;
            $rate = $community_info['Rate'];
            $community-> rate = $rate;
            $network->communities()->save($community);
            $community->save();
            $rank++;
            
            $Words = $community_info['Words'];
            
            foreach ($Words as $word_info){
              $word = new Word;
              $word_name = $word_info['Word'];
              $word_rate = $word_info['Rate'];
              $word->name = $word_name;
              $word->rate = $word_rate;
              $community->words()->save($word);
              $word->save();
            };
        };
        
        foreach ($tag_arr as $tag_id){
            $network->tags()->attach($tag_id);
        };
        
        
        return redirect('/networks/' . $network->id);
    }
}
