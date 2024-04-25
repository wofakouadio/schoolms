@extends('layouts.dash-layout')

@push('title')
    <title>Students Mid-Term Examination | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Students Mid-Term Examination
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
                    <div class="card" style="height: auto">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-student-mid-term-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Student Mid-Term
                            </a>

{{--                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"--}}
{{--                               data-bs-target="#new-student-mock-with-bulk-upload-modal">--}}
{{--                                <span class="btn-icon-start text-primary">--}}
{{--                                    <i class="fa fa-plus color-primary"></i>--}}
{{--                                </span> New Student Mock with bulk Upload--}}
{{--                            </a>--}}
                        </div>
                        <div class="card-body">

                            <div class="dropdown mt-4 mb-4">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filter By
                                    <i class="flaticon-037-funnel"></i>
                                </button>
                                <div class="dropdown-menu" style="width:500px; height: auto">
                                    <div class="p-5">
                                        <div class="form-group">
                                            <label  class="form-label">Mid-Term</label>
                                            <select class="form-control" name="mid-term">
                                                <option value="">Choose</option>
                                                <option value="First">First</option>
                                                <option value="Second">Second</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label  class="form-label">Level</label>
                                            <select class="form-control" name="level"></select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Student</label>
                                            <select name="student" class="form-control"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="StudentsMidTermDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>Mid-Term</th>
                                        <th>Term</th>
                                        <th>Student Name</th>
                                        <th>Student Level</th>
                                        <th>Total Score</th>
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
        @include('admin/dashboard/assessment/mid-term/MidTermModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('admin/dashboard/assessment/mid-term/midTermJS')
{{--    @include('custom-functions/MocksInSelectInputBasedOnSchoolJS')--}}
    @include('custom-functions/LevelsInSelectInputBasedOnSchoolJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/assessment/mid-term/midTermDataTables')
@endpush
