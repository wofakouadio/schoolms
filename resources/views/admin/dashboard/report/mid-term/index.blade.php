@extends('layouts.dash-layout')

@push('title')
    <title>Mid-Term Reports | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Mid-Term Reports
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
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" id="attendance_report_form">
                                <div class="form-group mb-4">
                                    <label>Date</label>
                                    <select class="form-control solid" name="attendance_date">
                                        <option value="all">All</option>
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label>Department</label>
                                    <select class="form-control solid" name="department"></select>
                                </div>
                                <div class="form-group mb-4">
                                    <label>Level</label>
                                    <select class="form-control solid" name="level"></select>
                                </div>
                                <div class="form-group mb-4">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="card">
                        <div class="card-body" id="attendance_report">
                            {{--                            <div class="table-responsive">--}}
                            {{--                                <table id="LevelsDataTables" class="display" style="min-width: 845px">--}}
                            {{--                                    <thead>--}}
                            {{--                                    <tr>--}}
                            {{--                                        <th>Name</th>--}}
                            {{--                                        <th>Branch</th>--}}
                            {{--                                        <th>Status</th>--}}
                            {{--                                        <th>Action</th>--}}
                            {{--                                    </tr>--}}
                            {{--                                    </thead>--}}
                            {{--                                    <tbody>--}}
                            {{--                                    </tbody>--}}
                            {{--                                </table>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{--Modals--}}
    @push('modals')
{{--        @include('admin/dashboard/level/LevelsModals')--}}
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include("admin/dashboard/report/attendance/jsScript")
    @include("custom-functions/DepartmentsInSelectInputBasedOnSchoolJS")
{{--    @include('custom-functions/BranchesInSelectInputJS')--}}
{{--    @include('admin/dashboard/level/levelsJS')--}}
@endpush
{{--page datatable script--}}
@push('datatable')
{{--    @include('admin/dashboard/level/levelsDataTables')--}}
@endpush
