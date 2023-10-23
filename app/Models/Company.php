<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name','email','description','path'];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}