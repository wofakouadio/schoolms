@extends('layouts.dash-layout')

@push('title')
    <title>Departments | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Departments
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
                            <a href="/admin/department/new" class="btn btn-rounded btn-primary">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Department
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="DepartmentsDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
