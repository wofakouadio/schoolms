@extends('layouts.dash-layout')

@push('title')
    <title>Houses | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Houses
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
                               data-bs-target="#new-house-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New House
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="HousesDataTables" class="display" style="min-width: 845px">
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
        @include('admin/dashboard/house/HousesModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('custom-functions/BranchesInSelectInputJS')
    @include('admin/dashboard/house/housesJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/house/housesDataTables')
@endpush
