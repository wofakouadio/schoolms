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
                            <form method="post" id="mid_term_report_form" action="{{route('get_mid_term_report')}}">
                                @csrf
                                <div class="form-group mb-4">
                                    <label  class="form-label">Mid-Term</label>
                                    <select class="form-control" name="mid_term">
                                        <option value="">Choose</option>
                                        <option value="First">First</option>
                                        <option value="Second">Second</option>
                                    </select>
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
                                    <button class="btn btn-primary" type="submit">Preview</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div id="mid_term_report_display" style="display: flex; justify-content: center;">
                        @empty($data)
                        @else
                            @foreach($data as $value)
                                @if($value['status'] == 0)
                                    <div class="alert alert-primary solid
                                            alert-square text-uppercase"><strong>{{$value['notice']}}</strong></div>
                                @else
                                    <div class="card">
                                        <div class="card-header">
                                            <form action="{{route('download_mid_term_report')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="mid_term"
                                                       value="{{$value['midTermData']}}">
                                                <input type="hidden" name="level"
                                                       value="{{$value['levelData']['id']}}">
                                                <input type="hidden" name="student"
                                                       value="{{$value['studentData']['id']}}">
                                                <button class="btn btn-primary" type="submit">Download</button>
                                            </form>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12
                                                    justify-content-center">
                                                    <img src="{{$value['schoolProfile']}}" class="rounded-circle" width=200>
                                                </div>
                                                <div class="mt-4 col-xl-6 col-lg-6 col-md-12 col-sm-12
                                                    justify-content-lg-center justify-content-center">
                                                    <h2 class="text-center fw-bolder
                                                        text-danger">{{$value['schoolData']['school_name']}}</h2>
                                                    <h6
                                                        class="text-center">{{$value['schoolData']['school_location']}}</h6>
                                                    <h6
                                                        class="text-center">{{$value['schoolData']['school_email'] . ' / ' .$value['schoolData']['school_phoneNumber']}}</h6>
                                                    <p class="text-center
                                                        text-info">{{$value['studentData']['branch']['branch_name']}} Branch</p>
                                                </div>
                                                <div class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12 justify-content-center">
                                                    <img src='{{$value['studentProfile']}}' width=120>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12
                                                    justify-content-center">
                                                    <p class="text-center text-uppercase fw-light">Student Assessment Record</p>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12
                                                    justify-content-center">
                                                    <p class="text-center text-primary text-uppercase
                                                            fw-semibold">{{$value['midTermData']}}
                                                        Mid-Term Performance Assessment</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 p-2.5">
                                                    <p>ID : <span class="fw-bolder"
                                                        >{{$value['studentData']['student_id']}}</span></p>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                    <p>Name : <span class="fw-bolder"
                                                        >{{$value['studentData']['student_firstname'] . ' ' .
                                                            $value['studentData']['student_othername'] . ' ' .
                                                            $value['studentData']['student_lastname']
                                                            }}</span></p>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                    <p>Level : <span class="fw-bolder"
                                                        >{{$value['levelData']['level_name']}}</span></p>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                    <p>Residency : <span class="fw-bolder"
                                                        >{{$value['studentData']['student_residency_type']}}</span></p>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                    <p>House : <span class="fw-bolder"
                                                        >{{$value['studentData']['house']['house_name']}}</span></p>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                    <p>Category : <span class="fw-bolder"
                                                        >{{$value['studentData']['category']['category_name']}}</span></p>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                    <p>Term : <span class="fw-bolder"
                                                        >{{$value['termData']['term_name']}}</span></p>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                    <p>Academic Year : <span class="fw-bolder"
                                                        >{{$value['termData']['term_academic_year']}}</span></p>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 p-2.5">
                                                    <p>Mid-Term : <span class="fw-bolder"
                                                        >{{$value['midTermData']}}</span></p>
                                                </div>
                                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 p-2.5">
                                                    <p>Total Score : <span class="fw-bolder"
                                                        >{{$value['midTermFirst']['total_score']}}</span></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <p class="fw-bolder text-uppercase text-center"><u>Details of result</u></p>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th class="center">Subject</th>
                                                        <th class="center">Score</th>
                                                        <th class="center">Proficiency Level</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($value['midTermBreakdown'] as $breakdown)
                                                        <tr>
                                                            <td
                                                                class="center">{{$breakdown['subject']['subject_name']}}</td>
                                                            <td
                                                                class="center">{{$breakdown['score']}}</td>
                                                            <td class="center">-</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endempty
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
    @include("admin/dashboard/report/mid-term/jsScript")
    @include("custom-functions/LevelsInSelectInputBasedOnSchoolJS")
{{--    @include('custom-functions/BranchesInSelectInputJS')--}}
{{--    @include('admin/dashboard/level/levelsJS')--}}
@endpush
{{--page datatable script--}}
@push('datatable')
{{--    @include('admin/dashboard/level/levelsDataTables')--}}
@endpush
