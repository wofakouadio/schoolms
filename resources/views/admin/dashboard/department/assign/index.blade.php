@extends('layouts.dash-layout')

@push('title')
    <title>Assign Department-Level | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Assign Department to Level
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
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-dl-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> Click to assign Department to Level
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="AssignDepartmentLevelDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>Level</th>
                                        <th>Department</th>
                                        <th>Branch</th>
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
        @include('admin/dashboard/department/assign/AssignDepartmentToLevelModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('custom-functions/DepartmentsInSelectInputBasedOnSchoolJS')
    @include('custom-functions/LevelsInSelectInputBasedOnSchoolJS')
    @include('admin/dashboard/department/assign/assignDepartmentToLevelJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/department/assign/assignDepartmentToLevelDataTables')
@endpush
