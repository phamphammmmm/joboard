<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','path'];
    
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}