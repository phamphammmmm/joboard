<?php

namespace App\Http\Controllers;
use App\Model\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function view()
    {
        return view('client.candidate');
    }

    public function show()
    {
        return view('admin.candidate');
    }

    public function create(){
        $request->validate([
            'name' => 'required',
            'email'=> 'required|',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');

        $candidate= new Candidate();
        $candidate->name=$name;
        
    }


}