<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TagController extends Controller
{
   
    public function getTagData()
    {
        $tag= Tag::orderBy('created_at','asc')->get();
        return response()->json($tag);
    }
}