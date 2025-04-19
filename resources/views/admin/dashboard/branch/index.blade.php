@extends('layouts.dash-layout')

@push('title')
    <title>Branches | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Branches
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-branch-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Branch
                            </a>
                        </div>
                        <div class="card-body">
                            <form class="form mb-4" method="post">
                                @csrf
                                @if ($errors->any())
                                    <div class="alert menu-alert">
                                        @foreach ($errors->all() as $error)
                                            <ul>{{ $error }}</ul>
                                        @endforeach
                                    </div>
                                @else
                                @endif
                                <div class="row">
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Status</label>
                                        <select class="form-control" name="branch_is_active" id="#branch_is_active">
                                            <option value="">Choose</option>
                                            <option value="1">ACTIVE</option>
                                            <option value="0">DISABLED</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="branch_name" id="branch_name">
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Contact</label>
                                        <input type="text" class="form-control" name="branch_contact" id="branch_contact">
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Location</label>
                                        <input type="text" class="form-control" name="branch_location" id="branch_location">
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="branch_email" id="branch_email">
                                    </div>
                                    <div class="form-group mb-4 col-md-4">
                                        <label>Created At</label>
                                        <input type="date" class="form-control" name="created_at" id="created_at">
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="button" onclick="filterBranch()" id="btn_search_filter">Search</button>
                            </form>
                            <div class="table-responsive">
                                <table id="BranchesDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Contact</th>
                                            <th>Email</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                            <th>Created At</th>
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
        @include('admin.dashboard.branch.BranchesModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('admin.dashboard.branch.branchesJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin.dashboard.branch.branchesDataTables')
@endpush
