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
            @if ($schoolTerm == null)
                <x-dash.dash-no-term />
            @else
                <x-dash.dash-term :term_name="$schoolTerm['term_name']" :academic_year_start="$schoolTerm['academic_year']['academic_year_start']" :academic_year_end="$schoolTerm['academic_year']['academic_year_end']" />
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
                <div class="alert alert-danger" style="display: none"></div>
            @endif

            {{-- put everything in tabs --}}
            <div class="default-tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#assessment_setup" aria-selected="true"
                            role="tab">Assessment Setup</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#grading_system_setup" aria-selected="true"
                            role="tab">Grading System Setup</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="assessment_setup" role="tabpanel">
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
                                                <th>Mid-Term %</th>
                                                <th>Exam %</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- {{dd($AssessmentSettings)}} --}}
                                            @unless ($AssessmentSettings->isEmpty())
                                                @foreach ($AssessmentSettings as $assessment)
                                                    <tr>
                                                        <td>{{ $assessment->school_academic_year->academic_year_start .
                                                            '/' .
                                                            $assessment->school_academic_year->academic_year_end }}
                                                        </td>
                                                        <td>{{ $assessment->class_percentage }}</td>
                                                        <td>{{ $assessment->mid_term_percentage }}</td>
                                                        <td>{{ $assessment->exam_percentage }}</td>
                                                        <td>
                                                            @if ($assessment->is_active == 1)
                                                                <div class="bootstrap-badge">
                                                                    <span
                                                                        class="badge badge-xl light badge-success text-uppercase">active</span>
                                                                </div>
                                                            @else
                                                                <div class="bootstrap-badge">
                                                                    <span
                                                                        class="badge badge-xl light badge-warning
                                                                                                                                text-uppercase">disabled</span>
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button" class="btn btn-primary light sharp"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Action
                                                                    <svg width="20px" height="20px" viewBox="0 0 24 24"
                                                                        version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none"
                                                                            fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24">
                                                                            </rect>
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
                                                                    <a class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#edit-assessment-modal"
                                                                        data-id="{{ $assessment->id }}">Edit Assessment
                                                                        Status</a>
                                                                    <a class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#delete-assessment-modal"
                                                                        data-id="{{ $assessment->id }}">Delete Assessment</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endunless
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="grading_system_setup" role="tabpanel">
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
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- {{ dd($GradingSystems) }} --}}
                                            @foreach ($GradingSystems as $value)
                                                <tr>
                                                    <td>{{ $value->school_academic_year->academic_year_start . '/' . $value->school_academic_year->academic_year_end }}
                                                    </td>
                                                    <td>{{ $value->score_from }} - {{ $value->score_to }}</td>
                                                    <td>{{ $value->level_of_proficiency }}</td>
                                                    <td>{{ $value->grade }}</td>
                                                    <td>{{ $value->school_category->category_name }}</td>
                                                    <td>
                                                        @if ($value->is_active == 1)
                                                            <div class="bootstrap-badge">
                                                                <span
                                                                    class="badge badge-xl light badge-success text-uppercase">active</span>
                                                            </div>
                                                        @else
                                                            <div class="bootstrap-badge">
                                                                <span
                                                                    class="badge badge-xl light badge-warning
                                                                        text-uppercase">disabled</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn btn-primary light sharp"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                                <svg width="20px" height="20px" viewBox="0 0 24 24"
                                                                    version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24">
                                                                        </rect>
                                                                        <circle fill="#000000" cx="5"
                                                                            cy="12" r="2"></circle>
                                                                        <circle fill="#000000" cx="12"
                                                                            cy="12" r="2"></circle>
                                                                        <circle fill="#000000" cx="19"
                                                                            cy="12" r="2"></circle>
                                                                    </g>
                                                                </svg>
                                                            </button>
                                                            <div class="dropdown-menu" style="">
                                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-grading-system-modal"
                                                                    data-id="{{ $value->id }}">Edit Grading System
                                                                    Status</a>
                                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-grading-system-modal"
                                                                    data-id="{{ $value->id }}">Delete Grading
                                                                    System</a>
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

            {{-- <div class="row"> --}}
                {{-- setup school based assessment --}}
                {{-- <div class="col-xl-6">
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
                                            <th>Mid-Term %</th>
                                            <th>Exam %</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @unless ($AssessmentSettings->isEmpty())
                                            @foreach ($AssessmentSettings as $assessment)
                                                <tr>
                                                    <td>{{ $assessment->school_academic_year->academic_year_start .
                                                        '/' .
                                                        $assessment->school_academic_year->academic_year_end }}
                                                    </td>
                                                    <td>{{ $assessment->class_percentage }}</td>
                                                    <td>{{ $assessment->mid_term_percentage }}</td>
                                                    <td>{{ $assessment->exam_percentage }}</td>
                                                    <td>
                                                        @if ($assessment->is_active == 1)
                                                            <div class="bootstrap-badge">
                                                                <span
                                                                    class="badge badge-xl light badge-success text-uppercase">active</span>
                                                            </div>
                                                        @else
                                                            <div class="bootstrap-badge">
                                                                <span
                                                                    class="badge badge-xl light badge-warning
                                                                                                                            text-uppercase">disabled</span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn btn-primary light sharp"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                                <svg width="20px" height="20px" viewBox="0 0 24 24"
                                                                    version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24">
                                                                        </rect>
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
                                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-assessment-modal"
                                                                    data-id="{{ $assessment->id }}">Edit Assessment Status</a>
                                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-assessment-modal"
                                                                    data-id="{{ $assessment->id }}">Delete Assessment</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endunless
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- setup school grading system --}}
                {{-- <div class="col-xl-6">
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
                                        @foreach ($GradingSystems as $value)
                                            <tr>
                                                <td>{{ $value->school_academic_year->academic_year_start . '/' . $value->school_academic_year->academic_year_end }}
                                                </td>
                                                <td>{{ $value->score_from }} - {{ $value->score_to }}</td>
                                                <td>{{ $value->level_of_proficiency }}</td>
                                                <td>{{ $value->grade }}</td>
                                                <td>
                                                    @if ($value->is_active == 1)
                                                        <div class="bootstrap-badge">
                                                            <span
                                                                class="badge badge-xl light badge-success text-uppercase">active</span>
                                                        </div>
                                                    @else
                                                        <div class="bootstrap-badge">
                                                            <span
                                                                class="badge badge-xl light badge-warning
                                                                    text-uppercase">disabled</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-primary light sharp"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                            <svg width="20px" height="20px" viewBox="0 0 24 24"
                                                                version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24">
                                                                    </rect>
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
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#edit-grading-system-modal"
                                                                data-id="{{ $value->id }}">Edit Grading System
                                                                Status</a>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#delete-grading-system-modal"
                                                                data-id="{{ $value->id }}">Delete Grading System</a>
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
                </div> --}}
            {{-- </div> --}}
        </div>
        {{-- Modals --}}
        @push('modals')
            @include('admin/dashboard/assessment/settings/AssessmentSettingsModals')
        @endpush
    @endsection
    {{-- page js script --}}
    @push('page-js')
        @include('admin/dashboard/assessment/settings/assessmentJS')
    @endpush
    {{-- page datatable script --}}
    @push('datatable')
        @include('admin/dashboard/assessment/settings/datatables')
    @endpush
