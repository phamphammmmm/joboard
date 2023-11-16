<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Application;

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

    public function payment()
    {
        return view('recruiter.payment');
    }
    
    public function show()
    {
        $recruiterId = auth()->id();

        $applications = Application::where('receiver_id', $recruiterId)->get();

        $applicantsInfo = [];

        foreach ($applications as $application) {
            $applicantInfo = [
                'cv' => $application->cv,
                'id' => $application->id,
                'job_title' => $application->job->title,
                'applicant' =>  $application->user->name,
                'cover_letter' => $application->cover_letter,
            ];

            $applicantsInfo[] = $applicantInfo;
        }

        return view('recruiter.applicant', compact('applicantsInfo'));
    }

    public function delete($id)
    {
        $applicant = Application::findOrFail($id);
        $applicant->delete();

        return redirect()->back()->with('success','applicant delete successfully');
    }
}