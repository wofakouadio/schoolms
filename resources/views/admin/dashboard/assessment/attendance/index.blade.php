@extends('layouts.dash-layout')

@push('title')
    <title>Students Attendance | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Students Attendance
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
                    <div class="card" style="height: auto">
                        <div class="card-body">
                            <form method="post" id="get-attendance-sheet-form">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select name="department_id" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <label>Level</label>
                                            <select name="level_id" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <label>Subject</label>
                                            <select name="subject_id" class="form-control"></select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4">Get List</button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="subject text-capitalize text-lg-center text-primary"></h3>
                            <form method="post" id="mark-attendance-sheet">
                                @csrf
                                <input type="hidden" name="subject_id">
                                <input type="hidden" name="level_id">
                                <input type="hidden" name="department_id">

                                <div class="btn-group" id="btn-mark-attendance" style="display: none;">
                                    <button class="btn light btn-primary" type="submit">Mark
                                        Attendance</button>
                                </div>
                                <div class="table-responsive mt-4">
                                    <table id="StudentAttendanceDataTables" class="display" style="min-width: 845px">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Residency</th>
                                            <th>Level</th>
                                            <th>
                                                <div class="form-check custom-checkbox mb-3 checkbox-primary check-xl
                                                     checkAll">
                                                    <input type="checkbox" class="form-check-input" id="checkAll"
                                                           name="checkAll">
                                                    <label class="form-check-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{--Modals--}}
    @push('modals')
{{--        @include('admin/dashboard/level/StudentAttendanceModals')--}}
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('custom-functions/admin/DepartmentsInSelectInputBasedOnSchoolJS')
    @include('custom-functions/admin/customJSscriptAttendance')
    @include('admin/dashboard/assessment/attendance/attendanceJS')
@endpush
{{--page datatable script--}}
@push('datatable')
{{--    @include('admin/dashboard/level/levelsDataTables')--}}
@endpush
