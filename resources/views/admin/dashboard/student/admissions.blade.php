@extends('layouts.dash-layout')

@push('title')
    <title>Students Admissions | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Students Admissions
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

            <div class="default-tab">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home" aria-selected="true" role="tab">New Admission</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#home2" aria-selected="true" role="tab">Export & Import</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="home" role="tabpanel" style="">
                        <div class="card" style="height: auto">
                            <div class="card-header">
                                <h5>New Admission</h5>
                                <a class="btn btn-rounded btn-primary" data-bs-toggle="modal" data-bs-target="#new-student-admission-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Admission
                            </a>
                            </div>
                            <div class="card-body">
                                <form class="form mb-4" method="post">
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
                                            <label>House</label>
                                            <select class="form-control dropdown-groups" name="house" id="house">
                                                <option value="">Select House</option>
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
                                <div class="table-responsive">
                                    <table id="StudentsAdmissionsDatatables" class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Profile</th>
                                                <th>Name</th>
                                                <th>Date of Birth</th>
                                                <th>Gender</th>
                                                <th>Level</th>
                                                <th>Residency</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="home2" role="tabpanel" style="">
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Export Students Admission Sheet</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="" action="{{ route('admin_export_template') }}">
                                            <div class="mb-4">
                                                <button class="btn btn-primary" type="submit" name="download_sheet">Download Sheet</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                                           data-bs-target="#new-student-admission-modal">
                                            <span class="btn-icon-start text-primary">
                                                <i class="fa fa-plus color-primary"></i>
                                            </span> New Admission
                                        </a>
                                        <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                                           data-bs-target="#new-student-admission-using-excel-modal">
                                            <span class="btn-icon-start text-primary">
                                                <i class="fa fa-plus color-primary"></i>
                                            </span> New Admission using Excel/CSV file
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="StudentsAdmissionsDatatables" class="table table-sm table-hover" style="min-width: 845px">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Profile</th>
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
    @include('custom-functions.admin.LevelsInSelectInputBasedOnSchoolJS')
    @include('custom-functions.admin.HousesInSelectInputBasedOnBranchJS')
    @include('custom-functions.admin.CategoriesInSelectInputJS')
@endpush
{{--page datatable script--}}
@push('datatable')
{{--    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}--}}
    @include('admin.dashboard.student.studentsAdmissionsDataTables')
@endpush
