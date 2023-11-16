<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Application;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewApplicationNotification;

class ApplicationController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'job_id_input' => 'required',
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $jobId = $request->input('job_id_input');
        $userId = auth()->id();
        $receiverUserId = Job::find($jobId)->user_id;
        $coverLetter = $request->input('cover_letter');
        $cv = $request->file('cv')->store('public/cv');
        $cvFileURL = '/storage/cv/' . basename($cv);

        $application = new Application();
        $application->job_id = $jobId;
        $application->user_id = $userId;
        $application->receiver_id = $receiverUserId;
        $application->cover_letter = $coverLetter;
        $application->cv = $cvFileURL;
        $application->save();

        // $job = Job::find($jobId); 
        // $applicant = User::find($userId); 
        // $receiverUserId = Job::find($jobId)->user_id;
        // $recruiter = User::find($receiverUserId);
        // $recruiter->notify(new NewApplicationNotification($job, $applicant));
        
        // session()->flash('success', 'Bạn đã nộp đơn xin việc thành công!');

        return redirect()->back()->with('success', 'Application created successfully');
    }

    public function notifications() {
        $applications = Application::where('receiver_id', auth()->user()->id)->get();
        return view('recruiter.notifications', ['applications'=> $applications]);
    }

    public function applicantDetail($applicationId) {
        $application = Application::findOrFail($applicationId);
        return view('recruiter.applicantDetail', compact('application'));
    }

    public function delete($id)
    {
        $Application = Application::findOrFail($id);
        $Application->delete();

        return redirect()->route('Application.show')->with('success','Application delete successfully');
    }


    public function search(Request $request)
    {
        $searchTerm = $request -> input('search');

        $companies= Application::where('name','like','%'.$searchTerm.'%')
                    -> orderBy('created_at','asc')
                    -> get();
                    
        return view('admin.Application',['companies'=>$companies,'searchTerm' => $searchTerm]);
    }

    public function getReceivedApplications($receiver_id)
    {
        $applications = Application::where('receiver_id', $receiver_id)
            ->with('job', 'user')
            ->get()
            ->map(function($application){
                return [
                    'job' => optional($application->job)->title,
                    'applicant' => optional($application->user)->name, 
                    'created_at' => $application->created_at,
                ];
            });

        return response()->json($applications);
    }
    
    public function export()
    {
        $companies = Application::all();

        $pdf = PDF::loadView('pdf.companies', compact('companies'));

        return $pdf->download('companies.pdf');
    }
}