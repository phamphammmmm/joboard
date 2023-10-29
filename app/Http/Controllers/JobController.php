<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Tag;
use App\Models\Company;
use App\Models\User;
use App\Models\category;

class JobController extends Controller
{
    public function view()
    {
        $job = Job::with(['company', 'category', 'user', 'tag'])->orderBy('created_at','desc')->get();
        return view('client.job', ['job' => $job]);
    }

    public function show()
    {
        $companies = Company::all();
        $categories = Category::all();
        $tags = Tag::all();

        $user = auth()->user();
        $jobs = $user->jobs;
        return view('recruiter.job', [
            'jobs' => $jobs,
            'companies'=>$companies,
            'categories'=>$categories,
            'tags'=>$tags
        ]);
    }

    public function create(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|max:255',
            'salary' => 'required|numeric|min:0',
            'deadline' => 'required|date',
            'description' => 'required|max:1000',
            'tag_id' => 'required|exists:tags,id',
        ]);
        
        $title = $request->input('title');
        $company_id = $request->input('company_id');
        $category_id = $request->input('category_id');
        $tag_id = $request->input('tag_id');
        $location = $request->input('location');
        $salary = $request->input('salary');
        $deadline = $request->input('deadline');
        $description = $request->input('description');

        $job = new Job();
        $job->title = $title;
        $job->company_id = $company_id;
        $job->category_id = $category_id;
        $job->tag_id = $tag_id;
        $job->user_id = auth()->user()->id; 
        $job->location = $location;
        $job->salary = $salary;
        $job->deadline = $deadline;
        $job->description = $description;
        $job->save();
        
        return redirect()->route('job.show')->with('success', 'Job added successfully!!');
    }
    
 
    public function getJobData()
    {
        $jobs = Job::with(['company', 'category', 'user', 'tag'])->get();

        $formattedJobs = $jobs->map(function ($job) {
            return [
                'recuiter' => $job->user->name,
                'category' => $job->category->name,
                'company' => $job->company->name,
                'tag' => $job->tag->name,
                'title' => $job->title,
                'description' => $job->description,
                'salary' => $job->salary,
                'deadline' => $job->deadline,
                'location' => $job->location,
                'created_at' => $job->created_at,
                'updated_at' => $job->updated_at
            ];
        });

        return response()->json($formattedJobs);
    }

    public function getJobById($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        $formattedJob = [
            'id' => $job->id,
            'recuiter' => $job->user->name,
            'path' => $job->company->path,
            'category' => $job->category->name,
            'company' => $job->company->name,
            'tag' => $job->tag->name,
            'title' => $job->title,
            'description' => $job->description,
            'salary' => $job->salary,
            'deadline' => $job->deadline,
            'location' => $job->location,
            'created_at' => $job->created_at,
            'updated_at' => $job->updated_at
        ];

        return response()->json($formattedJob);
    }

}