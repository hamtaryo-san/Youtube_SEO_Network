<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->truncate();
    
        // 初期データ用意（列名をキーとする連想配列）
        $tags = [
                  ['name' => 'Game'],
                  ['name' => 'Pokemon'],
                  ['name' => 'MonsterHunter']
                 ];
        
        foreach($tags as $tag) {
          \App\Models\Tag::create($tag);
        }
    }
}
