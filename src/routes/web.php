<?php

use App\Http\Controllers\AdminDashBoardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BriefController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\CompetencesController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\StudentDashBoardController;
use App\Http\Controllers\StudentEvalController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\TeacherStudentsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(["auth", "admin"]);

Route::get('/login', [AuthController::class, 'log_in'])->name('login')->middleware("guest");
Route::post('/submit_login', [AuthController::class, 'submit_login'], 'submit_login');
Route::post('/logout', [AuthController::class, 'log_out'])->name('logout')->middleware("auth");

Route::get('/admin/dashboard', [AdminDashBoardController::class, 'index'])->name('admin_dashboard')->middleware("admin");

Route::post('/admin/classes/assign-teachers', [ClassesController::class, 'assign_teacher'])->name('classes.assign_teacher')->middleware("admin");
Route::delete('/admin/classes/remove-teacher', [ClassesController::class, 'remove_teacher'])->name('classes.remove_teacher')->middleware("admin");
Route::resource('/admin/classes', ClassesController::class)->middleware("admin")->except(['show', 'create','edit']);


Route::resource('/admin/competences', CompetencesController::class)->middleware("admin")->except(['create','show','edit']);
Route::resource('/admin/sprints', SprintController::class)->middleware("admin")->except(['create','show','edit']);
Route::resource('/admin/users', UsersController::class)->middleware("admin")->except(['create','show','edit']);

Route::resource('/teacher/briefs', BriefController::class)->middleware("teacher");

Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher_dashboard')->middleware("teacher");
Route::get('//student/dashboard', [StudentDashBoardController::class, 'index'])->name('student_dashboard')->middleware('student');
Route::post('/student/briefs/submit', [StudentDashBoardController::class, 'submit_brief'])->name('submit_brief')->middleware('student');

Route::resource('/student/briefs', ProjectController::class)->middleware('student')->names('project');
Route::resource('/teacher/evaluations', EvaluationController::class)->middleware('teacher')->names('evaluation');
Route::get('/teacher/evaluate/{brief}/{student}', [EvaluationController::class, 'create'])
    ->name('evaluation.create_custom');
Route::get('/student/evaluations',[StudentEvalController::class,'index'])->name('student_eval')->middleware('student');
Route::get('/teacher/students', [TeacherStudentsController::class , 'index'])->name('teacher_students')->middleware('teacher');
