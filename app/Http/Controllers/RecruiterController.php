<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class RecruiterController extends Controller
{
    public function view()
    {
        return view('recruiter.dashboard');
    }

    public function oversee()
    {
        return view('recruiter.oversee');
    }


}