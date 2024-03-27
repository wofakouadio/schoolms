<?php

//use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\Branch\BranchController;
use App\Http\Controllers\Admin\Departments\DepartmentsController;
use App\Http\Controllers\Admin\Level\LevelController;
use App\Http\Controllers\Admin\School\SchoolController;
use App\Http\Controllers\Admin\Teacher\TeacherController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OnBoardingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// launch app page
Route::get('/', function () {
    return view('welcome');
});

// platform page to login
Route::get('/platform', function () {
    return view('platform');
})->name('platform');

// get started page
Route::get('/get-started', [OnBoardingController::class, 'index'])->name('onBoarding');
Route::post('/new-account', [OnBoardingController::class, 'getStarted'])->name('new-account');
Route::get('/package-selection', [OnBoardingController::class, 'packageSelection'])->name('package-selection');
Route::post('/package-selection', [OnBoardingController::class, 'processPackageSelection'])->name('school-package-selection');

//Administrator login page
Route::get('/admin/auth/', [AdminAuthController::class, 'admin_login'])->name('admin_login');
Route::get('/admin/auth/forgot-password', [AdminAuthController::class, 'forgot_password'])->name('forgot_password');
Route::post('/admin/auth/login', [AdminAuthController::class, 'admin_authentication'])->name('admin_authentication');

//Administrator Controller
Route::middleware(['auth' => 'admin'])->controller(AdminController::class)->group(function () {
    //admin dash
    Route::get('/admin/dashboard', 'index')->name('admin_dashboard');
    //department Resources
    Route::get('/admin/department', [DepartmentsController::class, 'index'])->name('admin_department');
    //post new department data
    Route::post('/department/store', [DepartmentsController::class, 'store'])->name('new-department');
    //edit department data
    Route::get('/admin/department/{department_id}/edit', [DepartmentsController::class, 'edit']);
    //DataTables of Departments
    Route::get('/departmentsTables', 'App\Http\Controllers\Admin\Departments\DepartmentsDatatable')->name('departmentsTables');
    Route::get('/admin/logout', [AdminAuthController::class, 'admin_logout'])->name('admin_logout');

    /** Teacher **/
    Route::get('/admin/teacher', [TeacherController::class, 'index'])->name('admin_teacher');
    Route::post('/teacher/store', [TeacherController::class, 'store'])->name('new-teacher');
    Route::get("/teacher/edit", [TeacherController::class, 'edit'])->name('edit-teacher');
    Route::put('/teacher/update', [TeacherController::class, 'update'])->name('update-teacher');
    Route::delete('/teacher/delete', [TeacherController::class, 'delete'])->name('delete-teacher');
    Route::get('/teachersTables', 'App\Http\Controllers\Admin\Teacher\TeachersDatatable')->name
    ('teachersTables');

    /**School**/
    Route::get('/admin/school', [SchoolController::class, 'index'])->name('admin_school');
    Route::put('/admin/school/update', [SchoolController::class, 'update'])->name('admin_school_update');

    /**Branch**/
    Route::get('/admin/school/branch', [BranchController::class, 'index'])->name('admin_school_branch');
    Route::post('/school/branch', [BranchController::class, 'store'])->name('new-branch');
    Route::get('/school/branch/edit', [BranchController::class, 'edit'])->name('edit-branch');
    Route::put('/school/branch/update', [BranchController::class, 'update'])->name('update-branch');
    Route::delete('/school/branch/delete', [BranchController::class, 'delete'])->name('delete-branch');
    Route::get('/branchesTables', 'App\Http\Controllers\Admin\Branch\BranchesDatatable')->name
    ('branchesTables');
    Route::get('/getBranchesBySchoolId', [BranchController::class, 'getBranchesBySchoolId'])->name('getBranchesBySchoolId');

    /**Level**/
    Route::get('/admin/school/level', [LevelController::class,'index'])->name('admin_school_level');
});
