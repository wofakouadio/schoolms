@extends('layouts.dash-layout')

@push('title')
    <title>Class Assessment Size | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Class Assessment Size
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
                <div class="col-xl-12">
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
                    <div class="card" style="height: auto">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal" data-bs-target="#new-cas-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Class Assessment Size
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="casDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>Term</th>
                                            <th>Academic Year</th>
                                            <th>Size</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ClassAssessmentSettings as $settings)
                                            <tr>
                                                <td>{{ $settings->schoolTerm->term_name }}</td>
                                                <td>{{ $settings->schoolTerm->academic_year->academic_year_start }}/{{ $settings->schoolTerm->academic_year->academic_year_end }}
                                                </td>
                                                <td>{{ $settings->class_assessment_size }}</td>
                                                <td>
                                                    @if ($settings->is_active == 0)
                                                        <div class="bootstrap-badge">
                                                            <span
                                                                class="badge badge-xl light badge-danger text-uppercase">disabled</span>
                                                        </div>
                                                    @else
                                                        <div class="bootstrap-badge">
                                                            <span
                                                                class="badge badge-xl light badge-success text-uppercase">active</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-primary light sharp"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
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
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#edit-cas-modal"
                                                                data-id="{{ $settings->id }}">Edit</a>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#edit-cas-status-modal"
                                                                data-id="{{ $settings->id }}">Edit Status</a>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#delete-cas-modal"
                                                                data-id="{{ $settings->id }}">Delete</a>
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
            @include('admin/dashboard/class-assessment-size/casModals')
        @endpush
    @endsection
    {{-- page js script --}}
    @push('page-js')
        @include('admin/dashboard/class-assessment-size/casJS')
        @include('custom-functions.admin.TermsInSelectInputBasedOnSchoolJS')
    @endpush
    {{-- page datatable script --}}
    @push('datatable')
        @include('admin/dashboard/class-assessment-size/casDataTables')
    @endpush
