<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Job;

class FavoriteController extends Controller
{
    public function view()
    {
        $user = auth()->user();
        $jobs = $user->Favorite()->with('job')->get()->pluck('job');

        return view('client.display', ['jobs' => $jobs]);
    }

    public function show()
    {
        $favorite= Favorite::with('created_at','asc')->get();
        return view('admin.favorite',['favorite'=>$favorite]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'job_id'=>'required',
        ]);

        $job_id = $request->input('job_id');
        
        $favorite = new Favorite();
        $favorite-> user_id=auth()->user()->id;
        $favorite->job_id=$job_id;
        $favorite->save();

        return redirect()->back()->with('message','favorite created successfully');
    }

    public function delete($id)
    {
        $favorite = Favorite::find($id);

        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with('success', 'favorite deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'favorite not found.');
        }
    }

    public function getFavoriteData()
    {
        $favoriteData = Favorite::orderBy('created_at','asc')->get();
        return response()->JSON($favoriteData);
    }
}