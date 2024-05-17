@extends('layouts.dash-layout')

@push('title')
    <title>Assessment Settings | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Assessment Settings
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="alert alert-danger" style="display: none">

                </div>
            @endif
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-assessment-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Assessment Setup
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="AssessmentSettingsDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>Academic Year</th>
                                        <th>Class %</th>
                                        <th>Exam %</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($AssessmentSettings as $assessment)
                                        <tr>
                                            <td>{{$assessment->academic_year}}</td>
                                            <td>{{$assessment->class_percentage}}</td>
                                            <td>{{$assessment->exam_percentage}}</td>
                                            <td>
                                                @if($assessment->is_active == 1)
                                                    <div class="bootstrap-badge">
                                                        <span class="badge badge-xl light badge-success text-uppercase">active</span>
                                                    </div>
                                                @else
                                                    <div class="bootstrap-badge">
                                                        <span class="badge badge-xl light badge-warning
                                                        text-uppercase">disabled</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                                <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                                <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                            </g>
                                                        </svg>
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        <a class="dropdown-item" data-bs-toggle="modal"
                                                           data-bs-target="#edit-assessment-modal"
                                                           data-id="{{$assessment->id}}">Edit Assessment Status</a>
                                                        <a class="dropdown-item"  data-bs-toggle="modal"
                                                           data-bs-target="#delete-assessment-modal"
                                                           data-id="{{$assessment->id}}">Delete Assessment</a>
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
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-grading-system-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Grading System
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="GradingSystemAssessmentDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>Aca. Year</th>
                                        <th>Benchmark</th>
                                        <th>Proficiency</th>
                                        <th>Grade</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($GradingSystems as $value)
                                        <tr>
                                            <td>{{$value->academic_year}}</td>
                                            <td>{{$value->score_from}} - {{$value->score_to}}</td>
                                            <td>{{$value->level_of_proficiency}}</td>
                                            <td>{{$value->grade}}</td>
                                            <td>
                                                @if($value->is_active == 1)
                                                    <div class="bootstrap-badge">
                                                        <span class="badge badge-xl light badge-success text-uppercase">active</span>
                                                    </div>
                                                @else
                                                    <div class="bootstrap-badge">
                                                        <span class="badge badge-xl light badge-warning
                                                        text-uppercase">disabled</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                                <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                                <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                            </g>
                                                        </svg>
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        <a class="dropdown-item" data-bs-toggle="modal"
                                                           data-bs-target="#edit-grading-system-modal"
                                                           data-id="{{$value->id}}">Edit Grading System Status</a>
                                                        <a class="dropdown-item"  data-bs-toggle="modal"
                                                           data-bs-target="#delete-grading-system-modal"
                                                           data-id="{{$value->id}}">Delete Grading System</a>
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
    {{--Modals--}}
    @push('modals')
        @include('admin/dashboard/assessment/settings/AssessmentSettingsModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('admin/dashboard/assessment/settings/assessmentJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/assessment/settings/datatables')
@endpush
