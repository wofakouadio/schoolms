<?php

//Teacher login page

use App\Http\Controllers\Teacher\Level\LevelAssessmentController;
use App\Http\Controllers\Teacher\EndTerm\TeacherEndOfTermController;
use App\Http\Controllers\Teacher\EndTerm\TeacherEndTermReportController;
use App\Http\Controllers\Teacher\Level\TeacherLevelController;
use App\Http\Controllers\Teacher\MidTerm\TeacherMidTermController;
use App\Http\Controllers\Teacher\MidTerm\TeacherMidTermReportController;
use App\Http\Controllers\Teacher\Mock\TeacherMockController;
use App\Http\Controllers\Teacher\Mock\TeacherMockReportController;
use App\Http\Controllers\Teacher\Profile\TeacherProfileController;
use App\Http\Controllers\Teacher\TeacherAuthController;
use App\Http\Controllers\Teacher\TeacherUserController;
// use App\Http\Controllers\Teacher\Level\LevelAssessmentController;
use Illuminate\Support\Facades\Route;

Route::get('auth/', [TeacherAuthController::class, 'teacher_login'])->name('teacher_login');
Route::get('auth/forgot-password', [TeacherAuthController::class, 'forgot_password'])->name('teacher_forgot_password');
Route::post('auth/login', [TeacherAuthController::class, 'teacher_authentication'])->name('teacher_authentication');

//Teacher User Controller
Route::middleware(['auth' => 'teacher'])->controller(TeacherUserController::class)->group(function () {
    Route::get('/', 'index')->name('teacher_dashboard');
    Route::get('/getActiveTermBySchoolID', 'getActiveTermBySchoolID')->name('getTeacherActiveTermBySchoolID');
    Route::get('/getTermsBySchoolId', 'getTermsBySchoolId')->name('getTeacherTermsBySchoolId');
    Route::get('logout', [TeacherAuthController::class, 'teacher_logout'])->name('teacher_logout');

    /**Profile**/
    Route::get('profile', [TeacherProfileController::class, 'index'])->name('teacher_profile');
    Route::get('school_data', [TeacherProfileController::class, 'school_data'])->name('teacher_school_data');

    /**Levels/Classes**/
    Route::get('levels', [TeacherLevelController::class, 'index'])->name('teacher_levels');
    Route::get('/getLevelsBySchoolId', [TeacherLevelController::class, 'getLevelsBySchoolId'])->name('getTeacherLevelsBySchoolId');

    /**Mock Assessment**/
    Route::get('assessment/mock', [TeacherMockController::class, 'index'])->name('teacher_mock_assessment');
    Route::get('assessment/getMocksInSelectBasedOnSchool', [TeacherMockController::class, 'getMocksInSelectBasedOnSchool'])
        ->name('getTeacherMocksInSelectBasedOnSchool');
    Route::get('assessment/getStudentsBasedOnLevel', [TeacherMockController::class, 'getStudentsBasedOnLevel'])->name('getTeacherStudentsBasedOnLevel');
    Route::get('assessment/mock/get-student-to-mock', [TeacherMockController::class, 'create'])->name('get-teacher-student-to-mock');
    Route::post('assessment/mock/new-student-mock-entry', [TeacherMockController::class, 'store'])->name('new-teacher-student-mock-entry');

    //Level/Class Assessment
    Route::get('assessment/level', [LevelAssessmentController::class, 'index'])->name('teacher_level_assessment');
    Route::get('getSubjectsBasedOnLevel', [LevelAssessmentController::class, 'getSubjectsBasedOnLevel'])->name('getSubjectsBasedOnLevel');
    Route::get('teacher-get-student-for-level-assessment', [LevelAssessmentController::class,'create'])->name('teacher-get-student-for-level-assessment');
    Route::post('assessment/level/new', [LevelAssessmentController::class,'store'])->name('teacher_new_level_assessment_entry');
    // Route::get('getTeacherLevelsBySchoolId', [LevelAssessmentController::class, 'getTeacherLevelsBySchoolId'])->name('getTeacherLevelsBySchoolId');

    /**MidTerm Assessment**/
    Route::get('assessment/mid-term', [TeacherMidTermController::class, 'index'])->name('teacher_mid_term_assessment');
    Route::get("assessment/mid-term/create", [TeacherMidTermController::class, 'create'])->name('get-teacher-student-to-mid-term');
    Route::post("assessment/mid-term/new-student-mid-term-entry", [TeacherMidTermController::class, 'store'])->name("new-teacher-student-mid-term-entry");

    /**End of Term Assessment**/
    Route::get("assessment/end-of-term", [TeacherEndOfTermController::class, 'index'])->name("teacher_end_term_assessment");
    Route::get("assessment/end-of-term/get-student-to-end-term", [TeacherEndOfTermController::class, 'create'])->name("get-teacher-student-to-end-term");
    Route::post("assessment/end-of-term/new-student-end-term-entry", [TeacherEndOfTermController::class, 'store'])->name("new-teacher-student-end-term-entry");

    /**Mock Report**/
    Route::get('report/mock', [TeacherMockReportController::class, 'index'])->name("teacher_mock_report");
    Route::post("report/mock/view", [TeacherMockReportController::class, 'preview_mock_report'])->name('preview_mock_report');
    Route::post("report/mock/download", [TeacherMockReportController::class, 'download_mock_report'])->name('download_mock_report');

    /**MidTerm Report**/
    Route::get('report/mid-term', [TeacherMidTermReportController::class, 'index'])->name('teacher_mid_term_report');
    Route::post('report/mid-term/view', [TeacherMidTermReportController::class, 'preview_mid_term_report'])->name('preview_mid_term_report');
    Route::post('report/mid-term/download', [TeacherMidTermReportController::class, 'download_mid_term_report'])->name('download_mid_term_report');

    /**End of Term Report**/
    Route::get('report/end-of-term', [TeacherEndTermReportController::class, 'index'])->name('teacher_end_of_term_report');
    Route::post('report/end-of-term/view', [TeacherEndTermReportController::class, 'preview_end_of_term_report'])
        ->name('preview_end_of_term_report');
    Route::post('report/end-of-term/download', [TeacherEndTermReportController::class, 'download_end_of_term_report'])
        ->name('download_end_of_term_report');

});
