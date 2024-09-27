@extends('layouts.dash-layout')

@push('title')
    <title>Assign Subject to Level | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Assign Subject to Level
    </div>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            @if($schoolTerm == null)
                <x-dash.dash-no-term/>
            @else
                <x-dash.dash-term :term_name="$schoolTerm['term_name']"
                                  :term_academic_year="$schoolTerm['term_academic_year']"/>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-subject-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Subject
                            </a>
                        </div> --}}
                        {{-- <div class="card-body"> --}}
                            <form method="post" id="">
                                @csrf
                                {{-- <div class="modal-dialog" role="document">
                                    <div class="modal-content"> --}}
                                        {{-- <div class="modal-header">
                                            <h5 class="modal-title">New Subject</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                            </button>
                                        </div> --}}
                                        {{-- <div class="modal-body"> --}}
                                            <div class="alert menu-alert">
                                                <ul>
                        {{--                            <li></li>--}}
                                                </ul>
                                            </div>
                                            <div class="col-xl-12 mb-4">
                                                <label  class="form-label font-w600">Subject<span class="text-danger scale5 ms-2">*</span></label>
                                                <select class="form-control" name="subject">
                                                    <option value=""></option>
                                                    @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xl-12 mb-4">
                                                <label  class="form-label font-w600">Level<span class="text-danger scale5 ms-2">*</span></label>
                                                <select class="form-control" name="level">
                                                    <option value=""></option>
                                                    @foreach ($levels as $level)
                                                    <option value="{{ $level->id }}">{{ $level->level_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- <div class="col-xl-12 mb-4">
                                                <label  class="form-label font-w600">Description</label>
                                                <textarea class="form-control solid" rows="5" aria-label="With textarea" name="description">{{old('description')}}</textarea>
                                            </div> --}}
                                        {{-- </div> --}}
                                        {{-- <div class="modal-footer"> --}}
                                            {{-- <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button> --}}
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        {{-- </div> --}}
                                    {{-- </div>
                                </div> --}}
                            </form>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
        {{--Modals--}}
        @push('modals')
            @include('admin/dashboard/subject/SubjectsModals')
        @endpush
    @endsection
    {{--page js script--}}
    @push('page-js')
        @include('custom-functions/admin/DepartmentsInSelectInputBasedOnSchoolJS')
        @include('admin/dashboard/subject/subjectsJS')
    @endpush
    {{--page datatable script--}}
    @push('datatable')
        @include('admin/dashboard/subject/subjectsDataTables')
    @endpush
