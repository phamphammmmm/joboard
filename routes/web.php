<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    } else {
        return view('client.login');
    }
})->name('login');

// Group routes that require the 'web' middleware
Route::middleware('web')->group(function () {
    Route::get('/login', function () {
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return view('client.login');
        }
    })->name('login');

    Route::get('/register', function () {
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return view('client.register');
        }
    })->name('register');

    Route::middleware('auth')->group(function () {
        Route::get('/home', function () {
            return view('home');
        })->name('home');
    });
});

Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm']);

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', function () {
    if (Auth::check()) {
        return view('home');
    } else {
        return redirect('/login');
    }
})->name('home');


//Client 
Route::get('/home', [HomeController::class, 'view'])->name('home');
Route::get('/job', [JobController::class, 'view'])->name('job');
Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::get('/category', [CategoryController::class, 'view'])->name('category');
Route::get('/company', [CompanyController::class, 'view'])->name('company');
Route::get('/favorite', [FavoriteController::class, 'view'])->name('favorite');
Route::get('/candidate', [CandidateController::class, 'view'])->name('candidate');
Route::get('/feedback', [FeedbackController::class, 'view'])->name('feedback');

Route::get('/dashboard', [DashboardController::class, 'view'])->name('dashboard');

Route::get('/manage', [ManageController::class,'index'])->name('manage');
Route::get('/manage/search', [ManageController::class, 'search'])->name('manage.search');
Route::post('/manage/create', [ManageController::class, 'create'])->name('manage.create');
Route::post('/manage/update', [ManageController::class, 'update'])->name('manage.update');
Route::get('/manage/export', [ManageController::class,'export'])->name('manage.export');
Route::delete('/manage/delete/{id}', [ManageController::class, 'delete'])->name('manage.delete');

Route::get('/company/show',[CompanyController::class,'show'])->name('company.show');
Route::get('/company/display', [CompanyController::class, 'display'])->name('company.display');
Route::get('/company/export', [CompanyController::class,'export'])->name('company.export');
Route::get('/company/search', [CompanyController::class,'search'])->name('company.search');
Route::post('/company/create',[CompanyController::class,'create'])->name('company.create');
Route::post('/company/update', [CompanyController::class,'update'])->name('company.update');
Route::delete('/company/delete/{id}', [CompanyController::class,'delete'])->name('company.delete');

Route::get('/category/show', [CategoryController::class, 'show'])->name('category.show');
Route::get('/category/export', [CategoryController::class,'export'])->name('category.export');
Route::post('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category/update', [CategoryController::class, 'update'])->name('category.update');
Route::get('/category/display', [CategoryController::class, 'display'])->name('category.display');

Route::get('/candidate/show', [CandidateController::class, 'show'])->name('candidate.show');
Route::post('/candidate/create', [CandidateController::class, 'cerate'])->name('candidate.create');

Route::get('/feedback/show', [FeedbackController::class, 'show'])->name('feedback.show');
Route::get('/feedback/search', [FeedbackController::class,'search'])->name('feedback.search');
Route::post('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
Route::get('/feedback/display', [FeedbackController::class, 'display'])->name('feedback.display');
Route::get('/feedback/showAll', [FeedbackController::class, 'showAll'])->name('feedback.showAll');
Route::delete('/feedback/delete/{id}', [FeedbackController::class, 'delete'])->name('feedback.delete');

Route::get('/job/show', [JobController::class, 'show'])->name('job.show');
Route::get('/job/search', [JobController::class,'search'])->name('job.search');
Route::post('/job/create', [JobController::class, 'create'])->name('job.create');

Route::post('pusher/send-message', [pusherController::class,'sendMessage'])->name('pusher.sendmessage');

Route::get('/favorite/show', [FavoriteController::class, 'show'])->name('favorite.show');
Route::post('/favorite/create', [FavoriteController::class, 'create'])->name('favorite.create');
Route::get('/favorite/showAll', [FavoriteController::class, 'showAll'])->name('favorite.showAll');
Route::delete('/favorite/delete/{id}', [FavoriteController::class, 'delete'])->name('favorite.delete');

Route::get('/application/show', [ApplicationController::class, 'show'])->name('application.show');
Route::get('/recruiter/notifications', [ApplicationController::class, 'notifications'])->name('recruiter.notifications');
Route::get('/recruiter/applicants/{applicationId}', [ApplicationController::class, 'applicantDetail'])->name('recruiter.applicantDetail');
Route::get('/application/export', [ApplicationController::class,'export'])->name('application.export');
Route::post('/application/create', [ApplicationController::class, 'create'])->name('application.create');

Route::get('auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/chat/{id?}', [ChatController::class, 'chat'])->name('chat');