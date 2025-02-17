@extends('layouts.dash-layout')

@push('title')
    <title>Fee Management | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Fee Management
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
            <div class="alert menu-alert">
                <ul></ul>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="card" style="height: auto">
                        <div class="card-header">
                            <h5>Search by Student ID</h5>
                        </div>
                        <div class="card-body">
                            <form class="form" method="GET" id="search_student_form">
                                @csrf
                                <div class="form-group mb-4">
                                    <label>Student ID</label>
                                    {{-- <input type="text" name="student_id" value="{{ old('student_id') }}"
                                        class="form-control solid" /> --}}
                                        <select class="dropdown-groups form-control solid" name="student_id" id="single-select">
                                            <option>Choose</option>
                                            @foreach($studentsList as $key => $students)
                                            {{-- @php $category = $students->first()->category; @endphp --}}
                                            {{-- <optgroup label="{{ $category->category_name }}"> --}}
                                                    @foreach($students as $student)
                                                    <option value="{{ $student->id }}">{{ $student->student_id . ' ' . $student->student_firstname .' '.$student->student_othername.' '.$student->student_lastname.' '.$student->level->level_name}}</option>
                                                @endforeach
                                            {{-- </optgroup> --}}
                                            @endforeach
                                        </select>
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
                            <h5>Fee Management</h5>
                        </div>
                        <div class="card-body student-fee-collection-holder">
                            <form class="form-group" method="POST" id="transaction_form">
                                @csrf
                                <div class="row">
                                    <div class="col-4">
                                        <label>Student ID</label>
                                        <input type="text" name="studentId" readonly class="form-control solid">
                                    </div>
                                    <div class="col-4">
                                        <label>Name</label>
                                        <input type="text" name="student_name" readonly class="form-control solid">
                                    </div>
                                    <div class="col-4">
                                        <label>Gender</label>
                                        <input type="text" name="student_gender" readonly class="form-control solid">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label>Level</label>
                                        <input type="text" name="level" readonly class="form-control solid">
                                    </div>
                                    <div class="col-4">
                                        <label>House</label>
                                        <input type="text" name="house" readonly class="form-control solid">
                                    </div>
                                    <div class="col-4">
                                        <label>Residency Type</label>
                                        <input type="text" name="residency_type" readonly class="form-control solid">
                                    </div>
                                </div>
                                <h4 class="mb-2 mt-2">Items</h4>

                                {{-- <div class="row"> --}}
                                <div id="items"></div>
                                    {{-- <div class="col-6 mb-4">
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
                                    </div> --}}
                                {{-- </div> --}}

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modals --}}
        @push('modals')
            @include('admin/dashboard/finance/student-transactions/modals')
        @endpush
    @endsection
    {{-- page js script --}}
    @push('page-js')
        {{-- @include('custom-functions/LevelsInSelectInputBasedOnSchoolJS')
        @include('custom-functions/TermsInSelectInputBasedOnSchoolJS') --}}
        @include('admin/dashboard/finance/student-transactions/js')
    @endpush
    {{-- page datatable script --}}
    @push('datatable')
        {{-- @include('admin/dashboard/finance/student-transactions/admissionFeesDataTables') --}}
    @endpush
