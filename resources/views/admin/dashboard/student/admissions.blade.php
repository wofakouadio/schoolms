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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-student-admission-modal

                               ">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Admission
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="StudentsAdmissionsDatatables" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
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
    {{--Modals--}}
    @push('modals')
        @include('admin/dashboard/student/StudentsModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('admin/dashboard/student/studentsJS')
{{--    @include('custom-functions/StudentIdBasedOnSchoolJS')--}}
    @include('custom-functions/BranchesInSelectInputJS')
    @include('custom-functions/LevelsInSelectInputBasedOnBranchJS')
    @include('custom-functions/HousesInSelectInputBasedOnBranchJS')
    @include('custom-functions/CategoriesInSelectInputJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/student/studentsAdmissionsDataTables')
@endpush