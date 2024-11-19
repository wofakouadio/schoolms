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
    @include('custom-functions/admin/BranchesInSelectInputJS')
    @include('custom-functions/admin/LevelsInSelectInputBasedOnBranchJS')
    @include('custom-functions/admin/HousesInSelectInputBasedOnBranchJS')
    @include('custom-functions/admin/CategoriesInSelectInputJS')
@endpush
{{--page datatable script--}}
@push('datatable')
{{--    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}--}}
    @include('admin/dashboard/student/studentsAdmissionsDataTables')
@endpush
