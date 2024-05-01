@extends('layouts.dash-layout')

@push('title')
    <title>End of Term Reports | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        End of Term Reports
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
                            <form method="post" id="end_of_term_report_form">
                                <div class="form-group mb-4">
                                    <label  class="form-label">Term</label>
                                    <select class="form-control" name="term"></select>
                                </div>
                                <div class="form-group mb-4">
                                    <label  class="form-label">Level</label>
                                    <select class="form-control" name="level"></select>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="form-label">Student</label>
                                    <select name="student" class="form-control"></select>
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
                        <div class="card-body">
                            <div id="end_of_term_report_display" style="display: flex; justify-content: center;"></div>
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
    @include("admin/dashboard/report/end-of-term/jsScript")
    @include("custom-functions/LevelsInSelectInputBasedOnSchoolJS")
    @include('custom-functions/TermsInSelectInputBasedOnSchoolJS')
{{--    @include('admin/dashboard/level/levelsJS')--}}
@endpush
{{--page datatable script--}}
@push('datatable')
{{--    @include('admin/dashboard/level/levelsDataTables')--}}
@endpush
