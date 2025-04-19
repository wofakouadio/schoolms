@extends('layouts.dash-layout')

@push('title')
    <title>Students List | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Students List
    </div>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            @if($schoolTerm == null)
                <x-dash.dash-no-term/>
            @else
                <x-dash.dash-term :term_name="$schoolTerm['term_name']"
                                  :academic_year_start="$schoolTerm['academic_year']['academic_year_start']"
                                  :academic_year_end="$schoolTerm['academic_year']['academic_year_end']"/>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
{{--                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"--}}
{{--                               data-bs-target="#new-student-admission-modal">--}}
{{--                                <span class="btn-icon-start text-primary">--}}
{{--                                    <i class="fa fa-plus color-primary"></i>--}}
{{--                                </span> New Admission--}}
{{--                            </a>--}}
{{--                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"--}}
{{--                               data-bs-target="#new-student-admission-using-excel-modal">--}}
{{--                                <span class="btn-icon-start text-primary">--}}
{{--                                    <i class="fa fa-plus color-primary"></i>--}}
{{--                                </span> New Admission using Excel/CSV file--}}
{{--                            </a>--}}
                        </div>
                        <div class="card-body">

                            <form class="form" method="post">
                                @csrf
                                @if ($errors->any())
                                    <div class="alert menu-alert">
                                        @foreach ($errors->all() as $error)
                                            <ul>{{ $error }}</ul>
                                        @endforeach
                                    </div>
                                @else
                                @endif
                                <div class="row">
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Level</label>
                                        <select class="form-control dropdown-groups level" name="level" id="level">
                                        </select>
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Term</label>
                                        <select class="form-control dropdown-groups term" name="term" id="term">
                                        </select>
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Academic Year</label>
                                        <select class="form-control dropdown-groups academic_year" name="academic_year" id="academic_year">
                                            <option value="">Select Academic Year</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Branch</label>
                                        <select class="form-control dropdown-groups" name="branch" id="branch">
                                            <option value="">Select Branch</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Category</label>
                                        <select class="form-control dropdown-groups" name="category" id="category">
                                            <option value="">Select Category</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Residency Status</label>
                                        <select class="form-control dropdown-groups" name="residency_status" id="residency_status">
                                            <option value="">Select Residency Status</option>
                                            <option value="Day">Day</option>
                                            <option value="Boarding">Boarding</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Admission Status</label>
                                        <select class="form-control dropdown-groups" name="admission_status" id="admission_status">
                                            <option value="">Select Admission Status</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Admitted</option>
                                            <option value="2">Declined</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Student Name</label>
                                        <input type="text" class="form-control" name="student_name" id="student_name">
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender" id="gender">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Date of Birth</label>
                                        <input type="date" class="form-control" name="date_of_birth" id="date_of_birth">
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Registration Date</label>
                                        <input type="date" class="form-control" name="registration_date" id="registration_date">
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="button" onclick="filterStudent()" id="btn_search_filter">Search</button>
                            </form>

                            <div class="table-responsive mt-5">
                                <table id="StudentsListDatatables" class="table table-sm table-hover students">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile</th>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Date of Birth</th>
                                        <th>Gender</th>
                                        <th>Level</th>
                                        <th>Residency</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{--Modals--}}
    @push('modals')
        @include('admin.dashboard.student.StudentsModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('admin.dashboard.student.studentsJS')
{{--    @include('custom-functions.StudentIdBasedOnSchoolJS')--}}
    @include('custom-functions.admin.BranchesInSelectInputJS')
    @include('custom-functions.admin.LevelsInSelectInputBasedOnBranchJS')
    @include('custom-functions.admin.HousesInSelectInputBasedOnBranchJS')
    @include('custom-functions.admin.CategoriesInSelectInputJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin.dashboard.student.studentsListDataTables')
@endpush
