@extends('layouts.dash-layout')

@push('title')
    <title>Fee Collection | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Fee Collection
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
                <div class="col-3">
                    <div class="card" style="height: auto">
                        <div class="card-header">
                            <h5>Search by Student ID</h5>
                        </div>
                        <div class="card-body">
                            <form class="form" method="post" action="{{ route('admin_get_student_transaction') }}">
                                @csrf
                                <div class="form-group mb-4">
                                    <label>Student ID</label>
                                    <input type="text" name="student_id" value="{{ old('student_id') }}"
                                        class="form-control solid" />
                                </div>
                                {{-- <div class="form-control"> --}}
                                <button class="btn btn-primary" type="submit">Submit</button>
                                {{-- </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="card">
                        <div class="card-header">
                            <h5>Fee Collection</h5>
                        </div>
                        {{-- {{ dd($admissionFees) }} --}}
                        <div class="card-body">
                            @empty($transactions)
                                <div class="alert alert-danger">
                                    <h5>No Record found</h5>
                                </div>
                            @else
                                {{-- {{ dd($studentData) }} --}}
                                <form class="form-group" method="POST" id="transaction_form"
                                    action="{{ route('admin_student_new_fee_collection') }}">
                                    @csrf
                                    <div class="alert menu-alert">
                                        <ul></ul>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Student ID</label>
                                            <input type="text" name="studentId" value="{{ $studentData['student_id'] }}"
                                                readonly class="form-control solid">
                                            <input type="hidden" name="student_id" value="{{ $studentData['student_uuid'] }}">
                                        </div>
                                        <div class="col-6">
                                            <label>Level</label>
                                            <input type="text" name="level" value="{{ $studentData['student_level'] }}"
                                                readonly class="form-control solid">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Name</label>
                                            <input type="text" name="student_name" value="{{ $studentData['student_name'] }}"
                                                readonly class="form-control solid">
                                        </div>
                                        <div class="col-6">
                                            <label>OverPaid Amount({{ $schoolCurrency->getData()->default_currency_symbol }})</label>
                                            <input type="text" name="wallet" value="{{ $studentData['wallet'] }}"
                                                readonly class="form-control solid">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Amount Paid</label>
                                            <div class="input-group">
                                                {{-- {{ dd($schoolCurrency) }} --}}
                                                <span
                                                    class="input-group-text">{{ $schoolCurrency->getData()->default_currency_symbol }}</span>
                                                <input type="text" name="amount_paid" value="" required
                                                    class="form-control solid" placeholder="Enter Amount">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label>Payment Method</label>
                                            <select class="form-control solid" name="payment_method" required>
                                                <option>Choose</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Wallet">Wallet</option>
                                                <option value="Mobile Money">Mobile Money</option>
                                                <option value="Bank Transfer">Bank Transfer</option>
                                                <option value="Credit Card">Credit Card</option>
                                            </select>
                                        </div>
                                    </div>
                                    <h4 class="mb-2 mt-2">Description</h4>
                                    {{-- <div class="row"> --}}
                                    <ol class="mt-4">
                                        @foreach ($transactions as $key => $value)
                                            <li>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <label>Invoice Number</label>

                                                        <input value="{{ $value->id }}"
                                                            name="transaction_allocations[{{ $key }}][id]"
                                                            class="form-control solid mb-4" hidden>

                                                        <input value="{{ $value->invoice_id }}"
                                                            name="transaction_allocations[{{ $key }}][invoice_number]"
                                                            class="form-control solid mb-4" readonly>
                                                    </div>
                                                    <div class="col-2">
                                                        <label>Item</label>
                                                        <input value="{{ $value->description }}"
                                                            name="transaction_allocations[{{ $key }}][item]"
                                                            class="form-control solid mb-4" readonly>
                                                    </div>
                                                    <div class="col-2">
                                                        <label>Amount Due</label>
                                                        <input type="text" name="transaction_allocations[{{ $key }}][amount_due]"
                                                            class="form-control solid mb-4" readonly
                                                            value="{{ $value->amount_due }}">
                                                    </div>
                                                    <div class="col-2">
                                                        <label>Amount to allocate</label>
                                                        <input type="number" name="transaction_allocations[{{ $key }}][amount_to_pay]"
                                                            class="form-control solid mb-4 amount_to_pay" id="amount_to_pay">
                                                    </div>
                                                    <div class="col-3">
                                                        <label>Transaction ID/Reference</label>
                                                        <input type="number" name="transaction_allocations[{{ $key }}][transaction_number]"
                                                            class="form-control solid mb-4">
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ol>
                                    <div class="mb-4">
                                        <button type="button" class="btn btn-primary"
                                            id="btn_process_transaction">Process</button>
                                    </div>
                                    {{-- </div> --}}
                                </form>
                            @endempty
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modals --}}
        @push('modals')
            @include('admin/dashboard/finance/transactions/modals')
        @endpush
    @endsection
    {{-- page js script --}}
    @push('page-js')
        @include('custom-functions/admin/LevelsInSelectInputBasedOnSchoolJS')
        @include('custom-functions/admin/TermsInSelectInputBasedOnSchoolJS')
        @include('admin/dashboard/finance/transactions/js')
    @endpush
    {{-- page datatable script --}}
    @push('datatable')
        @include('admin/dashboard/finance/transactions/admissionFeesDataTables')
    @endpush
