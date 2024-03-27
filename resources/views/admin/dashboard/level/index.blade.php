@extends('layouts.dash-layout')

@push('title')
    <title>Levels | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Levels
    </div>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            {{-- <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)" id="breadcrumb-header">Form</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)" id="breadcrumb-title">Element</a></li>
                </ol>
            </div> --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-level-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Level
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="LevelsDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Branch</th>
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
        @include('admin/dashboard/level/LevelsModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('custom-functions/BranchesInSelectInputJS')
    @include('admin/dashboard/level/levelsJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/level/levelsDataTables')
@endpush
