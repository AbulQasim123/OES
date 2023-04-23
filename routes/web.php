<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::fallback(function(){
    return view('error.404');
});

Route::get('/login', function () {
    return redirect('/');
});
Route::get('/register', function () {
    return redirect('/');
});
Route::controller(AuthController::class)->group(function () {
    
    Route::get('/', 'loadLoginRegister');

    Route::post('/register', 'Register')->name('register');
    Route::post('/login', 'Login')->name('login');
    Route::get('/logout', 'Logout');
        // Forget Password
    Route::get('/forget-password', 'ForgetPasswordLoad');
    Route::post('/forget-password', 'ForgetPassword')->name('ForgetPassword');
        // Reset Password
    Route::get('/reset-password', 'ResetPasswordLoad');
    Route::post('/reset-password', 'ResetPassword')->name('ResetPassword');
});
    // Admin Middleware
Route::group(['middleware'=> ['web','checkAdmin']], function(){
    Route::get('admin/dashboard', [AuthController::class,'AdminDashboard']);
        // Add Subject route
    Route::post('add-Subject', [AdminController::class,'AddSubject'])->name('addSubject');
    Route::post('edit-Subject', [AdminController::class,'EditSubject'])->name('editSubject');
    Route::post('delete-Subject', [AdminController::class,'DeleteSubject'])->name('deleteSubject');
        // Add Exam route
    Route::get('admin/exams', [AdminController::class,'ExamDashboard']);
    Route::post('add-exam', [AdminController::class,'AddExam'])->name('addExam');
    Route::get('get-exam-detail/{id}', [AdminController::class,'GetExamDetail'])->name('getExamDetail');
    Route::post('edit-exam', [AdminController::class,'EditExam'])->name('editExam');
    Route::post('delete-exam', [AdminController::class,'DeleteExam'])->name('deleteExam');

        // Add Question and Answer
    Route::get('/admin/quesandans', [AdminController::class,'QuesAnsDashboard']);
    Route::post('/add-ques-ans', [AdminController::class,'AddQuesAns'])->name('Addquesand');
    // Route::post('/edit-ques-ans', [AdminController::class,'EdutQuesAns'])->name('EdutQuesAns');
    Route::post('/delete-ques-ans', [AdminController::class,'DeleteQuesAns'])->name('DeleteQuesAns');

        // Student Route
    Route::get('admin/students', [AdminController::class,'StudentDashoard']);
    Route::post('add-students', [AdminController::class,'AddStudent'])->name('AddStudent');
    Route::post('edit-students', [AdminController::class,'EditStudent'])->name('EditStudent');
    Route::post('delete-students', [AdminController::class,'DeleteStudent'])->name('DeleteStudent');

        // Upload Modules
    Route::get('/admin/show/module', [AdminController::class,'showModule'])->name('show.module');
    Route::get('/admin/fetch/module', [AdminController::class,'fetchModule'])->name('fetch.module');
    Route::post('/admin/upload/module', [AdminController::class,'uploadModule'])->name('upload.module');
    Route::get('/admin/show/allmodule', [AdminController::class,'showAllModule'])->name('get.module');
});
    // Student Middleware
Route::group(['middleware'=> ['web','checkStudent']], function(){
    Route::get('/dashboard', [AuthController::class, 'StudentDashboard']);
});

