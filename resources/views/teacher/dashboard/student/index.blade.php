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
                                  :term_academic_year="$schoolTerm['term_academic_year']"/>
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

                            <div class="table-responsive">
                                <table id="StudentsListDatatables" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
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
    @include('admin/dashboard/student/studentsListDataTables')
@endpush
