<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function view()
    {
        return view('client.register');
    }

    public function register(Request $request)
    {
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
               

        // Tách request thành các biến riêng
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

        // Tạo một đối tượng User và gán các giá trị từ biến tách ra
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

        return redirect('/login');
    }

}