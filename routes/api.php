<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RequestedServiceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->load('role.permissions');
});

Route::post('/login',[LoginController::class,'login']);
Route::post('/forgot',[ForgotPasswordController::class,'forgot']);
Route::post('/reset/{token}',[ResetPasswordController::class,'resetPassword']);
Route::post('/resend_verification_code',[UserLoginController::class,'resend']);
Route::post('/change_password/{id}',[LoginController::class,'changePassword']);

Route::middleware(['auth:sanctum'])->group(function () {
Route::apiResource('/dashboards',DashboardController::class);
Route::post('/read',[DashboardController::class,'read']);
Route::apiResource('/applicants',ApplicantController::class);

Route::get('/get_contacts',[RequestedServiceController::class,'get_contacts']);
Route::get('/get_jobs',[JobController::class,'get_jobs']);
Route::post('/logout',[LoginController::class,'logout']);

});
Route::apiResource('/projects',ProjectController::class);
Route::get('/get_teams',[TeamController::class,'get_teams']);
Route::apiResource('/teams',TeamController::class);
Route::apiResource('/users',UserController::class);
Route::apiResource('/roles',RoleController::class);
Route::post('/assign/{id}',[RoleController::class,'assign']);
Route::apiResource('/permissions',PermissionController::class);
Route::apiResource('/services',ServiceController::class);
Route::apiResource('/contacts',RequestedServiceController::class);
Route::apiResource('/galleries',GalleryController::class);
Route::apiResource('/news',NewsController::class);
Route::apiResource('/clients',ClientController::class);
Route::apiResource('/categories',CategoryController::class);
Route::apiResource('/departments',DepartmentController::class);
Route::post('/update_news_img/{id}',[NewsController::class,'updatePhoto']);
Route::post('/update_service_img/{id}',[ServiceController::class,'updatePhoto']);
Route::post('/update_project_img/{id}',[ProjectController::class,'updatePhoto']);
Route::delete('/news_img/{id}',[NewsController::class,'deletePhoto']);
Route::delete('/project_img/{id}',[ProjectController::class,'deletePhoto']);



Route::apiResource('/jobs',JobController::class);
