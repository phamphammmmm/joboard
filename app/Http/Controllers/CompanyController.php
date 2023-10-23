<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function view()
    {
        $companies = Company::withCount('jobs')->orderBy('created_at', 'asc')->get();
        return view('client.company', ['companies' => $companies]);
    }

    public function show()
    {
        $companies = Company::orderBy('created_at', 'asc')->get();
        return view('admin.company', ['companies' => $companies]);
    }

    public function display(Request $request)
    {
        $request->validate([
            'company_id'=>'required',
        ]);
        
        $company_id = $request->input('company_id');
        
        $company = Company::findOrFail($company_id);
        $jobs = Job::where('company_id', $company->id)->get();

        return view('client.display', compact('company', 'jobs'));
    }
    
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:companies|max:255',
            'email' => 'required|string|email|max:255|unique:companies',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);  
        
        $name=$request->input('name');
        $email=$request->input('email');    
        $path = $request->file('path');
        $description=$request->input('description');

        if ($request->hasFile('path')) {
            $avatarPath = $path->store('public/avatar');
            $avatarFileURL = '/storage/avatar/' . basename($avatarPath);
        } else {
            $avatarFileURL = '/storage/avatar/avatar.png';
        }
        
        $company = new Company();
        $company->name = $name;
        $company->email = $email;
        $company->description = $description;
        $company->path = $avatarFileURL;
        $company->save();

        return redirect()->route('company.show')->with('success', 'Company created successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|string|email|max:255',
            'path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $company_id=$request->input('company_id');
        $name = $request->input('name');
        $email = $request->input('email');
        $description = $request->input('description');

        $company = Company::findOrFail($company_id);
        $company->name = $name;
        $company->description = $description;
        $company->email = $email;

        if ($request->hasFile('path')) {
            $avatarPath = $request->file('path')->store('public/avatar');
            $avatarFileURL = '/storage/avatar/' . basename($avatarPath);
            $company->path = $avatarFileURL;
        }

        $company->save();

        return redirect()->route('company.show')->with('success', 'Company updated successfully');
    }

    public function delete($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('company.show')->with('success','Company delete successfully');
    }


    public function search(Request $request)
    {
        $searchTerm = $request -> input('search');

        $companies= Company::where('name','like','%'.$searchTerm.'%')
                    -> orderBy('created_at','asc')
                    -> get();
                    
        return view('admin.company',['companies'=>$companies,'searchTerm' => $searchTerm]);
    }

    public function getCompanyData()
    {
        $company= Company::orderBy('created_at','asc')->get();
        return response()->json($company);
    }

    public function export()
    {
        $companies = Company::all();

        $pdf = PDF::loadView('pdf.companies', compact('companies'));

        return $pdf->download('companies.pdf');
    }
}