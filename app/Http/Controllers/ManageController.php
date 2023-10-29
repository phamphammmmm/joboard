<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User; // Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\UserHelper;
use Illuminate\Support\Facades\DB;

class ManageController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $users = User::orderBy('created_at', 'asc')->get();
        $newUsers = User::where('created_at', '>=', now()->subDay())->count();

        return view('admin.manage', [
            'users' => $users,
            'newUsers' => $newUsers,
            'totalUsers' => $totalUsers,
        ]);
    }
    

    public function create(Request $request)
    {
        if (User::where('name', $request->input('name'))->exists()) {
            return redirect()->back()->with('error', 'Failed creation of a user account due to duplicate');
        }

        $request->validate([
            'name' => 'required|string|regex:/^\S*$/u|max:255', 
            'fullname' => 'required|string|max:255',
            'password' => [
                'required',
                'min:12', 
                'regex:/^[A-Z]/', 
                'regex:/[!@#$%^&*(),.?":{}|<>]/', 
            ],
            'major' => 'required|string|max:255',          
            'email' => 'required|string|email|max:255|unique:users',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('path');
        $name = $request->input('name');
        $email = $request->input('email');
        $major = $request->input('major');
        $fullname = $request->input('fullname');
        $password = $request->input('password');
        $birthdate = $request->input('birthdate');
        $birthmonth = $request->input('birthmonth');
        $birthyear = $request->input('birthyear');
        $birthdate = $request->input('birthyear') . '-' . $request->input('birthmonth') . '-' . $request->input('birthdate');
        
        if ($request->hasFile('path')) {
            $avatarPath = $path->store('public/avatar');
            $avatarFileURL = '/storage/avatar/' . basename($avatarPath);
        } else {
            $avatarFileURL = '/storage/avatar/avatar.png';
        }
        
        $user = new User();
        $user->name = $name;
        $user->fullname = $fullname;
        $user->password = bcrypt($password);
        $user->email = $email;
        $user->major = $major;
        $user->birthday = $birthdate;
        $user->type = 'seeker';
        $user->path = $avatarFileURL;
        $user->save();

        return redirect()->route('manage')->with('success', 'User added successfully!!');
    }

    public function delete($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return redirect()->route('manage')->with('success', 'User deleted successfully.');
        } else {
            return redirect()->route('manage')->with('error', 'User not found.');
        }
    }

    public function update(Request $request)
    {
         $request->validate([
            'name' => 'required|string|regex:/^\S*$/u|max:255', 
            'editUserId'=>'required',
            'fullname' => 'required',
            'major' => 'required',          
            'email' => 'required',
            'type'=>'required',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $major = $request->input('major');
        $type = $request->input('type');
        $fullname = $request->input('fullname');
        $editUserId = $request->input('editUserId');

        $user = User::findOrFail($editUserId);
        
        if ($user) {
            $user->name = $name;
            $user->major= $major;
            $user->type = $type; 
            $user->email = $email; 
            $user->fullname= $fullname;
            $user->save();
            
            return redirect()->route('manage')->with('success', 'User added successfully!!');
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|regex:/^\S*$/u|max:255', 
            'editUserId'=>'required',
            'fullname' => 'required',
            'location' => 'required',  
            'description'=>'required',
            'major' => 'required',          
            'email' => 'required',
        ]);
        $fullname = $request->input('fullname');
        $name = $request->input('name');
        $description = $request->input('description');
        $location = $request->input('location');
        $email = $request->input('email');
        $major = $request->input('major');
        $editUserId = $request->input('editUserId');

        $user = User::findOrFail($editUserId);
        
        if ($user) {
            $user->name = $name;
            $user->major= $major;
            $user->description= $description;
            $user->location= $location;
            $user->email = $email; 
            $user->fullname= $fullname;
            $user->save();
            
            return redirect()->route('profile')->with('success', 'User added successfully!!');
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function search(Request $request)
    {

        $totalUsers = User::count();
        $newUsers = User::where('created_at', '>=', now()->subDay())->count();

        $searchTerm = $request->input('search');

        if (empty($searchTerm)) {
            $users = User::whereIn('type', ['admin', 'moderator'])->get();
        } else {
            $users = User::where(function($query) use ($searchTerm) {
                $query->where(function($query) use ($searchTerm) {
                    $query->where('type', 'seeker')
                          ->orWhere('type', 'recruiter');
                })
                ->where('name', 'like', '%' . $searchTerm . '%');
            })->get();
        }

        return view('admin.manage', [
            'users' => $users,
            'newUsers' => $newUsers,
            'totalUsers' => $totalUsers,
        ]);
    }

    
    public function getUser($id)
    {
        $user = User::find($id);
    
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
    
    public function getRegistrationData()
    {
        $registrationData = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as registrations'))
            ->groupBy('date')
            ->get();
    
        return response()->json($registrationData);
    }

    public function export()
    {
        $users = User::all();

        $pdf = PDF::loadView('pdf.users', compact('users'));

        return $pdf->download('users.pdf');
    }
}