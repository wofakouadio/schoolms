<?php

//namespace App\Http\Controllers\Admin;

//Administrator login page
use App\Http\Controllers\Admin\AcademicYear\AcademicYearController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Assessment\Attendance\StudentAttendanceController;
use App\Http\Controllers\Admin\Assessment\Class\ClassAssessmentController;
use App\Http\Controllers\Admin\Assessment\EndTerm\EndOfTermController;
use App\Http\Controllers\Admin\Assessment\MidTerm\MidTermController;
use App\Http\Controllers\Admin\Assessment\Mock\StudentMockController;
use App\Http\Controllers\Admin\Assessment\Settings\AssessmentSettingsController;
use App\Http\Controllers\Admin\Assessment\Settings\ClassAssessmentSizeController;
use App\Http\Controllers\Admin\Branch\BranchController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\CustomJSController;
use App\Http\Controllers\Admin\Departments\AssignLevelToDepartmentController;
use App\Http\Controllers\Admin\Departments\DepartmentsController;
use App\Http\Controllers\Admin\Finance\BillsController;
use App\Http\Controllers\Admin\Finance\FinanceController;
use App\Http\Controllers\Admin\Finance\AdmissionFeeController;
use App\Http\Controllers\Admin\Finance\FeesCollectionController;
use App\Http\Controllers\Admin\Finance\FinanceReportController;
use App\Http\Controllers\Admin\Finance\FeedingFeeController;
use App\Http\Controllers\Admin\House\HouseController;
use App\Http\Controllers\Admin\Level\LevelController;
use App\Http\Controllers\Admin\Permission\AccountPermissionController;
use App\Http\Controllers\Admin\Report\Attendance\AttendanceReportController;
use App\Http\Controllers\Admin\Report\EndTerm\EndTermReportController;
use App\Http\Controllers\Admin\Report\MidTerm\MidTermReportController;
use App\Http\Controllers\Admin\Report\Mock\MockReportController;
use App\Http\Controllers\Admin\School\CurrencyController;
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
Route::post('auth/forgot-password', [AdminAuthController::class, 'admin_forgot_password'])->name('admin_forgot_password');
Route::get('auth/reset-password/{token}/{email}', [AdminAuthController::class, 'admin_reset_password_get'])->name('admin_reset_password_get');
Route::post('auth/reset-password', [AdminAuthController::class, 'admin_reset_password_post'])->name('admin_reset_password_post');
Route::post('auth/login', [AdminAuthController::class, 'admin_authentication'])->name('admin_authentication');

//Administrator Controller
Route::middleware(['auth' => 'admin'])->controller(AdminController::class)->group(function () {
    //admin dash
    Route::get('/', 'index')->name('admin_dashboard');
    Route::get('logout', [AdminAuthController::class, 'admin_logout'])->name('admin_logout');

    /**Department**/
    Route::get('department', [DepartmentsController::class, 'index'])->name('admin_department');
    Route::post('department/store', [DepartmentsController::class, 'store'])->name('new-department');
    Route::get('department/edit', [DepartmentsController::class, 'edit'])->name('edit-department');
    Route::put('department/update', [DepartmentsController::class, 'update'])->name('update-department');
    Route::delete('department/delete', [DepartmentsController::class, 'delete'])->name('delete-department');
    Route::get('getDepartmentsBySchoolId', [DepartmentsController::class, 'getDepartmentsBySchoolId'])->name('getDepartmentsBySchoolId');
    Route::get('departmentsTables', 'App\Http\Controllers\Admin\Departments\DepartmentsDatatable')->name('departmentsTables');
    route::get('getLevelsBasedOnDepartmentAndBranch', [DepartmentsController::class, 'getLevelsBasedOnDepartmentAndBranch'])->name('getLevelsBasedOnDepartmentAndBranch');
    Route::post('department/new-assign-department-to-level', [DepartmentsController::class, 'newassignleveltodepartment'])->name('new-assign-department-to-level');
    Route::get('get-department-levels', [AssignLevelToDepartmentController::class, 'get_department_levels'])->name('get_department_levels');

    /**Custom JS Controller**/
    Route::get('getLevelsByDepartmentBranchSchoolId', [CustomJSController::class, 'getLevelsByDepartmentBranchSchoolId'])->name('getLevelsByDepartmentBranchSchoolId');
    Route::get('getSubjectsByLevelDepartmentBranchSchoolId', [CustomJSController::class, 'getSubjectsByLevelDepartmentBranchSchoolId'])->name('getSubjectsByLevelDepartmentBranchSchoolId');
    /** Teacher **/
    Route::get('teacher', [TeacherController::class, 'index'])->name('admin_teacher');
    Route::post('teacher/store', [TeacherController::class, 'store'])->name('new-teacher');
    Route::get("teacher/edit", [TeacherController::class, 'edit'])->name('edit-teacher');
    Route::put('teacher/update', [TeacherController::class, 'update'])->name('update-teacher');
    Route::delete('teacher/delete', [TeacherController::class, 'delete'])->name('delete-teacher');
    Route::get('teachersTables', 'App\Http\Controllers\Admin\Teacher\TeachersDatatable')->name('teachersTables');
    /**Assign level to teacher**/
    Route::get('teacher/assign-levels-to-teacher', [TeacherController::class, 'assignLevelsToTeacherIndex'])
        ->name('assign-levels-to-teacher');
    /**Assign Subjects to Teacher**/
    Route::get('getTeachersBySchool', [TeacherController::class, 'getTeachersBySchool'])->name('getTeachersBySchool');
    Route::post('assign-subjects-to-teacher', [TeacherController::class, 'assign_subjects_to_teacher'])->name('assign-subjects-to-teacher');

    /** Subject **/
    Route::get('subject', [SubjectController::class, 'index'])->name('admin_subject');
    Route::post('subject/store', [SubjectController::class, 'store'])->name('new-subject');
    Route::get("subject/edit", [SubjectController::class, 'edit'])->name('edit-subject');
    Route::put('subject/update', [SubjectController::class, 'update'])->name('update-subject');
    Route::delete('subject/delete', [SubjectController::class, 'delete'])->name('delete-subject');
    Route::get('subjectsTables', 'App\Http\Controllers\Admin\Subjects\SubjectsDatatable')->name('subjectsTables');
    Route::get('getSubjectInCheckboxBySchoolId', [SubjectController::class, 'getSubjectInCheckboxBySchoolId'])->name('getSubjectInCheckboxBySchoolId');

    Route::get("assignSubjectToLevel/create", [AssignSubjectToLevelController::class, 'create'])->name('assign-subject-to-level');

    /**School**/
    Route::get('school', [SchoolController::class, 'index'])->name('admin_school');
    Route::get('school_data', [SchoolController::class, 'school_data'])->name('school_data');
    Route::put('update', [SchoolController::class, 'update'])->name('admin_school_update');

    /**Currency**/
    Route::post("currency/new", [CurrencyController::class,"store"])->name("admin_new_currency");
    Route::get("currency/edit", [CurrencyController::class,"edit"])->name("admin_edit_currency");
    Route::put("currency/update", [CurrencyController::class,"update"])->name("admin_update_currency");
    Route::put("currency/default", [CurrencyController::class, "set_selected_currency_as_default"])->name("admin_set_selected_currency_as_default");
    Route::delete("currency/delete", [CurrencyController::class,"delete"])->name("admin_delete_currency");

    /**Term**/
    Route::get('term', [TermController::class, 'index'])->name('admin_school_term');
    Route::post('term/store', [TermController::class, 'store'])->name('new-term');
    Route::get('term/edit', [TermController::class, 'edit'])->name('edit-term');
    Route::put('term/update', [TermController::class, 'update'])->name('update-term');
    Route::put('term/update-status', [TermController::class, 'update_status'])->name('update-term-status');
    Route::delete('term/delete', [TermController::class, 'delete'])->name('delete-term');
    Route::get('termsTable', 'App\Http\Controllers\Admin\School\TermsDatatable')->name('termsTables');
    Route::get('getTermsBySchoolId', [TermController::class, 'getTermsBySchoolId'])->name('getTermsBySchoolId');
    Route::get('getActiveTermBySchoolID', [TermController::class, 'getActiveTermBySchoolID'])->name('getActiveTermBySchoolID');

    /**Academic Year**/
    Route::get("academic-year", [AcademicYearController::class, 'index'])->name("admin_academic_year");
    Route::post("academic-year/new", [AcademicYearController::class, 'store'])->name("new_admin_academic_year");
    Route::get("academic-year/edit", [AcademicYearController::class, 'edit'])->name("edit_admin_academic_year");
    Route::put("academic-year/update", [AcademicYearController::class, 'update'])->name("update_admin_academic_year");
    Route::put("academic-year/update-status", [AcademicYearController::class, 'update_status'])->name("update_admin_academic_year_status");
    Route::delete("academic-year/delete", [AcademicYearController::class, 'delete'])->name("delete_admin_academic_year");
    Route::get('getAcademicYearsBySchoolId', [AcademicYearController::class, 'getAcademicYearsBySchoolId'])->name('getAcademicYearsBySchoolId');

    /**Branch**/
    Route::get('branch', [BranchController::class, 'index'])->name('admin_school_branch');
    Route::post('branch', [BranchController::class, 'store'])->name('new-branch');
    Route::get('branch/edit', [BranchController::class, 'edit'])->name('edit-branch');
    Route::put('branch/update', [BranchController::class, 'update'])->name('update-branch');
    Route::delete('branch/delete', [BranchController::class, 'delete'])->name('delete-branch');
    Route::get('branchesTables', 'App\Http\Controllers\Admin\Branch\BranchesDatatable')->name('branchesTables');
    Route::get('getBranchesBySchoolId', [BranchController::class, 'getBranchesBySchoolId'])->name('getBranchesBySchoolId');

    /**Level**/
    Route::get('level', [LevelController::class, 'index'])->name('admin_school_level');
    Route::post('level', [LevelController::class, 'store'])->name('new-level');
    Route::get('level/edit', [LevelController::class, 'edit'])->name('edit-level');
    Route::put('level/update', [LevelController::class, 'update'])->name('update-level');
    Route::delete('level/delete', [LevelController::class, 'delete'])->name('delete-level');
    Route::get('levelsTables', 'App\Http\Controllers\Admin\Level\LevelsDatatable')->name('levelsTables');
    Route::get('getLevelsByBranchId', [LevelController::class, 'getLevelsByBranchId'])->name('getLevelsByBranchId');
    Route::get('getLevelsBySchoolId', [LevelController::class, 'getLevelsBySchoolId'])->name('getLevelsBySchoolId');
    Route::get('getLevelsInCheckboxBySchoolId', [LevelController::class, 'getLevelsInCheckboxBySchoolId'])->name('getLevelsInCheckboxBySchoolId');
    Route::post('assign_subjects_to_level', [LevelController::class, 'assign_subjects_to_level'])->name('assign_subjects_to_level');

    /**House**/
    Route::get('house', [HouseController::class, 'index'])->name('admin_school_house');
    Route::post('house', [HouseController::class, 'store'])->name('new-house');
    Route::get('house/edit', [HouseController::class, 'edit'])->name('edit-house');
    Route::put('house/update', [HouseController::class, 'update'])->name('update-house');
    Route::delete('house/delete', [HouseController::class, 'delete'])->name('delete-house');
    Route::get('housesTables', 'App\Http\Controllers\Admin\House\HousesDatatable')->name('housesTables');
    Route::get('getHousesByBranchId', [HouseController::class, 'getHousesByBranchId'])->name('getHousesByBranchId');

    /**Category**/
    Route::get('category', [CategoryController::class, 'index'])->name('admin_school_category');
    Route::post('category', [CategoryController::class, 'store'])->name('new-category');
    Route::get('category/edit', [CategoryController::class, 'edit'])->name('edit-category');
    Route::put('category/update', [CategoryController::class, 'update'])->name('update-category');
    Route::delete('category/delete', [CategoryController::class, 'delete'])->name('delete-category');
    Route::get('categoriesTables', 'App\Http\Controllers\Admin\Category\CategoriesDatatable')->name('categoriesTables');
    Route::get('getCategoriesBySchoolId', [CategoryController::class, 'getCategoriesBySchoolId'])->name('getCategoriesBySchoolId');

    /**Admissions Student**/
    Route::get('student/admissions', [StudentsAdmissionsController::class, 'index'])->name('admin_student_admission');
    Route::post('admissions/student', [StudentsAdmissionsController::class, 'store'])->name('new-student-admission');
    Route::post('admissions/bulk-student', [StudentsAdmissionsController::class, 'storebulk'])->name('new-student-admission-bulk');
    Route::get('admissions/student/edit', [StudentsAdmissionsController::class, 'edit'])->name('edit-student-admission');
    Route::put('admissions/student/update', [StudentsAdmissionsController::class, 'update'])->name('update-student-admission');
    Route::put('admissions/student/update-admission-status', [StudentsAdmissionsController::class, 'updateAdmissionStatus'])->name('update-student-admission-status');
    Route::delete('admissions/student/delete', [StudentsAdmissionsController::class, 'delete'])->name('delete-student-admission');
    Route::get('studentsAdmissionsTables', 'App\Http\Controllers\Admin\Student\StudentsAdmissionsDatatable')->name('studentsAdmissionsTables');
    Route::get('admissions/export-template', [StudentsAdmissionsController::class, 'export_admissions_template'])->name('admin_export_template');
    Route::get('getStudentsByLevelId', [StudentsAdmissionsController::class, 'getStudentsByLevelId'])->name('getStudentsByLevelId');

    /**Students**/
    Route::get('student', [StudentController::class, 'index'])->name('admin_student');
    Route::get('studentsListTables', 'App\Http\Controllers\Admin\Student\StudentsListDatatable')->name('studentsListTables');

    /**Finance**/
    Route::get('finance', [FinanceController::class, 'index'])->name('admin_finance');
    Route::get('finance/expenditure', [FinanceController::class, 'expenditureView'])->name('admin_expenditure');

    /**Admission Fee**/
    Route::get("finance/admission-fees", [AdmissionFeeController::class,"index"])->name("admin_finance_admission_fee");
    Route::post("finance/new-admission-fee", [AdmissionFeeController::class,"store"])->name("new_admission_fee");
    Route::get("finance/edit-admission-fee", [AdmissionFeeController::class, "edit"])->name("edit_admission_fee");
    Route::put("finance/update-admission-fee", [AdmissionFeeController::class,"update"])->name("update_admission_fee");
    Route::delete("finance/delete-admission-fee", [AdmissionFeeController::class,"delete"])->name("delete_admission_fee");

    /**Fee Collection**/
    Route::get("finance/fee-collection", [FeesCollectionController::class,"index"])->name("admin_finance_fee_collection");
    Route::match(['get','post'],"finance/transactions/get-student", [FeesCollectionController::class,"create"])->name("admin_get_student_transaction");
    Route::match(['get','post'],"finance/fee-collection/store", [FeesCollectionController::class, "store"])->name("admin_student_new_fee_collection");

    /**Bills**/
    Route::get('finance/term/bills/', [FinanceController::class, 'billsView'])->name('admin_term_bill');
    Route::post('finance/term/new-bill', [BillsController::class, 'store'])->name('new-bill');
    Route::get('finance/term/edit-bill', [BillsController::class, 'edit'])->name('edit-bill');
    Route::put('finance/term/update-bill', [BillsController::class, 'update'])->name('update-bill');
    Route::delete('finance/term/delete-bill', [BillsController::class, 'delete'])->name('delete-bill');
    Route::get('billsTables', 'App\Http\Controllers\Admin\Finance\BillsDatatable')->name('billsTables');

    /** Student Bill**/
    Route::get("finance/student-bill", [FinanceController::class, "studentBillView"])->name("admin_student_bill");
    Route::post("finance/student/student-data", [BillsController::class, "get_student_data"])->name("admin_get_student_data");
    Route::post("finance/student/new-bill", [BillsController::class, "new_student_bill"])->name("new-student-bill");

    /** View Student Transaction **/
    Route::get("finance/student-transactions", [FeesCollectionController::class, 'view_student_transactions'])->name("admin_student_transactions");
    Route::post("finance/student-transactions/get", [FeesCollectionController::class, 'get_student_transactions'])->name("admin_get_student_transactions");
    Route::put("finance/student-transactions/update", [FeesCollectionController::class, 'update_transaction_data'])->name("admin_update_student_transaction");
    Route::delete("finance/student-transactions/delete", [FeesCollectionController::class, 'delete_transaction_data'])->name("admin_delete_student_transaction");

    /** Finance Fee Report **/
    Route::get("finance/reports", [FinanceReportController::class, 'index'])->name("admin_finance_report");
    Route::post("finance/reports/get_student_data", [FinanceReportController::class, 'get_student_finance_data'])->name("admin_finance_student_report_data");
    Route::post("finance/reports/download_student_financial_report", [FinanceReportController::class, 'download_student_finance_data'])->name('admin_finance_download_student_report');
    /** Finance Arrears Report **/
    Route::post("finance/reports/get_student_arrears_data", [FinanceReportController::class, 'get_student_finance_arrears_data'])->name('admin_finance_student_arrears_report_data');
    Route::post("finance/reports/download_student_arrears_report", [FinanceReportController::class, 'download_student_finance_arrears_data'])->name('admin_finance_download_student_arrears_report');

    /** Feeding Fee **/
    Route::get("finance/feeding-fee", [FeedingFeeController::class, 'index'])->name('admin_finance_feeding_fee');
    Route::post("finance/new-feeding-fee-setup", [FeedingFeeController::class, 'new_feeding_fee_setup'])->name('admin_finance_feeding_fee_setup');
    Route::get("finance/get-feeding-fee-data", [FeedingFeeController::class, 'get_feeding_fee_data'])->name('admin_finance_feeding_fee_data');
    Route::put("finance/update-feeding-fee-data", [FeedingFeeController::class, 'update_feeding_fee_data'])->name('admin_finance_update_feeding_fee_data');
    Route::delete("finance/delete-feeding-fee-data", [FeedingFeeController::class, 'delete_feeding_fee_data'])->name('admin_finance_delete_feeding_fee_data');
    Route::post('finance/feeding-fee/new-collection', [FeedingFeeController::class, 'feeding_fee_new_collection'])->name('admin_feeding_fee_new_collection');
    Route::get('finance/feeding-fee/get-collection', [FeedingFeeController::class, 'feeding_fee_get_collection'])->name('admin_feeding_fee_get_collection');
    Route::put('finance/feeding-fee/update-collection', [FeedingFeeController::class, 'feeding_fee_update_collection'])->name('admin_feeding_fee_update_collection');
    Route::delete('finance/feeding-fee/delete-collection', [FeedingFeeController::class, 'feeding_fee_delete_collection'])->name('admin_feeding_fee_delete_collection');
    Route::post("finance/feeding-fee-collection/export", [FeedingFeeController::class, 'feeding_fee_collection_export'])->name('admin_feeding_fee_collection_export');
    Route::post("finance/feeding-fee-collection/import", [FeedingFeeController::class, 'feeding_fee_collection_import'])->name('admin_feeding_fee_collection_import');

    /**Assessment Settings**/
    Route::get('assessment', [AssessmentSettingsController::class, 'index'])->name('admin_assessment_settings');
    Route::post('assessment/new', [AssessmentSettingsController::class, 'new_assessment_setup'])->name('new_assessment_setup');
    Route::get('assessment/edit', [AssessmentSettingsController::class, 'edit_assessment_setup'])->name('edit_assessment_setup');
    Route::put('assessment/update', [AssessmentSettingsController::class, 'update_assessment_setup'])->name('update_assessment_setup');
    Route::delete('assessment/delete', [AssessmentSettingsController::class, 'delete_assessment_setup'])->name('delete_assessment_setup');

    Route::post('assessment/grading-system/new', [AssessmentSettingsController::class, 'new_grading_system'])->name('new_grading_system');
    Route::get('assessment/grading-system/edit', [AssessmentSettingsController::class, 'edit_grading_system'])->name('edit_grading_system');
    Route::put('assessment/grading-system/update', [AssessmentSettingsController::class, 'update_grading_system'])->name('update_grading_system');
    Route::delete('assessment/grading-system/delete', [AssessmentSettingsController::class, 'delete_grading_system'])->name('delete_grading_system');


    /**Attendance**/
    Route::get('student/attendance/', [StudentAttendanceController::class, 'index'])->name('admin_student_attendance');
    Route::get('get-attendance-sheet', 'App\Http\Controllers\Admin\Assessment\Attendance\StudentAttendanceDatatable')->name('get-attendance-sheet');
    Route::get('get-subject', [StudentAttendanceController::class, 'get_subject'])->name('get-subject');
    Route::post('mark-student-attendance', [StudentAttendanceController::class, 'store'])->name('mark-student-attendance');

    /**Mock**/
    Route::get('student/mock', [StudentMockController::class, 'index'])->name('admin_student_mock');
    Route::post('new-mock-setup', [StudentMockController::class, 'new_mock_setup'])->name('new-mock-setup');
    Route::get('edit-mock-setup', [StudentMockController::class, 'edit'])->name('edit-mock-setup');
    Route::put('update-mock-setup', [StudentMockController::class, 'update_mock_setup'])->name('update-mock-setup');
    Route::delete('delete-mock-setup', [StudentMockController::class, 'delete_mock_setup'])->name('delete-mock-setup');
    Route::get('getMocksInSelectBasedOnSchool', [StudentMockController::class, 'getMocksInSelectBasedOnSchool'])->name('getMocksInSelectBasedOnSchool');
    Route::post('assign-subject-to-mock', [StudentMockController::class, 'assignSubjectToMock'])->name('assign-subject-to-mock');
    Route::get('getSubjectsBasedOnMock', [StudentMockController::class, 'getSubjectsBasedOnMock'])->name('getSubjectsBasedOnMock');
    Route::get('MockDatatable', 'App\Http\Controllers\Admin\Assessment\Mock\MockDatatable')->name('MockDatatable');
    /*****************/
    Route::get('student/mock/examination', [StudentMockController::class, 'examinationView'])->name('admin_student_mock_examination');
    Route::get('getStudentsBasedOnLevel', [StudentMockController::class, 'getStudentsBasedOnLevel'])->name('getStudentsBasedOnLevel');
    Route::get('get-student-to-mock', [StudentMockController::class, 'create'])->name('get-student-to-mock');
    Route::post('new-student-mock-entry', [StudentMockController::class, 'store'])->name('new-student-mock-entry');
    Route::get('StudentsMockDatatable', 'App\Http\Controllers\Admin\Assessment\Mock\StudentsMockDatatable')->name('StudentsMockDatatable');
    Route::get('export-students-mock-list-in-excel', [StudentMockController::class, 'export_Students_mock_list'])->name('export-students-mock-list-in-excel');

    /**Level Assessment**/
    Route::get('assessment/level', [ClassAssessmentController::class, 'index'])->name('admin_assessment_level');
    Route::get('getSubjectsBasedOnLevel', [ClassAssessmentController::class, 'getSubjectsBasedOnLevel'])->name('getSubjectsBasedOnLevel');
    Route::get('get-student-to-level-assessment', [ClassAssessmentController::class, 'create'])->name('get_student_to_level_assessment');
    Route::post('assessment/level/new', [ClassAssessmentController::class, 'store'])->name('new_student_class_assessment_entry');
    Route::get('assessment/level/edit', [ClassAssessmentController::class, 'edit'])->name('edit_student_class_assessment_entry');
    Route::put('assessment/level/update', [ClassAssessmentController::class, 'update'])->name('update_student_class_assessment_entry');
    Route::delete('assessment/level/delete', [ClassAssessmentController::class, 'delete'])->name('delete_student_class_assessment_entry');

    /**Mid-Term**/
    Route::get("student/mid-term", [MidTermController::class, 'index'])->name('admin_student_mid_term');
    Route::get("student/mid-term/create", [MidTermController::class, 'create'])->name('get-student-to-mid-term');
    Route::post("new-student-mid-term-entry", [MidTermController::class, 'store'])->name("new-student-mid-term-entry");
    Route::get('StudentsMidTermDatatable', 'App\Http\Controllers\Admin\Assessment\MidTerm\StudentsMidTermDatatable')->name('StudentsMidTermTable');

    /**End of Sem**/
    Route::get("student/end-of-term", [EndOfTermController::class, 'index'])->name("admin_student_end_term");
    Route::get("student/end-of-term/get-student-to-end-term", [EndOfTermController::class, 'create'])->name("get-student-to-end-term");
    Route::post("new-student-end-term-entry", [EndOfTermController::class, 'store'])->name("new-student-end-term-entry");
    Route::get('StudentsEndTermDataTables', 'App\Http\Controllers\Admin\Assessment\EndTerm\StudentsEndTermDataTables')->name('StudentsEndTermDataTables');

    /**Subject**/
    Route::get('subject', [SubjectsController::class, 'index'])->name('admin_school_subject');
    Route::post('new-subject', [SubjectsController::class, 'store'])->name('new_subject');
    Route::get('edit-subject', [SubjectsController::class, 'edit'])->name('edit_subject');
    Route::put('update-subject', [SubjectsController::class, 'update'])->name('update_subject');
    Route::delete('delete-subject', [SubjectsController::class, 'delete'])->name('delete_subject');
    Route::get('getSubjectsInCheckboxes', [SubjectsController::class, 'get_subjects_in_checkboxes'])->name('get_subjects_in_checkboxes');
    Route::get('subjects_datatables', 'App\Http\Controllers\Admin\Subjects\SubjectDatatable')->name('subjects_datatables');
    Route::get("getSubjectsByLevel", [SubjectsController::class, 'getSubjectsByLevel'])->name('get_subjects_by_level');

    /**Reports**/
    /**Attendance**/
    Route::get("report/attendance", [AttendanceReportController::class, 'index'])->name("admin_student_attendance_report");
    Route::get("get-attendance-dates", [AttendanceReportController::class, 'get_attendance_dates'])->name('get_attendance_dates');
    Route::get("get-levels-by-department", [AttendanceReportController::class, 'get_levels_by_department'])->name('get_levels_by_department');

    /**Mock**/
    Route::get("report/mock", [MockReportController::class, 'index'])->name("admin_student_mock_report");
    Route::post('report/mock/view', [MockReportController::class, 'preview_mock_report'])->name('admin_preview_mock_report');
    Route::post('report/mock/download', [MockReportController::class, 'download_mock_report'])->name('admin_download_mock_report');
    /**Mid-Term**/
    Route::get("report/mid-term", [MidTermReportController::class, 'index'])->name("admin_student_mid_term_report");
    Route::post("report/mid-term/view", [MidTermReportController::class, 'get_mid_term_report'])->name("admin_get_mid_term_report");
    Route::post("report/mid-term/download", [MidTermReportController::class, 'download_mid_term_report'])->name("admin_download_mid_term_report");
    /**End 0f Term**/
    Route::get("report/end-of-term", [EndTermReportController::class, 'index'])->name("admin_student_end_term_report");
    Route::post("report/end-of-term/view", [EndTermReportController::class, 'get_end_of_term_report'])->name("admin_get_end_of_term_report");
    Route::post("report/end-of-term/download", [EndTermReportController::class, 'download_end_of_term_report'])
        ->name("admin_download_end_of_term_report");

    /**Account Permission**/
    Route::get('users/permission', [AccountPermissionController::class, 'index'])->name('admin_user_account_permission');
    Route::post('/add-new-user', [AccountPermissionController::class, 'store'])->name('add-new-user');

    /**Class Assessment Size**/
    Route::get('level-assessment-size', [ClassAssessmentSizeController::class, 'index'])->name('admin_class_assessment_size');
    Route::post('level-assessment-size/new', [ClassAssessmentSizeController::class, 'store'])->name('add_new_class_assessment_size');
    Route::get('level-assessment-size/edit', [ClassAssessmentSizeController::class, 'edit'])->name('edit_class_assessment_size');
    Route::put('level-assessment-size/update', [ClassAssessmentSizeController::class, 'update'])->name('update_class_assessment_size');
    Route::put('level-assessment-size/status', [ClassAssessmentSizeController::class, 'update_status'])->name('update_class_assessment_size_status');
    Route::delete('level-assessment-size/delete', [ClassAssessmentSizeController::class, 'delete'])->name('delete_class_assessment_size');

});
