<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $users = count(User::all());
    $vacancies = count(\App\Models\Vacancy::all());
    $resumes = count(\App\Models\Resume::all());
    return view('welcome', compact('users', 'vacancies', 'resumes'));
})->name('/');
Route::get('/template', function (){
   return view('layouts.admin');
});

Route::group(['middleware' => 'user'], function (){
    Route::get('user/dashboard',[App\Http\Controllers\User\DashboardController::class, 'index'])
        ->name('user.dashboard');
    Route::get('resume/create', [App\Http\Controllers\ResumeController::class, 'create'])
        ->name('resume.create');
    Route::post('resume/store', [App\Http\Controllers\ResumeController::class, 'store'])
        ->name('resume.store');
    Route::get('resume/show-my-resume/{resume}', [App\Http\Controllers\ResumeController::class, 'showMyResume'])
        ->name('user.show.resume');
    Route::delete('user/resume/delete/{resume}', [App\Http\Controllers\ResumeController::class, 'destroy'])
        ->name('resume.delete');
    Route::get('resume/index', [App\Http\Controllers\ResumeController::class, 'index'])
        ->name('resume.index');
    Route::get('user/vacancies', [App\Http\Controllers\VacancyController::class, 'allVacancies'])
        ->name('all.vacancies');
    Route::get('user/vacancy/{vacancy}', [App\Http\Controllers\VacancyController::class,'showForUser'])
        ->name('user.vacancy.show');
    Route::get('user/vacancy/{vacancy}/report/create', [App\Http\Controllers\ReportController::class, 'create'])
        ->name('user.report.create');
    Route::post('user/report/store', [App\Http\Controllers\ReportController::class, 'store'])
        ->name('user.report.store');
    Route::get('user/invites/index', [App\Http\Controllers\InviteController::class, 'indexForUser'])
        ->name('invites.for.user');
    Route::get('user/invite/{invite}', [App\Http\Controllers\InviteController::class, 'show'])
        ->name('invite.show');
    Route::delete('user/invite/delete/{invite}', [App\Http\Controllers\InviteController::class, 'destroy'])
        ->name('user.invite.delete');
    Route::get('user/resume/edit/{resume}', [App\Http\Controllers\ResumeController::class, 'edit'])
        ->name('user.resume.edit');
    Route::patch('user/resume/update/{resume}', [App\Http\Controllers\ResumeController::class, 'update'])
        ->name('user.resume.update');
});


Route::group(['middleware' => 'hr'], function (){
    Route::get('hr/dashboard',[App\Http\Controllers\HR\DashboardController::class, 'index'])
        ->name('hr.dashboard');
    Route::get('vacancy/create', [App\Http\Controllers\VacancyController::class, 'create'])
        ->name('vacancy.create');
    Route::post('vacancy/store', [App\Http\Controllers\VacancyController::class, 'store'])
        ->name('vacancy.store');
    Route::get('vacancy/index',[App\Http\Controllers\VacancyController::class, 'index'])
        ->name('vacancy.index');
    Route::get('hr/resumes', [App\Http\Controllers\ResumeController::class, 'allResumes'])
        ->name('hr.resumes');
    Route::get('hr/resume/show/{resume}', [App\Http\Controllers\ResumeController::class, 'show'])
        ->name('hr.resume.show');
    Route::get('hr/vacancy/{vacancy}', [App\Http\Controllers\VacancyController::class,'show'])
        ->name('hr.vacancy.show');
    Route::get('hr/invite/create/{report}', [App\Http\Controllers\InviteController::class, 'create'])
        ->name('invite.create');
    Route::post('hr/invite/store', [App\Http\Controllers\InviteController::class, 'store'])
        ->name('invite.store');
    Route::get('hr/reports/index', [App\Http\Controllers\ReportController::class, 'index'])
        ->name('report.index');
    Route::get('hr/report/show/{report}', [App\Http\Controllers\ReportController::class, 'show'])
        ->name('hr.report.show');
    Route::delete('hr/report/delete/{report}', [App\Http\Controllers\ReportController::class, 'destroy'])
        ->name('hr.report.delete');
    Route::delete('hr/vacancy/delete/{vacancy}', [App\Http\Controllers\VacancyController::class, 'destroy'])
        ->name('hr.vacancy.delete');

    Route::get('hr/vacancy/edit/{vacancy}', [App\Http\Controllers\VacancyController::class, 'edit'])
        ->name('vacancy.edit');
    Route::patch('hr/vacancy/update/{vacancy}', [App\Http\Controllers\VacancyController::class, 'update'])
        ->name('vacancy.update');
});

Route::get('admin/enter', [App\Http\Controllers\AdminController::class, 'enter'])
    ->name('admin.enter');
Route::post('admin/dashboard', [App\Http\Controllers\AdminController::class, 'adminDashboard'])->name('admin.dashboard');
Route::delete('admin/resume/delete/{resume}', [App\Http\Controllers\AdminController::class, 'resumeDestroy'])->name('admin.resume.delete');
Route::delete('admin/vacancy/delete/{vacancy}', [App\Http\Controllers\AdminController::class, 'vacancyDestroy'])->name('admin.vacancy.delete');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
