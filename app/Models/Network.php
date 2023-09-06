<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;
    
    public function communities()   
    {
        return $this->hasMany(Community::class);  
    }
    
    public function tags()   
    {
        return $this->hasMany(Tag::class);  
    }
}
