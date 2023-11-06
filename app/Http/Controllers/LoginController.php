<?php

namespace App\Models;
namespace App\Http\Controllers;
use Socialite;
use App\Models\Series;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User; // Add this lineư
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('client.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->type === 'admin' || Auth::user()->type === 'moderator') {
                return redirect('/dashboard'); 
            } else {
                return redirect('/home'); 
            }
        } else {
            return redirect()->back()->withErrors(['login' => 'Invalid credentials']);
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
    $user = Socialite::driver('google')->user();

    // Kiểm tra xem user đã tồn tại trong CSDL hay chưa
    $existingUser = User::where('email', $user->email)->first();

    if ($existingUser) {
        // Nếu tồn tại, đăng nhập user
        Auth::login($existingUser);
    } else {
        // Nếu không tồn tại, tạo mới user
        $newUser = new User();
        $newUser->name = $user->name;
        $newUser->fullname = $user->name;
        $newUser->email = $user->email;
        $newUser->birthday = now()->format('Y-m-d');
        $newUser->major = 'seeker';
        $newUser->type = 'seeker';
        $newUser->path = $user->avatar;
        $newUser->password = bcrypt(Str::random(16));
        $newUser->save();

        Auth::login($newUser);
    }

    return redirect()->route('home');
}


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}