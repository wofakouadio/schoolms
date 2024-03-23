<?php

//use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\OnBoardingController;
use App\Http\Controllers\ProfileController;
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
Route::get('/get-started', function () {
    return view('get-started.register');
});

// register as new school and administrator

//Route::post('/new-account', [AdminController::class, 'getStarted']);

Route::post('/new-account',[OnBoardingController::class, 'getStarted']);

//Administrator login page
Route::get('/admin/auth/', [AdminAuthController::class, 'admin_login'])->name('admin_login');
Route::get('/admin/auth/forgot-password', [AdminAuthController::class, 'forgot_password'])->name('forgot_password');
Route::post('/admin/auth/login', [AdminAuthController::class, 'admin_authentication'])->name('admin_authentication');

//Administrator Controller
Route::middleware(['auth'=>'admin'])->controller(AdminController::class)->group(function (){
    //admin dash
    Route::get('/admin/dashboard', 'index')->name('admin_dashboard');
    //department Resources
    Route::get('/admin/department', [DepartmentsController::class, 'index']);
    //create new department page
    Route::get('/admin/department/new', [DepartmentsController::class, 'create'])->name('new-department');
    //post new department data
    Route::post('/department/store', [DepartmentsController::class, 'store']);
    //edit department data
    Route::get('/admin/department/{department_id}/edit', [DepartmentsController::class, 'edit']);
    //DataTables of Departments
//    Route::get('/departmentsTables', [DepartmentsController::class, 'DepartmentsDataTables'])->name
//    ('departmentsTables')  ;
    Route::get('/admin/logout', [AdminAuthController::class, 'admin_logout'])->name('admin_logout');
});
//middleware(['auth:admin'])->


Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
