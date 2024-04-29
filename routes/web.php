<?php

//use App\Http\Controllers\AdminController;

use App\Http\Controllers\Admin\Assessment\EndOfTermController;
use App\Http\Controllers\Admin\Assessment\MidTermController;
use App\Http\Controllers\Admin\Assessment\StudentMockController;
use App\Http\Controllers\Admin\Report\Attendance\AttendanceReportController;
use App\Http\Controllers\Admin\Report\MidTerm\MidTermReportController;
use App\Http\Controllers\Admin\Report\Mock\MockReportController;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Admin\Assessment\StudentAttendanceController;
use App\Http\Controllers\Admin\CustomJSController;
use App\Http\Controllers\Admin\Departments\AssignLevelToDepartmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OnBoardingController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\House\HouseController;
use App\Http\Controllers\Admin\Level\LevelController;
use App\Http\Controllers\Admin\School\TermController;
use App\Http\Controllers\Admin\Branch\BranchController;
use App\Http\Controllers\Admin\Finance\BillsController;
use App\Http\Controllers\Admin\School\SchoolController;
use App\Http\Controllers\Admin\Finance\FinanceController;
use App\Http\Controllers\Admin\Student\StudentController;
use App\Http\Controllers\Admin\Teacher\TeacherController;
use App\Http\Controllers\Admin\Subjects\SubjectController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Admission\AdmissionController;
use App\Http\Controllers\Admin\Departments\DepartmentsController;
use App\Http\Controllers\Admin\Student\StudentsAdmissionsController;
use App\Http\Controllers\Admin\Subjects\AssignSubjectToLevel\AssignSubjectToLevelController;

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

    /**Department**/
    Route::get('/admin/department', [DepartmentsController::class, 'index'])->name('admin_department');
    Route::post('/department/store', [DepartmentsController::class, 'store'])->name('new-department');
    Route::get('/admin/department/edit', [DepartmentsController::class, 'edit'])->name('edit-department');
    Route::put('/admin/department/update', [DepartmentsController::class, 'update'])->name('update-department');
    Route::delete('/admin/department/delete', [DepartmentsController::class, 'delete'])->name('delete-department');
    Route::get('/getDepartmentsBySchoolId', [DepartmentsController::class, 'getDepartmentsBySchoolId'])->name('getDepartmentsBySchoolId');
    Route::get('/departmentsTables', 'App\Http\Controllers\Admin\Departments\DepartmentsDatatable')->name('departmentsTables');
    route::get('/getLevelsBasedOnDepartmentAndBranch', [DepartmentsController::class, 'getLevelsBasedOnDepartmentAndBranch'])->name('getLevelsBasedOnDepartmentAndBranch');
    Route::post('/admin/department/new-assign-department-to-level', [DepartmentsController::class, 'newassignleveltodepartment'])
        ->name('new-assign-department-to-level');
    /**Custom JS Controller**/
    Route::get('/getLevelsByDepartmentBranchSchoolId', [CustomJSController::class, 'getLevelsByDepartmentBranchSchoolId'])->name('getLevelsByDepartmentBranchSchoolId');
    Route::get('/getSubjectsByLevelDepartmentBranchSchoolId', [CustomJSController::class, 'getSubjectsByLevelDepartmentBranchSchoolId'])->name('getSubjectsByLevelDepartmentBranchSchoolId');

    /**Assign Department to Level**/
//    Route::get('/admin/assign/assign-department-to-level', [AssignLevelToDepartmentController::class, 'index'])->name
//    ('admin_assign_department_level');
//    Route::post('/admin/assign/new-assign-department-to-level', [AssignLevelToDepartmentController::class, 'store'])
//        ->name('new-assign-department-to-level');
//    Route::get('/admin/assign/edit-assign-department-to-level', [AssignLevelToDepartmentController::class, 'edit'])
//        ->name('edit-assign-department-to-level');
//    Route::put('/admin/assign/update-assign-department-to-level', [AssignLevelToDepartmentController::class, 'update'])
//        ->name('update-assign-department-to-level');
//    Route::delete('/admin/assign/delete-assign-department-to-level', [AssignLevelToDepartmentController::class, 'delete'])
//        ->name('delete-assign-department-to-level');
//    Route::get('/assignDepartmentToLevelTables', 'App\Http\Controllers\Admin\Departments\AssignDepartmentToLevelDataTable')->name('assignDepartmentToLevelTables');

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
     Route::get('/getSubjectInCheckboxBySchoolId', [SubjectController::class, 'getSubjectInCheckboxBySchoolId'])->name('getSubjectInCheckboxBySchoolId');


     Route::get("/assignSubjectToLevel/create", [AssignSubjectToLevelController::class, 'create'])->name('assign-subject-to-level');

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
    Route::get('/getActiveTermBySchoolID', [TermController::class, 'getActiveTermBySchoolID'])->name('getActiveTermBySchoolID');

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
    Route::get('/getLevelsInCheckboxBySchoolId', [LevelController::class, 'getLevelsInCheckboxBySchoolId'])->name('getLevelsInCheckboxBySchoolId');

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
    Route::post('/admissions/bulk-student', [StudentsAdmissionsController::class, 'storebulk'])->name('new-student-admission-bulk');
    Route::get('/admissions/student/edit', [StudentsAdmissionsController::class, 'edit'])->name('edit-student-admission');
    Route::put('/admissions/student/update', [StudentsAdmissionsController::class, 'update'])->name('update-student-admission');
    Route::put('/admissions/student/update-admission-status', [StudentsAdmissionsController::class, 'updateAdmissionStatus'])->name
    ('update-student-admission-status');
    Route::delete('/admissions/student/delete', [StudentsAdmissionsController::class, 'delete'])->name('delete-student-admission');
    Route::get('/studentsAdmissionsTables', 'App\Http\Controllers\Admin\Student\StudentsAdmissionsDatatable')->name
    ('studentsAdmissionsTables');

    /**Students**/
    Route::get('/admin/student', [StudentController::class, 'index'])->name('admin_student');
    Route::get('/studentsListTables', 'App\Http\Controllers\Admin\Student\StudentsListDatatable')->name
    ('studentsListTables');

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

    /**Attendance**/
    Route::get('/admin/student/attendance/', [StudentAttendanceController::class, 'index'])->name('admin_student_attendance');
    Route::get('/get-attendance-sheet', 'App\Http\Controllers\Admin\Assessment\StudentAttendanceDatatable')->name('get-attendance-sheet');
    Route::get('/get-subject', [StudentAttendanceController::class, 'get_subject'])->name('get-subject');
    Route::post('/mark-student-attendance', [StudentAttendanceController::class, 'store'])->name('mark-student-attendance');

    /**Mock**/
    Route::get('/admin/student/mock', [StudentMockController::class, 'index'])->name('admin_student_mock');
    Route::post('/new-mock-setup', [StudentMockController::class, 'new_mock_setup'])->name('new-mock-setup');
    Route::get('/edit-mock-setup', [StudentMockController::class, 'edit'])->name('edit-mock-setup');
    Route::put('/update-mock-setup', [StudentMockController::class, 'update_mock_setup'])->name('update-mock-setup');
    Route::delete('/delete-mock-setup', [StudentMockController::class, 'delete_mock_setup'])->name('delete-mock-setup');
    Route::get('/getMocksInSelectBasedOnSchool', [StudentMockController::class, 'getMocksInSelectBasedOnSchool'])->name('getMocksInSelectBasedOnSchool');
    Route::post('/assign-subject-to-mock', [StudentMockController::class, 'assignSubjectToMock'])->name('assign-subject-to-mock');
    Route::get('/getSubjectsBasedOnMock', [StudentMockController::class, 'getSubjectsBasedOnMock'])->name('getSubjectsBasedOnMock');
    Route::get('/MockDatatable', 'App\Http\Controllers\Admin\Assessment\MockDatatable')->name('MockDatatable');
        /*****************/
    Route::get('/admin/student/mock/examination', [StudentMockController::class, 'examinationView'])->name('admin_student_mock_examination');
    Route::get('/getStudentsBasedOnLevel', [StudentMockController::class, 'getStudentsBasedOnLevel'])->name('getStudentsBasedOnLevel');
    Route::get('/get-student-to-mock', [StudentMockController::class, 'create'])->name('get-student-to-mock');
    Route::post('/new-student-mock-entry', [StudentMockController::class, 'store'])->name('new-student-mock-entry');
    Route::get('/StudentsMockDatatable', 'App\Http\Controllers\Admin\Assessment\StudentsMockDatatable')->name('StudentsMockDatatable');
    Route::get('/export-students-mock-list-in-excel', [StudentMockController::class, 'export_Students_mock_list'])->name
    ('export-students-mock-list-in-excel');

    /**Mid-Term**/
    Route::get("/admin/student/mid-term", [MidTermController::class, 'index'])->name('admin_student_mid_term');
    Route::get("/admin/student/mid-term/create", [MidTermController::class, 'create'])->name('get-student-to-mid-term');
    Route::post("/new-student-mid-term-entry", [MidTermController::class, 'store'])->name("new-student-mid-term-entry");
    Route::get('/StudentsMidTermDatatable', 'App\Http\Controllers\Admin\Assessment\StudentsMidTermDatatable')->name('StudentsMidTermTable');

    /**End of Sem**/
    Route::get("/admin/student/end-of-term", [EndOfTermController::class, 'index'])->name("admin_student_end_term");
    Route::get("/get-student-to-end-term", [EndOfTermController::class, 'create'])->name("get-student-to-end-term");
    Route::post("/new-student-end-term-entry", [EndOfTermController::class, 'store'])->name("new-student-end-term-entry");
    Route::get('/StudentsEndTermDataTables', 'App\Http\Controllers\Admin\Assessment\StudentsEndTermDataTables')->name('StudentsEndTermDataTables');

    /**Reports**/
        /**Attendance**/
    Route::get("/admin/report/attendance", [AttendanceReportController::class, 'index'])->name("admin_student_attendance_report");
    Route::get("/get-attendance-dates", [AttendanceReportController::class, 'get_attendance_dates'])->name('get_attendance_dates');
    Route::get("/get-levels-by-department", [AttendanceReportController::class, 'get_levels_by_department'])->name('get_levels_by_department');

        /**Mid-Term**/
    Route::get("/admin/report/mid-term", [MidTermReportController::class, 'index'])->name("admin_student_mid_term_report");

        /**Mock**/
    Route::get("/admin/report/mock", [MockReportController::class, 'index'])->name("admin_student_mock_report");
    Route::get("/get-mock-report", [MockReportController::class, 'get_mock_report'])->name('get_mock_report');
});
