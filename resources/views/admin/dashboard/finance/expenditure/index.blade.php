@extends('layouts.dash-layout')

@push('title')
    <title>Expenditure | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Expenditure
    </div>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                @if($schoolTerm == null)
                    <x-dash.dash-no-term/>
                @else
                    <x-dash.dash-term :term_name="$schoolTerm['term_name']"
                                      :academic_year_start="$schoolTerm['academic_year']['academic_year_start']"
                                      :academic_year_end="$schoolTerm['academic_year']['academic_year_end']"/>
                @endif
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-expenditure-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Entry
                            </a>
{{--                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"--}}
{{--                               data-bs-target="#new-student-admission-using-excel-modal">--}}
{{--                                <span class="btn-icon-start text-primary">--}}
{{--                                    <i class="fa fa-plus color-primary"></i>--}}
{{--                                </span> New Entry using Excel/CSV file--}}
{{--                            </a>--}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ExpenditureDatatables" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Date of Birth</th>
                                        <th>Gender</th>
                                        <th>Level</th>
                                        <th>Residency</th>
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
        @include('admin/dashboard/finance/expenditure/ExpenditureModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('admin/dashboard/finance/expenditure/expenditureJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/finance/expenditure/expenditureDataTables')
@endpush
