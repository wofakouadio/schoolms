@extends('layouts.dash-layout')

@push('title')
    <title>Level Assessment | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Level Assessment
    </div>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            @if ($schoolTerm == null)
                <x-dash.dash-no-term />
            @else
                <x-dash.dash-term :term_name="$schoolTerm['term_name']" :academic_year_start="$schoolTerm['academic_year']['academic_year_start']" :academic_year_end="$schoolTerm['academic_year']['academic_year_end']" />
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card" style="height: auto">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                                data-bs-target="#new-level-assessment-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Level Assessment Entry
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="StudentsClassAssessmentDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Term</th>
                                            <th>Student ID</th>
                                            <th>Name</th>
                                            <th>Level</th>
                                            <th>Subject</th>
                                            <th>Score</th>
                                            <th>Percentage({{ $classAssessmentPercentage }}%)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- {{ dd($AssessmentRecords) }} --}}
                                        {{-- {{ $x = 1 }} --}}
                                        @foreach ($AssessmentRecords as $record)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $record->term->term_name .
                                                    ' - ' .
                                                    $record->academicYear->academic_year_start .
                                                    '/' .
                                                    $record->academicYear->academic_year_end }}
                                                </td>
                                                <td>{{ $record->student->student_id }}</td>
                                                <td>{{ $record->student->student_firstname .
                                                    ' ' .
                                                    $record->student->student_othername .
                                                    ' ' .
                                                    $record->student->student_lastname }}
                                                </td>
                                                <td>{{ $record->level->level_name }}</td>
                                                <td>{{ $record->subject->subject_name }}</td>
                                                <td>{{ $record->score }}</td>
                                                <td>{{ $record->percentage }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-primary light sharp"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                            <svg width="20px" height="20px" viewBox="0 0 24 24"
                                                                version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                    <circle fill="#000000" cx="5" cy="12"
                                                                        r="2"></circle>
                                                                    <circle fill="#000000" cx="12" cy="12"
                                                                        r="2"></circle>
                                                                    <circle fill="#000000" cx="19" cy="12"
                                                                        r="2"></circle>
                                                                </g>
                                                            </svg>
                                                        </button>
                                                        <div class="dropdown-menu" style="">
                                                            {{-- <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#edit-level-assessment-modal"
                                                                data-id="{{ $record->id }}">Edit Class Score</a> --}}
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#delete-level-assessment-modal"
                                                                data-id="{{ $record->id }}">Delete Class Score</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modals --}}
        @push('modals')
            @include('teacher/dashboard/assessment/level/Modals')
        @endpush
    @endsection
    {{-- page js script --}}
    @push('page-js')
        @include('teacher/dashboard/assessment/level/JS')
        @include('custom-functions/LevelsInSelectInputBasedOnSchoolJS')
    @endpush
    {{-- page datatable script --}}
    @push('datatable')
        @include('teacher/dashboard/assessment/level/DataTables')
    @endpush
