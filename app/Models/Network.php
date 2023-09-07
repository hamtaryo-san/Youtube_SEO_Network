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
        return $this->belongsToMany(Tag::class);  
    }
    
    public function user()   
    {
        return $this->belongsTo(User::class);  
    }
    
    public function getByLimit(int $limit_count = 6)
    {
        return $this->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
    
}
