@extends('layouts.dash-layout')

@push('title')
    <title>Feeding Fee | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Feeding Fee
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

            @if(session()->has('success'))
                <p class="text-success">{{ $message }}</p>
            @else
                <p class="text-danger"></p>
            @endif
            <div class="row">
                <div class="col-4">
                    <div class="card" style="height: auto">
                        <div class="card-header">
                            <h5>Feeding Fee Setup</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add_new_feeding_fee_setup">
                                <i class="fa fa-plus-o"></i>
                                New
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table" id="feeding_fee_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fee</th>
                                        <th>Acad. Year</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($records as $record)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $record->school_currency->symbol }} {{ $record->fee }}</td>
                                        <td>{{ $record->school_academic_year->academic_year_start .'/'. $record->school_academic_year->academic_year_end }}</td>
                                        <td>@if($record->is_active == 1) <span class="text-success text-uppercase">active</span> @else <span class="text-danger text-uppercase">disabled</span> @endif</td>
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
                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit_feeding_fee_setup" data-id="{{ $record->id }}">Edit</a>
                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#delete_feeding_fee_setup" data-id="{{ $record->id }}">Delete</a>
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

                <div class="col-8">
                    <div class="card" style="height: auto">
                        <div class="card-header">
                            <h5>Feeding Fee Collection</h5>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modals --}}
        @push('modals')
            @include('admin/dashboard/finance/feeding-fee/modals')
        @endpush
    @endsection
    {{-- page js script --}}
    @push('page-js')
        @include('custom-functions/admin/LevelsInSelectInputBasedOnSchoolJS')
        @include('custom-functions/admin/TermsInSelectInputBasedOnSchoolJS')
        @include('admin/dashboard/finance/feeding-fee/js')
    @endpush
    {{-- page datatable script --}}
    @push('datatable')
        @include('admin/dashboard/finance/feeding-fee/DataTables')
    @endpush
