<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    public function networks()   
    {
        return $this->belongsToMany(Network::class);  
    }
}
