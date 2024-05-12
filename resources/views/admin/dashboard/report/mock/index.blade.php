@extends('layouts.dash-layout')

@push('title')
    <title>Mock Report | School Mgt Sys</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Mock Report
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
                            <form method="post" id="mock_report_form" action="{{route('download_mock_report')}}">
                                @csrf
                                <div class="form-group mb-4">
                                    <label>Mock Type</label>
                                    <select class="form-control solid" name="mock"></select>
                                </div>
                                <div class="form-group mb-4">
                                    <label>Level</label>
                                    <select class="form-control solid" name="level"></select>
                                </div>
                                <div class="form-group mb-4">
                                    <label>Student</label>
                                    <select class="form-control solid" name="student"></select>
                                </div>
                                <div>
                                    <button class="btn btn-primary" type="submit">Submit</button>
{{--                                    <button class="btn btn-secondary ml-2" type="submit"--}}
{{--                                            id="DownloadMockReport">Download</button>--}}
                                </div>
{{--                                <div class="form-group mb-4">--}}
{{--                                    <button class="btn btn-primary" type="submit">Submit</button>--}}
{{--                                </div>--}}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="card">
                        <div class="card-body">
                            <div id="mock_report_display" style="display: flex; justify-content: center;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
{{--page js script--}}
@push('page-js')
    @include("admin/dashboard/report/mock/jsScript")
    @include("custom-functions/MocksInSelectInputBasedOnSchoolJS")
    @include('custom-functions/LevelsInSelectInputBasedOnSchoolJS')
@endpush
{{--page datatable script--}}
@push('datatable')
{{--    @include('admin/dashboard/level/levelsDataTables')--}}
@endpush
