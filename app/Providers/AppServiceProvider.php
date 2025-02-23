<?php

namespace App\Providers;

use App\Models\AcademicYear;
use App\Models\Admin;
use App\Models\Term;
use App\Models\ClassAssessmentSettings;
use App\Models\AssessmentSettings;
use App\Models\GradingSystem;
use App\Models\Currency;
use App\Models\Level;
use App\Models\Category;
use App\Models\Subject;
use App\Models\Department;
use App\Models\AssignLevelToDepartment;
use App\Models\AssignSubjectToLevel;
use App\Models\Bill;
use App\Models\AdmissionFee;
use App\Models\AssignSubjectsToMock;
use App\Models\Teacher;
use App\Models\SubjectsToTeacher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
// use Spatie\Onboard\Facades\Onboard;
use Spatie\Onboard\Facades\Onboard; // Add this at the top of your file

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        //onboard to create academic year
        Onboard::addStep('Create an Academic Year', Admin::class)
        ->link('/admin/academic-year')
        ->cta('Create')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = AcademicYear::where(['school_id' => $user])->count();
            return $counts > 0;
        });
        // activate the created academic year
        Onboard::addStep('Activate the created Academic Year', Admin::class)
        ->link('/admin/academic-year')
        ->cta('Activate')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = AcademicYear::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 0;
        });
        // onboard to create term
        Onboard::addStep('Create a Term', Admin::class)
        ->link('/admin/term')
        ->cta('Create')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = Term::where(['school_id' => $user])->count();
            return $counts > 0;
        });
        //activate the created term
        Onboard::addStep('Activate the created Term', Admin::class)
        ->link('/admin/term')
        ->cta('Activate')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = Term::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 0;
        });
        // create class assessment size
        Onboard::addStep('Create a number of class assessments you want to have for class assessment', Admin::class)
        ->link('/admin/level-assessment-size')
        ->cta('Create')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = ClassAssessmentSettings::where(['school_id' => $user])->count();
            return $counts > 0;
        });
        // activate class assessment size
        Onboard::addStep('Activate the created class assessment size', Admin::class)
        ->link('/admin/level-assessment-size')
        ->cta('Activate')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = ClassAssessmentSettings::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 0;
        });
        // create assessment settings
        Onboard::addStep('Create a assessment percentage for class assessment, mid-term, and end of term for your school', Admin::class)
        ->link('/admin/assessment')
        ->cta('Create')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = AssessmentSettings::where(['school_id' => $user])->count();
            return $counts > 0;
        });
        // Activate the created assessment percentage
        Onboard::addStep('Activate the created assessment percentage for class assessment, mid-term, and end of term for your school', Admin::class)
        ->link('/admin/assessment')
        ->cta('Activate')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = AssessmentSettings::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 0;
        });
        // create grading system
        Onboard::addStep('Create the grading system for your school', Admin::class)
        ->link('/admin/assessment')
        ->cta('Create')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = GradingSystem::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 5;
        });
        // create currency
        Onboard::addStep('Create the currency', Admin::class)
        ->link('/admin/school')
        ->cta('Create')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = Currency::where(['school_id' => $user])->count();
            return $counts > 0;
        });
        // activate created currency
        Onboard::addStep('Activate created  currency', Admin::class)
        ->link('/admin/school')
        ->cta('Activate')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = Currency::where(['school_id' => $user, 'is_default_currency' => 1])->count();
            return $counts > 0;
        });
        // create department
        Onboard::addStep('Create department', Admin::class)
        ->link('/admin/department')
        ->cta('Create')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = Department::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 0;
        });
        // create level/class
        Onboard::addStep('Create level/class', Admin::class)
        ->link('/admin/level')
        ->cta('Create')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = Level::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 0;
        });
        // create category/
        Onboard::addStep('Create category', Admin::class)
        ->link('/admin/category')
        ->cta('Create')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = Category::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 0;
        });
        // create subject
        Onboard::addStep('Create subject', Admin::class)
        ->link('/admin/subject')
        ->cta('Create')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = Subject::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 0;
        });
        // assign levels to departments
        Onboard::addStep('Assign level/class to department', Admin::class)
        ->link('/admin/department')
        ->cta('Assign')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = AssignLevelToDepartment::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 0;
        });
        // assign subjects to levels
        Onboard::addStep('Assign subject to level/class', Admin::class)
        ->link('/admin/level')
        ->cta('Assign')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = AssignSubjectToLevel::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 0;
        });
        // assign Subjects to mock
        Onboard::addStep('Assign subject to mock', Admin::class)
        ->link('/admin/student/mock')
        ->cta('Assign')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = AssignSubjectsToMock::where(['school_id' => $user])->count();
            return $counts > 0;
        });
        // create term bill
        Onboard::addStep('Create Term Bill', Admin::class)
        ->link('/admin/finance/term/bills')
        ->cta('Create')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = Bill::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 0;
        });
        // create admission fee
        Onboard::addStep('Create Admission Fee', Admin::class)
        ->link('/admin/finance/admission-fees')
        ->cta('Create')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = AdmissionFee::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 0;
        });
        // create teacher
        Onboard::addStep('Add a new teacher', Admin::class)
        ->link('/admin/teacher')
        ->cta('Create')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = Teacher::where(['school_id' => $user, 'is_active' => 1])->count();
            return $counts > 0;
        });
        // assign level/class to teacher
        Onboard::addStep('Assign level/class to teacher', Admin::class)
        ->link('/admin/teacher/assign-levels-to-teacher')
        ->cta('Assign')
        ->completeIf(function () {
            $user = Auth::guard('admin')->user()->school_id;
            $counts = SubjectsToTeacher::where(['school_id' => $user])->count();
            return $counts > 0;
        });
    }
}
