<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    public function view()
    {
        $categories = Category::withCount('jobs')->orderBy('created_at','asc')->get(['id', 'name']);
        $topCategories = $this->getTopCategoriesWithMostJobs();

        return view('client.category', 
        [
            'categories' => $categories,
            'topCategories' => $topCategories,
        ]);
    }

    public function show()
    {
        $categories = Category::orderBy('created_at', 'asc')->get();

        return view('admin.category', ['categories' => $categories]);
    }
    
    public function display(Request $request)
    {
        $request->validate([
            'category_id'=>'required',
        ]);
        
        $category_id = $request->input('category_id');
        
        $category = category::findOrFail($category_id);
        $jobs = Job::where('category_id', $category->id)->get();

        return view('client.display', compact('category', 'jobs'));
    }
    
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',  
            'path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',      
        ]);
                
        $category = new Category();
        $category->name=$request->input('name');
        
        if ($request->hasFile('path')) {
            $avatarPath = $request->file('path')->store('public/logo');
            $avatarFileURL = '/storage/logo/' . basename($avatarPath);
            $category->path = $avatarFileURL;
        }
        
        $category->save();
        
        return redirect()->route('category.show')->with('success', 'Category created successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|max:255',
            'path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $name = $request->input('name');
        $category_id = $request->input('category_id');

        $category = Category::findOrFail($category_id);
        $category->name = $name;

        if ($request->hasFile('path')) {
            $request->validate([
                'path' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $avatarPath = $request->file('path')->store('public/avatar');
            $avatarFileURL = '/storage/avatar/' . basename($avatarPath);
            $category->path = $avatarFileURL;
        }

        $category->save();

        return redirect()->route('category.show')->with('success', 'Category updated successfully');
    }

    public function getTopCategoriesWithMostJobs()
    {
        $categories = Category::withCount('jobs')->orderByDesc('jobs_count')->take(5)->get();

        return $categories;
    }

    public function getCategoryData()
    {
        $categories = Category::withCount('jobs')->orderBy('created_at','asc')->get(['id', 'name']);

        return response()->json($categories);
    }


    public function export()
    {
        $categories = Category::all();

        $pdf = PDF::loadView('pdf.categories', compact('categories'));

        return $pdf->download('categories.pdf');
    }
}