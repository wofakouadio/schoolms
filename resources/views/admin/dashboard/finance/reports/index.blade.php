@extends('layouts.dash-layout')

@push('title')
    <title>Financial Report | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Financial Report
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
            {{-- putting ui in bootstrap tab for easy management and view --}}
            {{-- <div class="default-tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link @if ($is_active == '') active @elseif($is_active == 'arrears') active @else @endif"
                            data-bs-toggle="tab" href="#arrears_report" aria-selected="true" role="tab">
                            Transactions Report
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item" role="presentation">
                        <a class="nav-link @if ($is_active == 'fees') active @endif" data-bs-toggle="tab"
                            href="#fees_report" aria-selected="false" role="tab">
                            Fee Report
                        </a>
                    </li> --}}
                {{-- </ul> --}}
                {{-- <div class="tab-content"> --}}
                    {{-- <div class="tab-pane fade @if ($is_active == '') active show @elseif($is_active == 'arrears') active show @else @endif"
                        id="arrears_report" role="tabpanel"> --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="card" style="height: auto">
                                    <div class="card-header">
                                        <h5>Transaction Report</h5>
                                    </div>
                                    <div class="card-body">
                                        <form class="form get_student_form" method="post"
                                            action="{{ route('admin_finance_student_arrears_report_data') }}" id="finance_get_student_arrears_data_form">
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
                                                    <label>Invoice ID</label>
                                                    <input type="text" class="form-control" name="invoice_id" id="invoice_id">
                                                </div>
                                                <div class="form-group mb-4 col-md-4">
                                                    <label>Level</label>
                                                    <select class="form-control dropdown-groups level" name="level" id="level">
                                                    </select>
                                                </div>
                                                <div class="form-group mb-4 col-md-4">
                                                    <label>Term</label>
                                                    <select class="form-control dropdown-groups term" name="term" id="term">
                                                    </select>
                                                </div>
                                                <div class="form-group mb-4 col-md-4">
                                                    <label>Academic Year</label>
                                                    <select class="form-control dropdown-groups academic_year" name="academic_year" id="academic_year">
                                                        <option value="">Select Academic Year</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-4 col-md-4">
                                                    <label>Transaction Type</label>
                                                    <select class="form-control dropdown-groups" name="transaction_type" id="transaction_type">
                                                        <option value="">Choose</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Wallet">Wallet</option>
                                                        <option value="Mobile Money">Mobile Money</option>
                                                        <option value="Bank Transfer">Bank Transfer</option>
                                                        <option value="Credit Card">Credit Card</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-4 col-md-4">
                                                    <label>Payment Status</label>
                                                    <select class="form-control dropdown-groups" name="payment_status" id="payment_status">
                                                        <option value="">Choose</option>
                                                        <option value="awaiting_payment">Unpaid</option>
                                                        <option value="partial_payment">Partially Paid</option>
                                                        <option value="paid">Paid</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-4 col-md-4">
                                                    <label>Reference</label>
                                                    <input type="text" class="form-control" name="reference" id="reference">
                                                </div>
                                                <div class="form-group mb-4 col-md-4">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control" name="description" id="description">
                                                </div>
                                                <div class="form-group mb-4 col-md-4">
                                                    <label>Student ID</label>
                                                    <input type="text" class="form-control" name="student_id" id="student_id">
                                                </div>
                                                <div class="form-group mb-4 col-md-4">
                                                    <label>Student Name</label>
                                                    <input type="text" class="form-control" name="student_name" id="student_name">
                                                </div>
                                                <div class="form-group mb-4 col-md-4">
                                                    <label>Paid At From</label>
                                                    <input type="date" class="form-control" name="paid_at_from" id="paid_at_from">
                                                </div>
                                                <div class="form-group mb-4 col-md-4">
                                                    <label>Paid At To</label>
                                                    <input type="date" class="form-control" name="paid_at_to" id="paid_at_to">
                                                </div>
                                                <div class="form-group mb-4 col-md-4">
                                                    <label>Created At From</label>
                                                    <input type="date" class="form-control" name="created_at_from" id="created_at_from">
                                                </div>
                                                <div class="form-group mb-4 col-md-4">
                                                    <label>Created At To</label>
                                                    <input type="date" class="form-control" name="created_at_to" id="created_at_to">
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="button" onclick="filterTransactionTable()" id="btn_search_filter">Search</button>
                                        </form>
                                        <div class="table-responsive mt-5">
                                            <table class="table table-sm table-hover general-report" id="transaction_report_table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Invoice #</th>
                                                        <th>Student ID</th>
                                                        <th>Student Name</th>
                                                        <th>Level</th>
                                                        <th>Term</th>
                                                        <th>Acad. Year</th>
                                                        <th>Description</th>
                                                        <th>Due</th>
                                                        <th>Paid</th>
                                                        <th>Balance</th>
                                                        <th>Transac. Type</th>
                                                        <th>Status</th>
                                                        <th>Paid At</th>
                                                        <th>Created At</th>
                                                        <th>Reference</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        <div>
                                    </div>
                                </div>
                                {{-- {{ dd($student) }} --}}
                                {{-- @empty($arrears_records)
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <svg class="alert-icon me-2" viewBox="0 0 24 24" width="24" height="24"
                                            stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polygon
                                                points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                            </polygon>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                        <strong>Error!</strong> No record available.
                                    </div>
                                @else --}}
                                    {{-- <div class="card" style="height: auto">
                                        <div class="card-header">
                                            <h5>Student Arrears Statement</h5>
                                            <form action="{{ route('admin_finance_download_student_arrears_report') }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="student_uuid" value="{{ $data['student']['id'] }}">
                                                <button class="btn btn-primary" type="submit">Download</button>
                                            </form>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <tr>
                                                    <td colspan="2"><img src="{{ asset('assets/images/ghana-emblem.jpg') }}"
                                                            class='rounded' width="200" /></td>
                                                    <td colspan="2">
                                                        <p>{{ $data['schoolData']['school_name'] }}</p>
                                                        <p>{{ $data['schoolData']['school_location'] }}</p>
                                                        <small>{{ $data['schoolData']['school_email'] }}</small>
                                                        <small>{{ $data['schoolData']['school_phoneNumber'] }}</small>
                                                    </td>
                                                    <td colspan="2"><img src="{{ $data['schoolPhoto'] }}" class='rounded'
                                                            width="200" /></td>
                                                </tr>
                                                <tr>
                                                    <td>Student ID: {{ $data['student']['student_id'] }}</td>
                                                    <td>Name:
                                                        {{ $data['student']['student_firstname'] . ' ' . $data['student']['student_othername'] . ' ' . $data['student']['student_lastname'] }}
                                                    </td>
                                                    <td>Level / Class: {{ $data['student']['level']['level_name'] }}</td>
                                                    <td>House: {{ $data['student']['house']['house_name'] }}</td>
                                                    <td>Category: {{ $data['student']['category']['category_name'] }}</td>
                                                    <td>Branch: {{ $data['student']['branch']['branch_name'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <table class="table">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Invoice #</th>
                                                                <th>Level</th>
                                                                <th>Term</th>
                                                                <th>Acad. Year</th>
                                                                <th>Description</th>
                                                                <th>Due</th>
                                                                <th>Paid</th>
                                                                <th>Balance</th>
                                                                <th>Transac. Type</th>
                                                                <th>Status</th>
                                                                <th>Paid Date</th>
                                                                <th>Reference</th>
                                                            </tr>
                                                            @foreach ($arrears_records as $record)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $record->invoice_id }}</td>
                                                                    <td>{{ $record->level->level_name }}</td>
                                                                    <td>{{ $record->term->term_name }}</td>
                                                                    <td>{{ $record->academic_year->academic_year_start . '/' . $record->academic_year->academic_year_end }}
                                                                    </td>
                                                                    <td>{{ $record->description }}</td>
                                                                    <td>{{ $record->currency . ' ' . $record->amount_due }}</td>
                                                                    <td>{{ $record->currency . ' ' . $record->amount_paid }}</td>
                                                                    <td>{{ $record->currency . ' ' . $record->balance }}</td>
                                                                    <td>{{ $record->transaction_type ?? 'N/A' }}</td>
                                                                    <td>{{ $record->payment_statement ?? 'N/A' }}</td>
                                                                    <td>{{ $record->paid_at ?? 'N/A' }}</td>
                                                                    <td>{{ $record->reference ?? 'N/A' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div> --}}
                                {{-- @endempty --}}
                            </div>
                        </div>
                    {{-- </div> --}}
                    {{-- <div class="tab-pane fade @if ($is_active == 'fees') active show @else @endif" id="fees_report"
                        role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card" style="height: auto">
                                    <div class="card-header">
                                        <h5>Search by Student ID</h5>
                                    </div>
                                    <div class="card-body">
                                        <form class="form get_student_form" method="post"
                                            action="{{ route('admin_finance_student_report_data') }}"
                                            id="finance_get_student_data_form">
                                            @csrf
                                            @if ($errors->any())
                                                <div class="alert menu-alert">
                                                    @foreach ($errors->all() as $error)
                                                        <ul>{{ $error }}</ul>
                                                    @endforeach
                                                </div>
                                            @else
                                            @endif
                                            <div class="form-group mb-4">
                                                <label>Department</label>
                                                <select class="dropdown-groups form-control solid department_id" name="department_id"
                                                    id="single-select">
                                                    <option>Choose</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Level / Class</label>
                                                <select class="dropdown-groups form-control solid level_id" name="level_id"
                                                    id="single-select"></select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label>Student ID</label>
                                                <select class="dropdown-groups form-control solid student_uuid" name="student_uuid"
                                                    id="single-select" required></select>
                                            </div>
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                                @empty($records)
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <svg class="alert-icon me-2" viewBox="0 0 24 24" width="24" height="24"
                                            stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polygon
                                                points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                            </polygon>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                        <strong>Error!</strong> No record available.
                                    </div>
                                @else
                                    <div class="card" style="height: auto">
                                        <div class="card-header">
                                            <h5>Student Financial Statement</h5>
                                            <form action="{{ route('admin_finance_download_student_report') }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="student_uuid"
                                                    value="{{ $data['student']['id'] }}">
                                                <button class="btn btn-primary" type="submit">Download</button>
                                            </form>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <tr>
                                                    <td colspan="2"><img
                                                            src="{{ asset('assets/images/ghana-emblem.jpg') }}"
                                                            class='rounded' width="200" /></td>
                                                    <td colspan="2">
                                                        <p>{{ $data['schoolData']['school_name'] }}</p>
                                                        <p>{{ $data['schoolData']['school_location'] }}</p>
                                                        <small>{{ $data['schoolData']['school_email'] }}</small>
                                                        <small>{{ $data['schoolData']['school_phoneNumber'] }}</small>
                                                    </td>
                                                    <td colspan="2"><img src="{{ $data['schoolPhoto'] }}" class='rounded'
                                                            width="200" /></td>
                                                </tr>
                                                <tr>
                                                    <td>Student ID: {{ $data['student']['student_id'] }}</td>
                                                    <td>Name:
                                                        {{ $data['student']['student_firstname'] . ' ' . $data['student']['student_othername'] . ' ' . $data['student']['student_lastname'] }}
                                                    </td>
                                                    <td>Level / Class: {{ $data['student']['level']['level_name'] }}</td>
                                                    <td>House: {{ $data['student']['house']['house_name'] }}</td>
                                                    <td>Category: {{ $data['student']['category']['category_name'] }}</td>
                                                    <td>Branch: {{ $data['student']['branch']['branch_name'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <table class="table">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Invoice #</th>
                                                                <th>Level</th>
                                                                <th>Term</th>
                                                                <th>Acad. Year</th>
                                                                <th>Description</th>
                                                                <th>Due</th>
                                                                <th>Paid</th>
                                                                <th>Balance</th>
                                                                <th>Transac. Type</th>
                                                                <th>Status</th>
                                                                <th>Paid Date</th>
                                                                <th>Reference</th>
                                                            </tr>
                                                            @foreach ($records as $record)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $record->invoice_id }}</td>
                                                                    <td>{{ $record->level->level_name }}</td>
                                                                    <td>{{ $record->term->term_name }}</td>
                                                                    <td>{{ $record->academic_year->academic_year_start . '/' . $record->academic_year->academic_year_end }}
                                                                    </td>
                                                                    <td>{{ $record->description }}</td>
                                                                    <td>{{ $record->currency . ' ' . $record->amount_due }}</td>
                                                                    <td>{{ $record->currency . ' ' . $record->amount_paid }}</td>
                                                                    <td>{{ $record->currency . ' ' . $record->balance }}</td>
                                                                    <td>{{ $record->transaction_type ?? 'N/A' }}</td>
                                                                    <td>{{ $record->payment_statement ?? 'N/A' }}</td>
                                                                    <td>{{ $record->paid_at ?? 'N/A' }}</td>
                                                                    <td>{{ $record->reference ?? 'N/A' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                @endempty
                            </div>
                        </div>
                    </div> --}}
                {{-- </div> --}}
            {{-- </div> --}}
        {{-- </div> --}}
        {{-- Modals --}}
        @push('modals')
            @include('admin.dashboard.finance.reports.modals')
        @endpush
    @endsection
    {{-- page js script --}}
    @push('page-js')
        @include('custom-functions.admin.LevelsInSelectInputBasedOnSchoolJS')
        @include('custom-functions.admin.TermsInSelectInputBasedOnSchoolJS')
        @include('custom-functions.admin.AcademicYearsInSelectInputBasedOnSchoolJS')
        @include('custom-functions.admin.DepartmentsInSelectInputBasedOnSchoolJS')
        @include('custom-functions.admin.StudentsListBasedOnDepartmentAndLevelJS')
        @include('admin.dashboard.finance.reports.js')
    @endpush
    {{-- page datatable script --}}
    @push('datatable')
        @include('admin.dashboard.finance.reports.general_reports')
    @endpush
