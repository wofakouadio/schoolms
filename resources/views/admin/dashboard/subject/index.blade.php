@extends('layouts.dash-layout')

@push('title')
    <title>Subjects | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Subjects
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
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-subject-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Subject
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="SubjectsDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Level</th>
                                            <th>Status</th>
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
            @include('admin/dashboard/subject/SubjectsModals')
        @endpush
    @endsection
    {{--page js script--}}
    @push('page-js')
        @include('custom-functions/admin/LevelsInSelectInputBasedOnBranchJS')
        @include('admin/dashboard/subject/subjectsJS')
    @endpush
    {{--page datatable script--}}
    @push('datatable')
        @include('admin/dashboard/subject/subjectsDataTables')
    @endpush
