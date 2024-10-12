@extends('layouts.dash-layout')

@push('title')
    <title>End of Term Report | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        End of Term Report
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
                <div class="col-3">
                    <div class="card" style="height: auto">
                        <div class="card-body">
                            <form method="post" id="end_of_term_report_form" action="{{route
                            ('preview_end_of_term_report')}}">
                                @csrf
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
                    <div id="end_of_term_report_display" style="display: flex; justify-content: center;">
                        <div class="row">
                            <div class="col-lg-12">
                                @empty($data)
                                @else
                                {{-- @foreach ($data as $value) --}}
                                {{-- {{ dd($data['status']) }} --}}
                                {{-- {{ dd($value['classTotalAssessment']) }} --}}
                                    @if ($data['status'] == 0)
                                        <div
                                            class="alert alert-primary solid
                                                alert-square text-uppercase">
                                            <strong>{{ $data['notice'] }}</strong></div>
                                    @else
                                        <div class="card">
                                            <div class="card-header">
                                                {{-- <form action="{{ route('admin_download_end_of_term_report') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="term" value="{{ $data['termData']['id'] }}">
                                                    <input type="hidden" name="level" value="{{ $data['levelData']['id'] }}">
                                                    <input type="hidden" name="student" value="{{ $data['studentData']['id'] }}">
                                                    <button class="btn btn-primary" type="submit">Download</button>
                                                </form> --}}
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div
                                                        class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12
                                                        justify-content-center">
                                                        <img src='{{ $data['schoolProfile'] }}' class='rounded-circle' width=200>
                                                    </div>
                                                    <div
                                                        class="mt-4 col-xl-6 col-lg-6 col-md-12 col-sm-12
                                                        justify-content-lg-center justify-content-center">
                                                        <h2
                                                            class="text-center fw-bolder
                                                            text-danger">
                                                            {{ $data['schoolData']['school_name'] }}</h2>
                                                        <h6 class="text-center">{{ $data['schoolData']['school_location'] }}</h6>
                                                        <h6 class="text-center">
                                                            {{ $data['schoolData']['school_email'] . ' / ' . $data['schoolData']['school_phoneNumber'] }}
                                                        </h6>
                                                        <p
                                                            class="text-center
                                                            text-info">
                                                            {{ $data['studentData']['branch']['branch_name'] }} Branch</p>
                                                    </div>
                                                    <div class="mt-4 col-xl-3 col-lg-3 col-md-6 col-sm-12 justify-content-center">
                                                        <img src='{{ $data['studentProfile'] }}' width=120>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div
                                                        class="col-xl-12 col-lg-12 col-md-12 col-sm-12
                                                        justify-content-center">
                                                        <p class="text-center text-uppercase fw-light">Student Assessment Record</p>
                                                    </div>
                                                    <div
                                                        class="col-xl-12 col-lg-12 col-md-12 col-sm-12
                                                        justify-content-center">
                                                        <p
                                                            class="text-center text-primary text-uppercase
                                                                fw-semibold">
                                                            End of Term
                                                            {{ $data['termData']['term_name'] }}
                                                            Performance Assessment</p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 p-2.5">
                                                        <p>ID : <span
                                                                class="fw-bolder">{{ $data['studentData']['student_id'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <p>Name : <span
                                                                class="fw-bolder">{{ $data['studentData']['student_firstname'] .
                                                                    ' ' .
                                                                    $data['studentData']['student_othername'] .
                                                                    ' ' .
                                                                    $data['studentData']['student_lastname'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <p>Level : <span
                                                                class="fw-bolder">{{ $data['levelData']['level_name'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <p>Residency : <span
                                                                class="fw-bolder">{{ $data['studentData']['student_residency_type'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <p>House : <span
                                                                class="fw-bolder">{{ $data['studentData']['house']['house_name'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <p>Category : <span
                                                                class="fw-bolder">{{ $data['studentData']['category']['category_name'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <p>Term : <span
                                                                class="fw-bolder">{{ $data['termData']['term_name'] }}</span></p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <p>Academic Year : <span
                                                                class="fw-bolder">{{ $data['termData']['academic_year']['academic_year_start'] .
                                                                    '/' .
                                                                    $data['termData']['academic_year']['academic_year_end'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 p-2.5">
                                                        <p>Total Class Score :
                                                            <span class="fw-bolder">
                                                                {{ $data['classPercentageScore'] }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 p-2.5">
                                                        <p>Total Mid-Term Score :
                                                            <span class="fw-bolder">
                                                                {{ $data['midTermSummary']['total_percentage'] }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 p-2.5">
                                                        <p>Total Exam Score :
                                                            <span class="fw-bolder">
                                                                {{ $data['endTermFirst']['total_percentage'] }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 p-2.5">
                                                        <p>Total Score :
                                                            <span class="fw-bolder">
                                                                {{ $data['endTermFirst']['total_percentage'] + $data['midTermSummary']['total_percentage'] + $data['classPercentageScore'] }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <p class="fw-bolder text-uppercase text-center"><u>Details of result</u></p>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                    {{-- {{ dd($value['schoolAssessmentPercentage']) }} --}}
                                                        <thead>
                                                            <tr>
                                                                <th class="center">Subject</th>
                                                                <th class="center">Class Score
                                                                    ({{ $data['schoolAssessmentPercentage']->class_percentage }}%)
                                                                </th>
                                                                <th class="center">Mid-Term Score
                                                                    ({{ $data['schoolAssessmentPercentage']->mid_term_percentage }}%)
                                                                </th>
                                                                <th class="center">Exam Score
                                                                    ({{ $data['schoolAssessmentPercentage']->exam_percentage }}%)
                                                                </th>
                                                                <th class="center">Total Score
                                                                    ({{ $data['schoolAssessmentPercentage']->exam_percentage + $data['schoolAssessmentPercentage']->mid_term_percentage + $data['schoolAssessmentPercentage']->class_percentage }}%)
                                                                </th>
                                                                <th>Grade</th>
                                                                <th class="center">Proficiency</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            {{-- {{ dd($data['finalData']) }} --}}
                                                            @foreach($data['finalData'] as $key => $value)
                                                                <tr>
                                                                    <td>{{ $value['subject_name'] }}</td>
                                                                    <td class="text-center">{{ $value['class_assessment'] ?? 0 }}</td>
                                                                    <td class="text-center">{{ $value['mid_term'] ?? 0}}</td>
                                                                    <td class="text-center">{{ $value['end_term'] ?? 0}}</td>
                                                                    <td class="text-center">{{ $value['total'] ?? 0}}</td>
                                                                    <td class="text-center">{{ $value['grade'] }}</td>
                                                                    <td class="text-center">{{ $value['level'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    <p class="fw-bolder text-uppercase text-center"><u>Appraisal</u></p>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <p>Conduct : <span
                                                                class="fw-bolder">{{ $data['endTermFirst']['conduct'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <p>Attitude : <span
                                                                class="fw-bolder">{{ $data['endTermFirst']['attitude'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <p>Interest : <span
                                                                class="fw-bolder">{{ $data['endTermFirst']['interest'] }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                        <p>General Remarks : <span
                                                                class="fw-bolder">{{ $data['endTermFirst']['general_remarks'] }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <p class="fw-bolder text-uppercase text-center"><u>Grading System</u></p>
                                                </div>
                                                <div class="row text-center">
                                                    <table class="table table-striped" style="width: 500px;">
                                                        <thead>
                                                            <th>Score</th>
                                                            <th>Grade</th>
                                                            <th>Proficiency</th>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($data['gradingSystem'] as $key => $grading)

                                                                <tr>
                                                                    <td><span class="fw-bolder">{{ $grading['score_from'].' - '.$grading['score_to']}}</span></td>
                                                                    <td><span class="fw-bolder">{{ $grading['grade']}}</span></td>
                                                                    <td><span class="fw-bolder">{{ $grading['level_of_proficiency']}}</span></td>
                                                                </tr>

                                                            {{-- <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                                <span class="fw-bolder">{{ $grading['score_from'].'-'.$grading['score_to']}}</span> | <span class="fw-bolder">{{ $grading['grade']}}</span> | <span class="fw-bolder">{{ $grading['level_of_proficiency']}}</span>
                                                            </div> --}}
                                                            {{-- <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                                <span class="fw-bolder">{{ $grading['grade']}}</span>
                                                            </div>
                                                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                                <span class="fw-bolder">{{ $grading['level_of_proficiency']}}</span>
                                                            </div> --}}
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                {{-- @endforeach --}}
                                @endempty
                            </div>
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
    @include("teacher/dashboard/report/end-of-term/jsScript")
    @include("custom-functions/teacher/LevelsInSelectInputBasedOnSchoolJS")
    @include('custom-functions/teacher/TermsInSelectInputBasedOnSchoolJS')
{{--    @include('admin/dashboard/level/levelsJS')--}}
@endpush
{{--page datatable script--}}
@push('datatable')
{{--    @include('admin/dashboard/level/levelsDataTables')--}}
@endpush
