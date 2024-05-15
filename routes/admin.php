<?php

//Administrator login page
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Assessment\EndOfTermController;
use App\Http\Controllers\Admin\Assessment\MidTermController;
use App\Http\Controllers\Admin\Assessment\StudentAttendanceController;
use App\Http\Controllers\Admin\Assessment\StudentMockController;
use App\Http\Controllers\Admin\Branch\BranchController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\CustomJSController;
use App\Http\Controllers\Admin\Departments\DepartmentsController;
use App\Http\Controllers\Admin\Finance\BillsController;
use App\Http\Controllers\Admin\Finance\FinanceController;
use App\Http\Controllers\Admin\House\HouseController;
use App\Http\Controllers\Admin\Level\LevelController;
use App\Http\Controllers\Admin\Permission\AccountPermissionController;
use App\Http\Controllers\Admin\Report\Attendance\AttendanceReportController;
use App\Http\Controllers\Admin\Report\EndTerm\EndTermReportController;
use App\Http\Controllers\Admin\Report\MidTerm\MidTermReportController;
use App\Http\Controllers\Admin\Report\Mock\MockReportController;
use App\Http\Controllers\Admin\School\SchoolController;
use App\Http\Controllers\Admin\School\TermController;
use App\Http\Controllers\Admin\Student\StudentController;
use App\Http\Controllers\Admin\Student\StudentsAdmissionsController;
use App\Http\Controllers\Admin\Subjects\AssignSubjectToLevel\AssignSubjectToLevelController;
use App\Http\Controllers\Admin\Subjects\SubjectController;
use App\Http\Controllers\Admin\Subjects\SubjectsController;
use App\Http\Controllers\Admin\Teacher\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('auth/', [AdminAuthController::class, 'admin_login'])->name('admin_login');
Route::get('auth/forgot-password', [AdminAuthController::class, 'forgot_password'])->name('forgot_password');
Route::post('auth/login', [AdminAuthController::class, 'admin_authentication'])->name('admin_authentication');

//Administrator Controller
Route::middleware(['auth' => 'admin'])->controller(AdminController::class)->group(function () {
    //admin dash
    Route::get('/', 'index')->name('admin_dashboard');
    Route::get('logout', [AdminAuthController::class, 'admin_logout'])->name('admin_logout');

    /**Department**/
    Route::get('department', [DepartmentsController::class, 'index'])->name('admin_department');
    Route::post('/department/store', [DepartmentsController::class, 'store'])->name('new-department');
    Route::get('department/edit', [DepartmentsController::class, 'edit'])->name('edit-department');
    Route::put('department/update', [DepartmentsController::class, 'update'])->name('update-department');
    Route::delete('department/delete', [DepartmentsController::class, 'delete'])->name('delete-department');
    Route::get('/getDepartmentsBySchoolId', [DepartmentsController::class, 'getDepartmentsBySchoolId'])->name('getDepartmentsBySchoolId');
    Route::get('/departmentsTables', 'App\Http\Controllers\Admin\Departments\DepartmentsDatatable')->name('departmentsTables');
    route::get('/getLevelsBasedOnDepartmentAndBranch', [DepartmentsController::class, 'getLevelsBasedOnDepartmentAndBranch'])->name('getLevelsBasedOnDepartmentAndBranch');
    Route::post('department/new-assign-department-to-level', [DepartmentsController::class, 'newassignleveltodepartment'])
        ->name('new-assign-department-to-level');
    /**Custom JS Controller**/
    Route::get('/getLevelsByDepartmentBranchSchoolId', [CustomJSController::class, 'getLevelsByDepartmentBranchSchoolId'])->name('getLevelsByDepartmentBranchSchoolId');
    Route::get('/getSubjectsByLevelDepartmentBranchSchoolId', [CustomJSController::class, 'getSubjectsByLevelDepartmentBranchSchoolId'])->name('getSubjectsByLevelDepartmentBranchSchoolId');
    /** Teacher **/
    Route::get('teacher', [TeacherController::class, 'index'])->name('admin_teacher');
    Route::post('/teacher/store', [TeacherController::class, 'store'])->name('new-teacher');
    Route::get("/teacher/edit", [TeacherController::class, 'edit'])->name('edit-teacher');
    Route::put('/teacher/update', [TeacherController::class, 'update'])->name('update-teacher');
    Route::delete('/teacher/delete', [TeacherController::class, 'delete'])->name('delete-teacher');
    Route::get('/teachersTables', 'App\Http\Controllers\Admin\Teacher\TeachersDatatable')->name
    ('teachersTables');
    /**Assign level to teacher**/
    Route::get('teacher/assign-levels-to-teacher', [TeacherController::class, 'assignLevelsToTeacherIndex'])
        ->name('assign-levels-to-teacher');
    /**Assign Subjects to Teacher**/
    Route::get('/getTeachersBySchool', [TeacherController::class, 'getTeachersBySchool'])->name('getTeachersBySchool');
    Route::post('/assign-subjects-to-teacher', [TeacherController::class, 'assign_subjects_to_teacher'])->name('assign-subjects-to-teacher');

    /** Subject **/
    Route::get('subject', [SubjectController::class, 'index'])->name('admin_subject');
    Route::post('/subject/store', [SubjectController::class, 'store'])->name('new-subject');
    Route::get("/subject/edit", [SubjectController::class, 'edit'])->name('edit-subject');
    Route::put('/subject/update', [SubjectController::class, 'update'])->name('update-subject');
    Route::delete('/subject/delete', [SubjectController::class, 'delete'])->name('delete-subject');
    Route::get('/subjectsTables', 'App\Http\Controllers\Admin\Subjects\SubjectsDatatable')->name
    ('subjectsTables');
    Route::get('/getSubjectInCheckboxBySchoolId', [SubjectController::class, 'getSubjectInCheckboxBySchoolId'])->name('getSubjectInCheckboxBySchoolId');

    Route::get("/assignSubjectToLevel/create", [AssignSubjectToLevelController::class, 'create'])->name('assign-subject-to-level');

    /**School**/
    Route::get('school', [SchoolController::class, 'index'])->name('admin_school');
    Route::get('/school_data', [SchoolController::class, 'school_data'])->name('school_data');
    Route::put('school/update', [SchoolController::class, 'update'])->name('admin_school_update');
    /**School Term**/
    Route::post('school/term/store', [TermController::class, 'store'])->name('new-term');
    Route::get('school/term/edit', [TermController::class, 'edit'])->name('edit-term');
    Route::put('school/term/update', [TermController::class, 'update'])->name('update-term');
    Route::put('school/term/update-status', [TermController::class, 'update_status'])->name('update-term-status');
    Route::delete('school/term/delete', [TermController::class, 'delete'])->name('delete-term');
    Route::get('/termsTable', 'App\Http\Controllers\Admin\School\TermsDatatable')->name('termsTables');
    Route::get('/getTermsBySchoolId', [TermController::class, 'getTermsBySchoolId'])->name('getTermsBySchoolId');
    Route::get('/getActiveTermBySchoolID', [TermController::class, 'getActiveTermBySchoolID'])->name('getActiveTermBySchoolID');

    /**Branch**/
    Route::get('school/branch', [BranchController::class, 'index'])->name('admin_school_branch');
    Route::post('/school/branch', [BranchController::class, 'store'])->name('new-branch');
    Route::get('/school/branch/edit', [BranchController::class, 'edit'])->name('edit-branch');
    Route::put('/school/branch/update', [BranchController::class, 'update'])->name('update-branch');
    Route::delete('/school/branch/delete', [BranchController::class, 'delete'])->name('delete-branch');
    Route::get('/branchesTables', 'App\Http\Controllers\Admin\Branch\BranchesDatatable')->name('branchesTables');
    Route::get('/getBranchesBySchoolId', [BranchController::class, 'getBranchesBySchoolId'])->name('getBranchesBySchoolId');

    /**Level**/
    Route::get('school/level', [LevelController::class, 'index'])->name('admin_school_level');
    Route::post('/school/level', [LevelController::class, 'store'])->name('new-level');
    Route::get('/school/level/edit', [LevelController::class, 'edit'])->name('edit-level');
    Route::put('/school/level/update', [LevelController::class, 'update'])->name('update-level');
    Route::delete('/school/level/delete', [LevelController::class, 'delete'])->name('delete-level');
    Route::get('/levelsTables', 'App\Http\Controllers\Admin\Level\LevelsDatatable')->name('levelsTables');
    Route::get('/getLevelsByBranchId', [LevelController::class, 'getLevelsByBranchId'])->name('getLevelsByBranchId');
    Route::get('/getLevelsBySchoolId', [LevelController::class, 'getLevelsBySchoolId'])->name('getLevelsBySchoolId');
    Route::get('/getLevelsInCheckboxBySchoolId', [LevelController::class, 'getLevelsInCheckboxBySchoolId'])->name('getLevelsInCheckboxBySchoolId');
    Route::post('/assign_subjects_to_level', [LevelController::class, 'assign_subjects_to_level'])->name('assign_subjects_to_level');

    /**House**/
    Route::get('school/house', [HouseController::class, 'index'])->name('admin_school_house');
    Route::post('/school/house', [HouseController::class, 'store'])->name('new-house');
    Route::get('/school/house/edit', [HouseController::class, 'edit'])->name('edit-house');
    Route::put('/school/house/update', [HouseController::class, 'update'])->name('update-house');
    Route::delete('/school/house/delete', [HouseController::class, 'delete'])->name('delete-house');
    Route::get('/housesTables', 'App\Http\Controllers\Admin\House\HousesDatatable')->name('housesTables');
    Route::get('/getHousesByBranchId', [HouseController::class, 'getHousesByBranchId'])->name('getHousesByBranchId');

    /**Category**/
    Route::get('school/category', [CategoryController::class, 'index'])->name('admin_school_category');
    Route::post('/school/category', [CategoryController::class, 'store'])->name('new-category');
    Route::get('/school/category/edit', [CategoryController::class, 'edit'])->name('edit-category');
    Route::put('/school/category/update', [CategoryController::class, 'update'])->name('update-category');
    Route::delete('/school/category/delete', [CategoryController::class, 'delete'])->name('delete-category');
    Route::get('/categoriesTables', 'App\Http\Controllers\Admin\Category\CategoriesDatatable')->name('categoriesTables');
    Route::get('/getCategoriesBySchoolId', [CategoryController::class, 'getCategoriesBySchoolId'])->name('getCategoriesBySchoolId');

    /**Admissions Student**/
    Route::get('student/admissions', [StudentsAdmissionsController::class, 'index'])->name('admin_student_admission');
    Route::post('/admissions/student', [StudentsAdmissionsController::class, 'store'])->name('new-student-admission');
    Route::post('/admissions/bulk-student', [StudentsAdmissionsController::class, 'storebulk'])->name('new-student-admission-bulk');
    Route::get('/admissions/student/edit', [StudentsAdmissionsController::class, 'edit'])->name('edit-student-admission');
    Route::put('/admissions/student/update', [StudentsAdmissionsController::class, 'update'])->name('update-student-admission');
    Route::put('/admissions/student/update-admission-status', [StudentsAdmissionsController::class, 'updateAdmissionStatus'])->name('update-student-admission-status');
    Route::delete('/admissions/student/delete', [StudentsAdmissionsController::class, 'delete'])->name('delete-student-admission');
    Route::get('/studentsAdmissionsTables', 'App\Http\Controllers\Admin\Student\StudentsAdmissionsDatatable')->name('studentsAdmissionsTables');

    /**Students**/
    Route::get('student', [StudentController::class, 'index'])->name('admin_student');
    Route::get('/studentsListTables', 'App\Http\Controllers\Admin\Student\StudentsListDatatable')->name('studentsListTables');

    /**Finance**/
    Route::get('finance', [FinanceController::class, 'index'])->name('admin_finance');
    Route::get('finance/expenditure', [FinanceController::class, 'expenditureView'])->name('admin_expenditure');

    /**Bills**/
    Route::get('finance/student/bills/', [FinanceController::class, 'billsView'])
        ->name('admin_student_bill');
    Route::post('admin/finance/student/new-bill', [BillsController::class, 'store'])->name('new-bill');
    Route::get('admin/finance/student/edit-bill', [BillsController::class, 'edit'])->name('edit-bill');
    Route::put('admin/finance/student/update-bill', [BillsController::class, 'update'])->name('update-bill');
    Route::delete('admin/finance/student/delete-bill', [BillsController::class, 'delete'])->name('delete-bill');
    Route::get('/billsTables', 'App\Http\Controllers\Admin\Finance\BillsDatatable')->name('billsTables');

    /**Attendance**/
    Route::get('student/attendance/', [StudentAttendanceController::class, 'index'])->name('admin_student_attendance');
    Route::get('/get-attendance-sheet', 'App\Http\Controllers\Admin\Assessment\StudentAttendanceDatatable')->name('get-attendance-sheet');
    Route::get('/get-subject', [StudentAttendanceController::class, 'get_subject'])->name('get-subject');
    Route::post('/mark-student-attendance', [StudentAttendanceController::class, 'store'])->name('mark-student-attendance');

    /**Mock**/
    Route::get('student/mock', [StudentMockController::class, 'index'])->name('admin_student_mock');
    Route::post('/new-mock-setup', [StudentMockController::class, 'new_mock_setup'])->name('new-mock-setup');
    Route::get('/edit-mock-setup', [StudentMockController::class, 'edit'])->name('edit-mock-setup');
    Route::put('/update-mock-setup', [StudentMockController::class, 'update_mock_setup'])->name('update-mock-setup');
    Route::delete('/delete-mock-setup', [StudentMockController::class, 'delete_mock_setup'])->name('delete-mock-setup');
    Route::get('/getMocksInSelectBasedOnSchool', [StudentMockController::class, 'getMocksInSelectBasedOnSchool'])->name('getMocksInSelectBasedOnSchool');
    Route::post('/assign-subject-to-mock', [StudentMockController::class, 'assignSubjectToMock'])->name('assign-subject-to-mock');
    Route::get('/getSubjectsBasedOnMock', [StudentMockController::class, 'getSubjectsBasedOnMock'])->name('getSubjectsBasedOnMock');
    Route::get('/MockDatatable', 'App\Http\Controllers\Admin\Assessment\MockDatatable')->name('MockDatatable');
    /*****************/
    Route::get('student/mock/examination', [StudentMockController::class, 'examinationView'])->name('admin_student_mock_examination');
    Route::get('/getStudentsBasedOnLevel', [StudentMockController::class, 'getStudentsBasedOnLevel'])->name('getStudentsBasedOnLevel');
    Route::get('/get-student-to-mock', [StudentMockController::class, 'create'])->name('get-student-to-mock');
    Route::post('/new-student-mock-entry', [StudentMockController::class, 'store'])->name('new-student-mock-entry');
    Route::get('/StudentsMockDatatable', 'App\Http\Controllers\Admin\Assessment\StudentsMockDatatable')->name('StudentsMockDatatable');
    Route::get('/export-students-mock-list-in-excel', [StudentMockController::class, 'export_Students_mock_list'])->name('export-students-mock-list-in-excel');

    /**Mid-Term**/
    Route::get("student/mid-term", [MidTermController::class, 'index'])->name('admin_student_mid_term');
    Route::get("student/mid-term/create", [MidTermController::class, 'create'])->name('get-student-to-mid-term');
    Route::post("/new-student-mid-term-entry", [MidTermController::class, 'store'])->name("new-student-mid-term-entry");
    Route::get('/StudentsMidTermDatatable', 'App\Http\Controllers\Admin\Assessment\StudentsMidTermDatatable')->name('StudentsMidTermTable');

    /**End of Sem**/
    Route::get("student/end-of-term", [EndOfTermController::class, 'index'])->name("admin_student_end_term");
    Route::get("/get-student-to-end-term", [EndOfTermController::class, 'create'])->name("get-student-to-end-term");
    Route::post("/new-student-end-term-entry", [EndOfTermController::class, 'store'])->name("new-student-end-term-entry");
    Route::get('/StudentsEndTermDataTables', 'App\Http\Controllers\Admin\Assessment\StudentsEndTermDataTables')->name('StudentsEndTermDataTables');

    /**Subject**/
    Route::get('school/subject', [SubjectsController::class, 'index'])->name('admin_school_subject');
    Route::post('/new-subject', [SubjectsController::class, 'store'])->name('new_subject');
    Route::get('/edit-subject', [SubjectsController::class, 'edit'])->name('edit_subject');
    Route::put('/update-subject', [SubjectsController::class, 'update'])->name('update_subject');
    Route::delete('/delete-subject', [SubjectsController::class, 'delete'])->name('delete_subject');
    Route::get('/getSubjectsInCheckboxes', [SubjectsController::class, 'get_subjects_in_checkboxes'])->name('get_subjects_in_checkboxes');
    Route::get('/subjects_datatables', 'App\Http\Controllers\Admin\Subjects\SubjectDatatable')->name('subjects_datatables');
    Route::get("/getSubjectsByLevel", [SubjectsController::class, 'getSubjectsByLevel'])->name('get_subjects_by_level');

    /**Reports**/
    /**Attendance**/
    Route::get("report/attendance", [AttendanceReportController::class, 'index'])->name("admin_student_attendance_report");
    Route::get("/get-attendance-dates", [AttendanceReportController::class, 'get_attendance_dates'])->name('get_attendance_dates');
    Route::get("/get-levels-by-department", [AttendanceReportController::class, 'get_levels_by_department'])->name('get_levels_by_department');

    /**Mock**/
    Route::get("report/mock", [MockReportController::class, 'index'])->name("admin_student_mock_report");
    Route::post('report/mock/view', [MockReportController::class, 'preview_mock_report'])->name('preview_mock_report');
    Route::post('report/mock/download', [MockReportController::class, 'download_mock_report'])->name('download_mock_report');
    /**Mid-Term**/
    Route::get("report/mid-term", [MidTermReportController::class, 'index'])->name("admin_student_mid_term_report");
    Route::post("report/mid-term/view", [MidTermReportController::class, 'get_mid_term_report'])->name("get_mid_term_report");
    Route::post("report/mid-term/download", [MidTermReportController::class, 'download_mid_term_report'])->name("download_mid_term_report");

    /**End 0f Term**/
    Route::get("report/end-of-term", [EndTermReportController::class, 'index'])->name("admin_student_end_term_report");
    Route::post("report/end-of-term/view", [EndTermReportController::class, 'get_end_of_term_report'])->name("get_end_of_term_report");
    Route::post("report/end-of-term/download", [EndTermReportController::class, 'download_end_of_term_report'])->name
    ("download_end_of_term_report");

    /**Account Permission**/
    Route::get('users/permission', [AccountPermissionController::class,
        'index'])->name('admin_user_account_permission');
    Route::post('/add-new-user', [AccountPermissionController::class, 'store'])->name('add-new-user');

});
