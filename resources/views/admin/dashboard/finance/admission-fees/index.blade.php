@extends('layouts.dash-layout')

@push('title')
    <title>Admission Fees | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Admission Fees
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
                               data-bs-target="#new-admission-fee-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Admission Fee
                            </a>
                        </div>
                        {{-- {{ dd($admissionFees) }} --}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="AdmissionFeesDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>Academic Year</th>
                                            <th>Branch</th>
                                            <th>Department</th>
                                            <th>Amount</th>
                                            <th>Last Updated</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($admissionFees as  $value)
                                            <tr>
                                                <td>{{ $value->academic_year->academic_year_start.'/'.$value->academic_year->academic_year_end }}</td>
                                                <td>{{ $value->branch->branch_name }}</td>
                                                <td>{{ $value->department->name }}</td>
                                                <td>{{ money($value->amount) }}</td>
                                                <td>{{ date("l F j, Y", strtotime($value->updated_at)) }}</td>
                                                <td>
                                                    @if($value->is_active == 1)
                                                        <div class="bootstrap-badge">
                                                            <span class="badge badge-xl light badge-success text-uppercase">active</span>
                                                        </div>
                                                    @else
                                                        <div class="bootstrap-badge">
                                                            <span class="badge badge-xl light badge-danger text-uppercase">disabled</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown" aria-expanded="false">
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
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit-admission-fee-modal" data-id="{{ $value->id }}">Edit Fee</a>
                                                            <a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#delete-admission-fee-modal" data-id="{{ $value->id }}">Delete Fee</a>
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
        @include('admin/dashboard/finance/admission-fees/modals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('custom-functions/admin/LevelsInSelectInputBasedOnSchoolJS')
    @include('custom-functions/admin/TermsInSelectInputBasedOnSchoolJS')
    @include('admin/dashboard/finance/admission-fees/js')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/finance/admission-fees/admissionFeesDataTables')
@endpush
