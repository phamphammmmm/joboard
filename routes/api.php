<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManageController; 
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ChatController;

// Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('/user/{id}', [ManageController::class, 'getUser']);
    Route::get('/registration-chart-data', [ManageController::class, 'getRegistrationData']);
    Route::get('/feedback', [FeedbackController::class, 'getFeedbackData']);
    Route::get('/feedback/{id}', [FeedbackController::class, 'getFeedbackById']);
    Route::get('/companies',[CompanyController::class,'getCompanyData']);
    Route::get('/categories',[CategoryController::class,'getCategoryData']);
    Route::get('/tags',[TagController::class,'getTagData']);
    Route::get('/jobs', [JobController::class, 'getJobData']);
    Route::get('/jobs/{id}', [JobController::class, 'getJobById']);
    Route::get('favrite',[FavoriteController::class,'getFavoriteData']);
    Route::post('/send-message',[ChatController::class,'sendMessage']);
    Route::get('/applications/received/{receiver_id}',[ApplicationController::class,'getReceivedApplications']);
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});