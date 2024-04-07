<?php

//use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\Admission\AdmissionController;
use App\Http\Controllers\Admin\Branch\BranchController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Departments\DepartmentsController;
use App\Http\Controllers\Admin\Finance\BillsController;
use App\Http\Controllers\Admin\Finance\FinanceController;
use App\Http\Controllers\Admin\House\HouseController;
use App\Http\Controllers\Admin\Level\LevelController;
use App\Http\Controllers\Admin\School\SchoolController;
use App\Http\Controllers\Admin\School\TermController;
use App\Http\Controllers\Admin\Student\StudentController;
use App\Http\Controllers\Admin\Student\StudentsAdmissionsController;
use App\Http\Controllers\Admin\Subjects\SubjectController;
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
    Route::get('/admin/logout', [AdminAuthController::class, 'admin_logout'])->name('admin_logout');

    /**Department to be removed**/
//    Route::get('/admin/department', [DepartmentsController::class, 'index'])->name('admin_department');
//    Route::post('/department/store', [DepartmentsController::class, 'store'])->name('new-department');
//    Route::get('/admin/department/{department_id}/edit', [DepartmentsController::class, 'edit']);
//    Route::get('/departmentsTables', 'App\Http\Controllers\Admin\Departments\DepartmentsDatatable')->name('departmentsTables');

    /** Teacher **/
    Route::get('/admin/teacher', [TeacherController::class, 'index'])->name('admin_teacher');
    Route::post('/teacher/store', [TeacherController::class, 'store'])->name('new-teacher');
    Route::get("/teacher/edit", [TeacherController::class, 'edit'])->name('edit-teacher');
    Route::put('/teacher/update', [TeacherController::class, 'update'])->name('update-teacher');
    Route::delete('/teacher/delete', [TeacherController::class, 'delete'])->name('delete-teacher');
    Route::get('/teachersTables', 'App\Http\Controllers\Admin\Teacher\TeachersDatatable')->name
    ('teachersTables');

     /** Subject **/
     Route::get('/admin/subject', [SubjectController::class, 'index'])->name('admin_subject');
     Route::post('/subject/store', [SubjectController::class, 'store'])->name('new-subject');
     Route::get("/subject/edit", [SubjectController::class, 'edit'])->name('edit-subject');
     Route::put('/subject/update', [SubjectController::class, 'update'])->name('update-subject');
     Route::delete('/subject/delete', [SubjectController::class, 'delete'])->name('delete-subject');
     Route::get('/subjectsTables', 'App\Http\Controllers\Admin\Subjects\SubjectsDatatable')->name
     ('subjectsTables');

    /**School**/
    Route::get('/admin/school', [SchoolController::class, 'index'])->name('admin_school');
    Route::put('/admin/school/update', [SchoolController::class, 'update'])->name('admin_school_update');
    /**School Term**/
    Route::post('/admin/school/term/store', [TermController::class, 'store'])->name('new-term');
    Route::get('/admin/school/term/edit', [TermController::class, 'edit'])->name('edit-term');
    Route::put('/admin/school/term/update', [TermController::class, 'update'])->name('update-term');
    Route::delete('/admin/school/term/delete', [TermController::class, 'delete'])->name('delete-term');
    Route::get('/termsTable', 'App\Http\Controllers\Admin\School\TermsDatatable')->name
    ('termsTables');
    Route::get('/getTermsBySchoolId', [TermController::class, 'getTermsBySchoolId'])->name('getTermsBySchoolId');

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
    Route::post('/school/level', [LevelController::class, 'store'])->name('new-level');
    Route::get('/school/level/edit', [LevelController::class, 'edit'])->name('edit-level');
    Route::put('/school/level/update', [LevelController::class, 'update'])->name('update-level');
    Route::delete('/school/level/delete', [LevelController::class, 'delete'])->name('delete-level');
    Route::get('/levelsTables', 'App\Http\Controllers\Admin\Level\LevelsDatatable')->name
    ('levelsTables');
    Route::get('/getLevelsByBranchId', [LevelController::class, 'getLevelsByBranchId'])->name('getLevelsByBranchId');
    Route::get('/getLevelsBySchoolId', [LevelController::class, 'getLevelsBySchoolId'])->name('getLevelsBySchoolId');

    /**House**/
    Route::get('/admin/school/house', [HouseController::class,'index'])->name('admin_school_house');
    Route::post('/school/house', [HouseController::class, 'store'])->name('new-house');
    Route::get('/school/house/edit', [HouseController::class, 'edit'])->name('edit-house');
    Route::put('/school/house/update', [HouseController::class, 'update'])->name('update-house');
    Route::delete('/school/house/delete', [HouseController::class, 'delete'])->name('delete-house');
    Route::get('/housesTables', 'App\Http\Controllers\Admin\House\HousesDatatable')->name
    ('housesTables');
    Route::get('/getHousesByBranchId', [HouseController::class, 'getHousesByBranchId'])->name('getHousesByBranchId');

    /**Category**/
    Route::get('/admin/school/category', [CategoryController::class,'index'])->name('admin_school_category');
    Route::post('/school/category', [CategoryController::class, 'store'])->name('new-category');
    Route::get('/school/category/edit', [CategoryController::class, 'edit'])->name('edit-category');
    Route::put('/school/category/update', [CategoryController::class, 'update'])->name('update-category');
    Route::delete('/school/category/delete', [CategoryController::class, 'delete'])->name('delete-category');
    Route::get('/categoriesTables', 'App\Http\Controllers\Admin\Category\CategoriesDatatable')->name
    ('categoriesTables');
    Route::get('/getCategoriesBySchoolId', [CategoryController::class, 'getCategoriesBySchoolId'])->name('getCategoriesBySchoolId');

    /**Admissions Student**/
    Route::get('/admin/student/admissions', [StudentsAdmissionsController::class, 'index'])->name('admin_student_admission');
    Route::post('/admissions/student', [StudentsAdmissionsController::class, 'store'])->name('new-student-admission');
    Route::post('/admissions/bulk-student', [StudentsAdmissionsController::class, 'StoreBulk'])->name('new-student-admission-bulk');
    Route::get('/admissions/student/edit', [StudentsAdmissionsController::class, 'edit'])->name('edit-student-admission');
    Route::put('/admissions/student/update', [StudentsAdmissionsController::class, 'update'])->name('update-student-admission');
    Route::put('/admissions/student/update-admission-status', [StudentsAdmissionsController::class, 'updateAdmissionStatus'])->name
    ('update-student-admission-status');
    Route::delete('/admissions/student/delete', [StudentsAdmissionsController::class, 'delete'])->name('delete-student-admission');
    Route::get('/studentsAdmissionsTables', 'App\Http\Controllers\Admin\Student\StudentsAdmissionsDatatable')->name
    ('studentsAdmissionsTables');

    /**Finance**/
    Route::get('/admin/finance', [FinanceController::class, 'index'])->name('admin_finance');
    Route::get('/admin/finance/expenditure', [FinanceController::class, 'expenditureView'])->name('admin_expenditure');

    /**Bills**/
    Route::get('/admin/finance/student/bills/', [FinanceController::class, 'billsView'])
        ->name('admin_student_bill');
    Route::post('admin/finance/student/new-bill', [BillsController::class, 'store'])->name('new-bill');
    Route::get('admin/finance/student/edit-bill', [BillsController::class, 'edit'])->name('edit-bill');
    Route::put('admin/finance/student/update-bill', [BillsController::class, 'update'])->name('update-bill');
    Route::delete('admin/finance/student/delete-bill', [BillsController::class, 'delete'])->name('delete-bill');
    Route::get('/billsTables', 'App\Http\Controllers\Admin\Finance\BillsDatatable')->name
    ('billsTables');
});
