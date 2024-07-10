@extends('layouts.dash-layout')

@push('title')
    <title>Transactions | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Transactions
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
                <div class="col-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>Search by Student ID</h5>
                        </div>
                        <div class="card-body">
                            <form class="form" method="post" action="{{ route('admin_get_student_transaction') }}">
                                @csrf
                                <div class="form-group mb-4">
                                    <label>Student ID</label>
                                    <input type="text" name="student_id" value="{{ old('student_id') }}" class="form-control solid"/>
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
                            <h5>Student Transactions</h5>
                        </div>
                        {{-- {{ dd($admissionFees) }} --}}
                        <div class="card-body">
                            @empty($transactions)
                                <div class="alert alert-danger"><h5>No Record found</h5></div>
                            @else
                                {{-- {{ dd($studentData) }} --}}
                               <form class="form-group" method="">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Student ID</label>
                                            <input type="text" name="student_id" value="{{ $studentData['student_id'] }}" readonly class="form-control solid">
                                        </div>
                                        <div class="col-6">
                                            <label>Level</label>
                                            <input type="text" name="level" value="{{ $studentData['student_level'] }}" readonly class="form-control solid">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label>Name</label>
                                            <input type="text" name="student_name" value="{{ $studentData['student_name'] }}" readonly class="form-control solid">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Term</label>
                                            <input type="text" name="term" value="" readonly class="form-control solid">
                                        </div>
                                        <div class="col-6">
                                            <label>Academic Year</label>
                                            <input type="text" name="academic_year" value="" readonly class="form-control solid">
                                        </div>
                                    </div>

                                    {{-- <div class="row"> --}}
                                        <ol class="mt-4">
                                            @foreach($transactions as $value)
                                            <li>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <input value="{{ $value->invoice_id }}" name="" class="form-control solid mb-4" readonly>
                                                    </div>
                                                    <div class="col-3">
                                                        <input value="{{ $value->description }}" name="" class="form-control solid mb-4" readonly>
                                                    </div>
                                                    <div class="col-2">
                                                        <input type="text" name="amount_due" class="form-control solid mb-4" readonly value="{{ $value->amount_due }}">
                                                    </div>
                                                    <div class="col-2">
                                                        <input type="text" name="amount_to_pay" class="form-control solid mb-4">
                                                    </div>
                                                    <div class="col-2">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                        </ol>
                                    {{-- </div> --}}
                               </form>
                            @endempty
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{--Modals--}}
    @push('modals')
        @include('admin/dashboard/finance/transactions/modals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('custom-functions/LevelsInSelectInputBasedOnSchoolJS')
    @include('custom-functions/TermsInSelectInputBasedOnSchoolJS')
    @include('admin/dashboard/finance/transactions/js')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/finance/transactions/admissionFeesDataTables')
@endpush
