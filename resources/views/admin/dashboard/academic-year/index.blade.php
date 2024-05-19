@extends('layouts.dash-layout')

@push('title')
    <title>Academic Year | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Academic Year
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
                <div class="col-xl-12">
                    <div class="card" style="height: auto">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-academic-year-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Academic Year
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="academicYearDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>Designation</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($academicYears as $academic_year)
                                            <tr>
                                                <td>{{$academic_year->academic_year_start}} / {{$academic_year->academic_year_end}}</td>
                                                <td>
                                                    @if($academic_year->is_active == 1)
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
                                                               data-bs-target="#edit-academic-year-modal"
                                                               data-id="{{$academic_year->id}}">Edit Academic Year</a>
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                               data-bs-target="#edit-academic-year-status-modal"
                                                               data-id="{{$academic_year->id}}">Edit Academic Year
                                                                Status</a>
                                                            <a class="dropdown-item"  data-bs-toggle="modal"
                                                               data-bs-target="#delete-academic-year-modal"
                                                               data-id="{{$academic_year->id}}">Delete Academic Year</a>
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
        @include('admin/dashboard/academic-year/AcademicYearModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('admin/dashboard/academic-year/academicYearJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/academic-year/academicYearDataTables')
@endpush
