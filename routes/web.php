<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
namespace App\Http\Controllers\Teacher;
//use App\Http\Controllers\AdminController;

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

////Administrator login page
//Route::get('/admin/auth/', [AdminAuthController::class, 'admin_login'])->name('admin_login');
//Route::get('/admin/auth/forgot-password', [AdminAuthController::class, 'forgot_password'])->name('forgot_password');
//Route::post('/admin/auth/login', [AdminAuthController::class, 'admin_authentication'])->name('admin_authentication');
//
////Administrator Controller
//Route::middleware(['auth' => 'admin'])->controller(AdminController::class)->group(function () {
//    //admin dash
//    Route::get('/admin/dashboard', 'index')->name('admin_dashboard');
//    Route::get('/admin/logout', [AdminAuthController::class, 'admin_logout'])->name('admin_logout');
//
//    /**Department**/
//    Route::get('/admin/department', [DepartmentsController::class, 'index'])->name('admin_department');
//    Route::post('/department/store', [DepartmentsController::class, 'store'])->name('new-department');
//    Route::get('/admin/department/edit', [DepartmentsController::class, 'edit'])->name('edit-department');
//    Route::put('/admin/department/update', [DepartmentsController::class, 'update'])->name('update-department');
//    Route::delete('/admin/department/delete', [DepartmentsController::class, 'delete'])->name('delete-department');
//    Route::get('/getDepartmentsBySchoolId', [DepartmentsController::class, 'getDepartmentsBySchoolId'])->name('getDepartmentsBySchoolId');
//    Route::get('/departmentsTables', 'App\Http\Controllers\Admin\Departments\DepartmentsDatatable')->name('departmentsTables');
//    route::get('/getLevelsBasedOnDepartmentAndBranch', [DepartmentsController::class, 'getLevelsBasedOnDepartmentAndBranch'])->name('getLevelsBasedOnDepartmentAndBranch');
//    Route::post('/admin/department/new-assign-department-to-level', [DepartmentsController::class, 'newassignleveltodepartment'])
//        ->name('new-assign-department-to-level');
//    /**Custom JS Controller**/
//    Route::get('/getLevelsByDepartmentBranchSchoolId', [CustomJSController::class, 'getLevelsByDepartmentBranchSchoolId'])->name('getLevelsByDepartmentBranchSchoolId');
//    Route::get('/getSubjectsByLevelDepartmentBranchSchoolId', [CustomJSController::class, 'getSubjectsByLevelDepartmentBranchSchoolId'])->name('getSubjectsByLevelDepartmentBranchSchoolId');
//    /** Teacher **/
//    Route::get('/admin/teacher', [TeacherController::class, 'index'])->name('admin_teacher');
//    Route::post('/teacher/store', [TeacherController::class, 'store'])->name('new-teacher');
//    Route::get("/teacher/edit", [TeacherController::class, 'edit'])->name('edit-teacher');
//    Route::put('/teacher/update', [TeacherController::class, 'update'])->name('update-teacher');
//    Route::delete('/teacher/delete', [TeacherController::class, 'delete'])->name('delete-teacher');
//    Route::get('/teachersTables', 'App\Http\Controllers\Admin\Teacher\TeachersDatatable')->name
//    ('teachersTables');
//    /**Assign level to teacher**/
//    Route::get('/admin/teacher/assign-levels-to-teacher', [TeacherController::class, 'assignLevelsToTeacherIndex'])
//        ->name('assign-levels-to-teacher');
//    /**Assign Subjects to Teacher**/
//    Route::get('/getTeachersBySchool', [TeacherController::class, 'getTeachersBySchool'])->name('getTeachersBySchool');
//    Route::post('/assign-subjects-to-teacher', [TeacherController::class, 'assign_subjects_to_teacher'])->name('assign-subjects-to-teacher');
//
//     /** Subject **/
//     Route::get('/admin/subject', [SubjectController::class, 'index'])->name('admin_subject');
//     Route::post('/subject/store', [SubjectController::class, 'store'])->name('new-subject');
//     Route::get("/subject/edit", [SubjectController::class, 'edit'])->name('edit-subject');
//     Route::put('/subject/update', [SubjectController::class, 'update'])->name('update-subject');
//     Route::delete('/subject/delete', [SubjectController::class, 'delete'])->name('delete-subject');
//     Route::get('/subjectsTables', 'App\Http\Controllers\Admin\Subjects\SubjectsDatatable')->name
//     ('subjectsTables');
//     Route::get('/getSubjectInCheckboxBySchoolId', [SubjectController::class, 'getSubjectInCheckboxBySchoolId'])->name('getSubjectInCheckboxBySchoolId');
//
//    Route::get("/assignSubjectToLevel/create", [AssignSubjectToLevelController::class, 'create'])->name('assign-subject-to-level');
//
//    /**School**/
//    Route::get('/admin/school', [SchoolController::class, 'index'])->name('admin_school');
//    Route::get('/school_data', [SchoolController::class, 'school_data'])->name('school_data');
//    Route::put('/admin/school/update', [SchoolController::class, 'update'])->name('admin_school_update');
//    /**School Term**/
//    Route::post('/admin/school/term/store', [TermController::class, 'store'])->name('new-term');
//    Route::get('/admin/school/term/edit', [TermController::class, 'edit'])->name('edit-term');
//    Route::put('/admin/school/term/update', [TermController::class, 'update'])->name('update-term');
//    Route::put('/admin/school/term/update-status', [TermController::class, 'update_status'])->name('update-term-status');
//    Route::delete('/admin/school/term/delete', [TermController::class, 'delete'])->name('delete-term');
//    Route::get('/termsTable', 'App\Http\Controllers\Admin\School\TermsDatatable')->name('termsTables');
//    Route::get('/getTermsBySchoolId', [TermController::class, 'getTermsBySchoolId'])->name('getTermsBySchoolId');
//    Route::get('/getActiveTermBySchoolID', [TermController::class, 'getActiveTermBySchoolID'])->name('getActiveTermBySchoolID');
//
//    /**Branch**/
//    Route::get('/admin/school/branch', [BranchController::class, 'index'])->name('admin_school_branch');
//    Route::post('/school/branch', [BranchController::class, 'store'])->name('new-branch');
//    Route::get('/school/branch/edit', [BranchController::class, 'edit'])->name('edit-branch');
//    Route::put('/school/branch/update', [BranchController::class, 'update'])->name('update-branch');
//    Route::delete('/school/branch/delete', [BranchController::class, 'delete'])->name('delete-branch');
//    Route::get('/branchesTables', 'App\Http\Controllers\Admin\Branch\BranchesDatatable')->name('branchesTables');
//    Route::get('/getBranchesBySchoolId', [BranchController::class, 'getBranchesBySchoolId'])->name('getBranchesBySchoolId');
//
//    /**Level**/
//    Route::get('/admin/school/level', [LevelController::class, 'index'])->name('admin_school_level');
//    Route::post('/school/level', [LevelController::class, 'store'])->name('new-level');
//    Route::get('/school/level/edit', [LevelController::class, 'edit'])->name('edit-level');
//    Route::put('/school/level/update', [LevelController::class, 'update'])->name('update-level');
//    Route::delete('/school/level/delete', [LevelController::class, 'delete'])->name('delete-level');
//    Route::get('/levelsTables', 'App\Http\Controllers\Admin\Level\LevelsDatatable')->name('levelsTables');
//    Route::get('/getLevelsByBranchId', [LevelController::class, 'getLevelsByBranchId'])->name('getLevelsByBranchId');
//    Route::get('/getLevelsBySchoolId', [LevelController::class, 'getLevelsBySchoolId'])->name('getLevelsBySchoolId');
//    Route::get('/getLevelsInCheckboxBySchoolId', [LevelController::class, 'getLevelsInCheckboxBySchoolId'])->name('getLevelsInCheckboxBySchoolId');
//    Route::post('/assign_subjects_to_level', [LevelController::class, 'assign_subjects_to_level'])->name('assign_subjects_to_level');
//
//    /**House**/
//    Route::get('/admin/school/house', [HouseController::class, 'index'])->name('admin_school_house');
//    Route::post('/school/house', [HouseController::class, 'store'])->name('new-house');
//    Route::get('/school/house/edit', [HouseController::class, 'edit'])->name('edit-house');
//    Route::put('/school/house/update', [HouseController::class, 'update'])->name('update-house');
//    Route::delete('/school/house/delete', [HouseController::class, 'delete'])->name('delete-house');
//    Route::get('/housesTables', 'App\Http\Controllers\Admin\House\HousesDatatable')->name('housesTables');
//    Route::get('/getHousesByBranchId', [HouseController::class, 'getHousesByBranchId'])->name('getHousesByBranchId');
//
//    /**Category**/
//    Route::get('/admin/school/category', [CategoryController::class, 'index'])->name('admin_school_category');
//    Route::post('/school/category', [CategoryController::class, 'store'])->name('new-category');
//    Route::get('/school/category/edit', [CategoryController::class, 'edit'])->name('edit-category');
//    Route::put('/school/category/update', [CategoryController::class, 'update'])->name('update-category');
//    Route::delete('/school/category/delete', [CategoryController::class, 'delete'])->name('delete-category');
//    Route::get('/categoriesTables', 'App\Http\Controllers\Admin\Category\CategoriesDatatable')->name('categoriesTables');
//    Route::get('/getCategoriesBySchoolId', [CategoryController::class, 'getCategoriesBySchoolId'])->name('getCategoriesBySchoolId');
//
//    /**Admissions Student**/
//    Route::get('/admin/student/admissions', [StudentsAdmissionsController::class, 'index'])->name('admin_student_admission');
//    Route::post('/admissions/student', [StudentsAdmissionsController::class, 'store'])->name('new-student-admission');
//    Route::post('/admissions/bulk-student', [StudentsAdmissionsController::class, 'storebulk'])->name('new-student-admission-bulk');
//    Route::get('/admissions/student/edit', [StudentsAdmissionsController::class, 'edit'])->name('edit-student-admission');
//    Route::put('/admissions/student/update', [StudentsAdmissionsController::class, 'update'])->name('update-student-admission');
//    Route::put('/admissions/student/update-admission-status', [StudentsAdmissionsController::class, 'updateAdmissionStatus'])->name('update-student-admission-status');
//    Route::delete('/admissions/student/delete', [StudentsAdmissionsController::class, 'delete'])->name('delete-student-admission');
//    Route::get('/studentsAdmissionsTables', 'App\Http\Controllers\Admin\Student\StudentsAdmissionsDatatable')->name('studentsAdmissionsTables');
//
//    /**Students**/
//    Route::get('/admin/student', [StudentController::class, 'index'])->name('admin_student');
//    Route::get('/studentsListTables', 'App\Http\Controllers\Admin\Student\StudentsListDatatable')->name('studentsListTables');
//
//    /**Finance**/
//    Route::get('/admin/finance', [FinanceController::class, 'index'])->name('admin_finance');
//    Route::get('/admin/finance/expenditure', [FinanceController::class, 'expenditureView'])->name('admin_expenditure');
//
//    /**Bills**/
//    Route::get('/admin/finance/student/bills/', [FinanceController::class, 'billsView'])
//        ->name('admin_student_bill');
//    Route::post('admin/finance/student/new-bill', [BillsController::class, 'store'])->name('new-bill');
//    Route::get('admin/finance/student/edit-bill', [BillsController::class, 'edit'])->name('edit-bill');
//    Route::put('admin/finance/student/update-bill', [BillsController::class, 'update'])->name('update-bill');
//    Route::delete('admin/finance/student/delete-bill', [BillsController::class, 'delete'])->name('delete-bill');
//    Route::get('/billsTables', 'App\Http\Controllers\Admin\Finance\BillsDatatable')->name('billsTables');
//
//    /**Attendance**/
//    Route::get('/admin/student/attendance/', [StudentAttendanceController::class, 'index'])->name('admin_student_attendance');
//    Route::get('/get-attendance-sheet', 'App\Http\Controllers\Admin\Assessment\StudentAttendanceDatatable')->name('get-attendance-sheet');
//    Route::get('/get-subject', [StudentAttendanceController::class, 'get_subject'])->name('get-subject');
//    Route::post('/mark-student-attendance', [StudentAttendanceController::class, 'store'])->name('mark-student-attendance');
//
//    /**Mock**/
//    Route::get('/admin/student/mock', [StudentMockController::class, 'index'])->name('admin_student_mock');
//    Route::post('/new-mock-setup', [StudentMockController::class, 'new_mock_setup'])->name('new-mock-setup');
//    Route::get('/edit-mock-setup', [StudentMockController::class, 'edit'])->name('edit-mock-setup');
//    Route::put('/update-mock-setup', [StudentMockController::class, 'update_mock_setup'])->name('update-mock-setup');
//    Route::delete('/delete-mock-setup', [StudentMockController::class, 'delete_mock_setup'])->name('delete-mock-setup');
//    Route::get('/getMocksInSelectBasedOnSchool', [StudentMockController::class, 'getMocksInSelectBasedOnSchool'])->name('getMocksInSelectBasedOnSchool');
//    Route::post('/assign-subject-to-mock', [StudentMockController::class, 'assignSubjectToMock'])->name('assign-subject-to-mock');
//    Route::get('/getSubjectsBasedOnMock', [StudentMockController::class, 'getSubjectsBasedOnMock'])->name('getSubjectsBasedOnMock');
//    Route::get('/MockDatatable', 'App\Http\Controllers\Admin\Assessment\MockDatatable')->name('MockDatatable');
//    /*****************/
//    Route::get('/admin/student/mock/examination', [StudentMockController::class, 'examinationView'])->name('admin_student_mock_examination');
//    Route::get('/getStudentsBasedOnLevel', [StudentMockController::class, 'getStudentsBasedOnLevel'])->name('getAdminStudentsBasedOnLevel');
//    Route::get('/get-student-to-mock', [StudentMockController::class, 'create'])->name('get-student-to-mock');
//    Route::post('/new-student-mock-entry', [StudentMockController::class, 'store'])->name('new-student-mock-entry');
//    Route::get('/StudentsMockDatatable', 'App\Http\Controllers\Admin\Assessment\StudentsMockDatatable')->name('StudentsMockDatatable');
//    Route::get('/export-students-mock-list-in-excel', [StudentMockController::class, 'export_Students_mock_list'])->name('export-students-mock-list-in-excel');
//
//    /**Mid-Term**/
//    Route::get("/admin/student/mid-term", [MidTermController::class, 'index'])->name('admin_student_mid_term');
//    Route::get("/admin/student/mid-term/create", [MidTermController::class, 'create'])->name('get-student-to-mid-term');
//    Route::post("/new-student-mid-term-entry", [MidTermController::class, 'store'])->name("new-student-mid-term-entry");
//    Route::get('/StudentsMidTermDatatable', 'App\Http\Controllers\Admin\Assessment\StudentsMidTermDatatable')->name('StudentsMidTermTable');
//
//    /**End of Sem**/
//    Route::get("/admin/student/end-of-term", [EndOfTermController::class, 'index'])->name("admin_student_end_term");
//    Route::get("/get-student-to-end-term", [EndOfTermController::class, 'create'])->name("get-student-to-end-term");
//    Route::post("/new-student-end-term-entry", [EndOfTermController::class, 'store'])->name("new-student-end-term-entry");
//    Route::get('/StudentsEndTermDataTables', 'App\Http\Controllers\Admin\Assessment\StudentsEndTermDataTables')->name('StudentsEndTermDataTables');
//
//    /**Subject**/
//    Route::get('/admin/school/subject', [SubjectsController::class, 'index'])->name('admin_school_subject');
//    Route::post('/new-subject', [SubjectsController::class, 'store'])->name('new_subject');
//    Route::get('/edit-subject', [SubjectsController::class, 'edit'])->name('edit_subject');
//    Route::put('/update-subject', [SubjectsController::class, 'update'])->name('update_subject');
//    Route::delete('/delete-subject', [SubjectsController::class, 'delete'])->name('delete_subject');
//    Route::get('/getSubjectsInCheckboxes', [SubjectsController::class, 'get_subjects_in_checkboxes'])->name('get_subjects_in_checkboxes');
//    Route::get('/subjects_datatables', 'App\Http\Controllers\Admin\Subjects\SubjectDatatable')->name('subjects_datatables');
//    Route::get("/getSubjectsByLevel", [SubjectsController::class, 'getSubjectsByLevel'])->name('get_subjects_by_level');
//
//    /**Reports**/
//    /**Attendance**/
//    Route::get("/admin/report/attendance", [AttendanceReportController::class, 'index'])->name("admin_student_attendance_report");
//    Route::get("/get-attendance-dates", [AttendanceReportController::class, 'get_attendance_dates'])->name('get_attendance_dates');
//    Route::get("/get-levels-by-department", [AttendanceReportController::class, 'get_levels_by_department'])->name('get_levels_by_department');
//
//    /**Mock**/
//    Route::get("/admin/report/mock", [MockReportController::class, 'index'])->name("admin_student_mock_report");
////    Route::get("/get-mock-report", [MockReportController::class, 'get_mock_report'])->name('get_mock_report');
//    Route::post('/download_mock_report', [MockReportController::class, 'download_mock_report'])->name('download_mock_report');
//    Route::post('/preview_mock_report', [MockReportController::class, 'preview_mock_report'])->name('preview_mock_report');
//
//    /**Mid-Term**/
//    Route::get("/admin/report/mid-term", [MidTermReportController::class, 'index'])->name("admin_student_mid_term_report");
//    Route::get("/get-mid-term-report", [MidTermReportController::class, 'get_mid_term_report'])->name("get_mid_term_report");
//
//    /**End 0f Term**/
//    Route::get("/admin/report/end-of-term", [EndTermReportController::class, 'index'])->name("admin_student_end_term_report");
//    Route::get("/get-end-of-term-report", [EndTermReportController::class, 'get_end_of_term_report'])->name("get_end_of_term_report");
//
//    /**Account Permission**/
//    Route::get('/admin/users/permission', [AccountPermissionController::class,
//    'index'])->name('admin_user_account_permission');
//    Route::post('/add-new-user', [AccountPermissionController::class, 'store'])->name('add-new-user');
//
//});


////Teacher login page
//Route::get('teacher/auth/', [TeacherAuthController::class, 'teacher_login'])->name('teacher_login');
//Route::get('/teacher/auth/forgot-password', [TeacherAuthController::class, 'forgot_password'])->name('teacher_forgot_password');
//Route::post('/teacher/auth/login', [TeacherAuthController::class, 'teacher_authentication'])->name('teacher_authentication');
//
////Teacher User Controller
//Route::middleware(['auth' => 'teacher'])->controller(TeacherUserController::class)->group(function (){
//    Route::get('/teacher/dashboard', 'index')->name('teacher_dashboard');
//    Route::get('/getActiveTermBySchoolID', 'getActiveTermBySchoolID')->name('getTeacherActiveTermBySchoolID');
//    Route::get('/getTermsBySchoolId',  'getTermsBySchoolId')->name('getTeacherTermsBySchoolId');
//    Route::get('/teacher/logout', [TeacherAuthController::class, 'teacher_logout'])->name('teacher_logout');
//
//    /**Profile**/
//    Route::get('/teacher/profile', [TeacherProfileController::class, 'index'])->name('teacher_profile');
//    Route::get('/teacher/school_data', [TeacherProfileController::class, 'school_data'])->name('teacher_school_data');
//
//    /**Levels/Classes**/
//    Route::get('/teacher/levels', [TeacherLevelController::class, 'index'])->name('teacher_levels');
//    Route::get('/getLevelsBySchoolId', [TeacherLevelController::class, 'getLevelsBySchoolId'])->name('getTeacherLevelsBySchoolId');
//
//    /**Mock Assessment**/
//    Route::get('/teacher/assessment/mock', [TeacherMockController::class, 'index'])->name('teacher_mock_assessment');
//    Route::get('/getMocksInSelectBasedOnSchool', [TeacherMockController::class, 'getMocksInSelectBasedOnSchool'])->name('getTeacherMocksInSelectBasedOnSchool');
//    Route::get('/getStudentsBasedOnLevel', [TeacherMockController::class, 'getStudentsBasedOnLevel'])->name('getTeacherStudentsBasedOnLevel');
//    Route::get('/get-student-to-mock', [TeacherMockController::class, 'create'])->name('get-teacher-student-to-mock');
//    Route::post('/new-student-mock-entry', [TeacherMockController::class, 'store'])->name('new-teacher-student-mock-entry');
//
//    /**MidTerm Assessment**/
//    Route::get('/teacher/assessment/mid-term', [TeacherMidTermController::class, 'index'])->name('teacher_mid_term_assessment');
//    Route::get("/teacher/student/mid-term/create", [TeacherMidTermController::class, 'create'])->name('get-teacher-student-to-mid-term');
//    Route::post("/new-student-mid-term-entry", [TeacherMidTermController::class, 'store'])->name("new-teacher-student-mid-term-entry");
//
//    /**End of Term Assessment**/
//    Route::get("/teacher/assessment/end-of-term", [TeacherEndOfTermController::class, 'index'])->name("teacher_end_term_assessment");
//    Route::get("/get-student-to-end-term", [TeacherEndOfTermController::class, 'create'])->name("get-teacher-student-to-end-term");
//    Route::post("/new-student-end-term-entry", [TeacherEndOfTermController::class, 'store'])->name("new-teacher-student-end-term-entry");
//
//    /**Mock Report**/
//    Route::get('/teacher/report/mock', [TeacherMockReportController::class, 'index'])->name("teacher_mock_report");
//    Route::get("/teacher/report/mock/student", [TeacherMockReportController::class, 'get_mock_report'])->name('get_teacher_mock_report');
//    Route::get("/teacher/report/mock/student/download", [TeacherMockReportController::class, 'preview_teacher_mock_report'])->name
//    ('preview_teacher_mock_report');
//
//    /**MidTerm Report**/
//    Route::get('/teacher/report/mid-term', [TeacherMidTermReportController::class, 'index'])->name('teacher_mid_term_report');
//    Route::get('/teacher/report/mid-term/student', [TeacherMidTermReportController::class, 'get_mid_term_report'])->name
//    ('get_teacher_mid_term_report');
//
//    /**End of Term Report**/
//    Route::get('/teacher/report/end-of-term', [TeacherEndTermReportController::class, 'index'])->name('teacher_end_of_term_report');
//    Route::get('/teacher/report/end-of-term/student', [TeacherEndTermReportController::class, 'get_end_of_term_report'])
//        ->name('teacher_get_end_of_term_report');
//
//});
