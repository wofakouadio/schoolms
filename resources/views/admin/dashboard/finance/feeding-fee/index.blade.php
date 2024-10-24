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

            <div class="default-tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#home" aria-selected="true" role="tab">Feeding Fee Setup</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#profile" aria-selected="false" role="tab" tabindex="-1">Feeding Fee Collection</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade" id="home" role="tabpanel" style="">
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
                    <div class="tab-pane fade active show" id="profile" role="tabpanel" style="">
                        <div class="card" style="height: auto">
                            <div class="card-header">
                                <h5>Feeding Fee Collection</h5>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#feeding_fee_new_collection">
                                    <i class="fa fa-plus-o"></i>
                                    New
                                </button>
                            </div>
                            {{-- {{ dd($collectionSummary) }} --}}
                            <div class="card-body">
                                <table class="table table-responsive" id="feeding_fee_collection_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Term</th>
                                            <th>Week</th>
                                            <th>Date</th>
                                            <th>Presents</th>
                                            <th>Don't Pay</th>
                                            <th>Credits</th>
                                            <th>Arrears Clearance</th>
                                            <th>Advance Payment</th>
                                            <th>Feeding Fee</th>
                                            <th>Amount Realized</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($collectionSummary as $k => $summary)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $summary->school_term->term_name .' - '. $summary->school_academic_year->academic_year_start .'/'. $summary->school_academic_year->academic_year_end}}</td>
                                                <td>{{ $summary->week }}</td>
                                                <td>{{ $summary->date }}</td>
                                                <td>{{ $summary->total_number_of_presents }}</td>
                                                <td>{{ $summary->total_number_of_who_do_not_pay }}</td>
                                                <td>{{ $summary->total_number_of_credits }}</td>
                                                <td>{{ $summary->total_arrears_clearance }}</td>
                                                <td>{{ $summary->total_advance_payment }}</td>
                                                <td>{{ $summary->school_feeding_fee->fee }}</td>
                                                <td>{{ $summary->school_feeding_fee->school_currency->symbol .' '. $summary->total_amount_realized }}</td>
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
            @include('admin/dashboard/finance/feeding-fee/modals')
        @endpush
    @endsection
    {{-- page js script --}}
    @push('page-js')
        @include('custom-functions/admin/LevelsInSelectInputBasedOnSchoolJS')
        @include('admin/dashboard/finance/feeding-fee/js')
    @endpush
    {{-- page datatable script --}}
    @push('datatable')
        @include('admin/dashboard/finance/feeding-fee/DataTables')
    @endpush
