@extends('layouts.dash-layout')

@push('title')
    <title>Student Bill | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Student Bill
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
                    <div class="card" style="height: auto">
                        <div class="card-header">
                            <h5>Search by Student ID</h5>
                        </div>
                        <div class="card-body">
                            <form class="form" method="post" action="{{ route("admin_get_student_data") }}" id="get-student-form">
                                @csrf
                                @if($errors->any())
                                    <div class="alert menu-alert">
                                        @foreach($errors->all() as $error)
                                            <ul>{{ $error }}</ul>
                                        @endforeach
                                    </div>
                                @else
                                @endif
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
                @empty($studentData)
                @else
                    <div class="col-9">
                        <div class="card">
                            <div class="card-header">
                                <h5>New Bill to Student</h5>
                            </div>
                            <div class="card-body">
                                <form class="form-group" method="POST" id="student_bill_form">
                                    @csrf
                                    <div class="alert menu-alert">
                                        <ul></ul>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <label>Student ID</label>
                                            <input type="text" name="studentId" value="{{ $studentData->student_id }}"
                                                readonly class="form-control solid">
                                            <input type="hidden" name="student_id" value="{{ $studentData->id }}">
                                        </div>
                                        <div class="col-4">
                                            <label>Name</label>
                                            <input type="text" name="student_name" value="{{ $studentData->student_firstname . " " . $studentData->student_othername . " " . $studentData->student_lastname }}"
                                                readonly class="form-control solid">
                                        </div>
                                        <div class="col-4">
                                            <label>Gender</label>
                                            <input type="text" name="student_gender" value="{{ $studentData->student_gender }}"
                                                readonly class="form-control solid">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <label>Level</label>
                                            <input type="text" name="level" value="{{ $studentData->level->level_name }}"
                                                readonly class="form-control solid">
                                                <input type="hidden" name="level_id" value="{{ $studentData->student_level }}">
                                                <input type="hidden" name="term_id" value="{{ $schoolTerm->id }}">
                                                <input type="hidden" name="academic_year_id" value="{{ $schoolTerm->term_academic_year }}">
                                                <input type="hidden" name="branch_id" value="{{ $studentData->student_branch }}">
                                        </div>
                                        <div class="col-4">
                                            <label>House</label>
                                            <input type="text" name="level" value="{{ $studentData->house->house_name }}"
                                                readonly class="form-control solid">
                                        </div>
                                        <div class="col-4">
                                            <label>Residency Type</label>
                                            <input type="text" name="residency_type" value="{{ $studentData->student_residency_type }}" readonly class="form-control solid">
                                        </div>
                                    </div>
                                    <h4 class="mb-2 mt-2">Item</h4>
                                    <div class="row">
                                        <div class="col-6 mb-4">
                                            <label class="form-label font-w600">Description<span class="text-danger scale5
                                        ms-2">*</span></label>
                                            <input type="text" name="bill_description" value="{{old('bill_description')}}" class="form-control solid">
                                        </div>
                                        <div class="col-6 mb-4">
                                            <label class="form-label font-w600">Amount<span class="text-danger scale5
                                        ms-2">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ $schoolCurrency->getData()->default_currency_symbol }}</span>
                                                <input type="text" name="bill_amount" value="{{old('bill_amount')}}" class="form-control solid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <button type="submit" class="btn btn-primary"
                                            id="btn_process_transaction">Process</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endempty
            </div>
        </div>
    {{--Modals--}}
    @push('modals')
        @include('admin/dashboard/finance/student-bill/StudentBillModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('custom-functions/LevelsInSelectInputBasedOnSchoolJS')
    @include('custom-functions/TermsInSelectInputBasedOnSchoolJS')
    @include('admin/dashboard/finance/student-bill/StudentBillJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/finance/student-bill/StudentBillDataTables')
@endpush
