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
            <div class="row">
                {{-- <div class="col-2">
                    <div class="card" style="height: auto">
                        <div class="card-header">
                            <h5>Search by Student ID</h5>
                        </div>
                        <div class="card-body">
                            <form class="form" method="post" action="{{ route('admin_finance_student_report_data') }}" id="finance_get_student_data_form">
                                @csrf
                                <div class="form-group mb-4">
                                    <label>Student ID</label>
                                    <input type="text" name="student_id" value="{{ old('student_id') }}"
                                        class="form-control solid" />
                                </div>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div> --}}
                <div class="col-12">
                    <div class="card" style="height: auto">
                        <div class="card-header">
                            <h5>Search by Student ID</h5>
                        </div>
                        <div class="card-body">
                            <form class="form" method="post" action="{{ route('admin_finance_student_report_data') }}" id="finance_get_student_data_form">
                                @csrf
                                <div class="form-group mb-4">
                                    <label>Student ID</label>
                                    <input type="text" name="student_id" value="{{ old('student_id') }}"
                                        class="form-control solid" />
                                </div>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                    @empty($records)
                        <div class="alert alert-danger alert-dismissible fade show">
                            <svg class="alert-icon me-2" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                            <strong>Error!</strong> No record available.
                        </div>
                    @else
                        <div class="card" style="height: auto">
                            <div class="card-header">
                                <h5>Student Financial Statement</h5>
                                <form action="{{ route('admin_finance_download_student_report') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="student_uuid" value="{{ $student->id }}">
                                    <button class="btn btn-primary" type="submit">Download</button>
                                </form>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <td colspan="2"><img src="{{ asset('assets/images/ghana-emblem.jpg') }}"  class='rounded' width="200"/></td>
                                        <td colspan="2">
                                            <p>{{ $schoolData->school_name}}</p>
                                            <p>{{ $schoolData->school_location }}</p>
                                            <small>{{ $schoolData->school_email }}</small>
                                            <small>{{ $schoolData->school_phoneNumber }}</small>
                                        </td>
                                        <td colspan="2"><img src="{{ $schoolPhoto }}" class='rounded' width="200"/></td>
                                    </tr>
                                    <tr>
                                        <td>Student ID: {{ $student->student_id }}</td>
                                        <td>Name: {{ $student->student_firstname . ' ' . $student->student_othername . ' ' . $student->student_lastname }}</td>
                                        <td>Level / Class: {{ $student->level->level_name }}</td>
                                        <td>House: {{ $student->house->house_name }}</td>
                                        <td>Category: {{ $student->category->category_name }}</td>
                                        <td>Branch: {{ $student->branch->branch_name }}</td>
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
                                                @foreach ($records as $record )
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $record->invoice_id }}</td>
                                                        <td>{{ $record->level->level_name }}</td>
                                                        <td>{{ $record->term->term_name }}</td>
                                                        <td>{{ $record->academic_year->academic_year_start .'/'. $record->academic_year->academic_year_end}}</td>
                                                        <td>{{ $record->description }}</td>
                                                        <td>{{ $record->currency.' '.$record->amount_due }}</td>
                                                        <td>{{ $record->currency.' '.$record->amount_paid }}</td>
                                                        <td>{{ $record->currency.' '.$record->balance }}</td>
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
        </div>
        {{-- Modals --}}
        @push('modals')
            @include('admin/dashboard/finance/reports/modals')
        @endpush
    @endsection
    {{-- page js script --}}
    @push('page-js')
        @include('custom-functions/admin/LevelsInSelectInputBasedOnSchoolJS')
        @include('custom-functions/admin/TermsInSelectInputBasedOnSchoolJS')
        @include('admin/dashboard/finance/reports/js')
    @endpush
    {{-- page datatable script --}}
    @push('datatable')
        @include('admin/dashboard/finance/reports/admissionFeesDataTables')
    @endpush
