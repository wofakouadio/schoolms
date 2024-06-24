@extends('layouts.dash-layout')

@push('title')
    <title>Students End of Term | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Students End of Term
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
                <div class="col-12">
                    <div class="card" style="height: auto">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                                data-bs-target="#new-end-term-setup-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> End of Term New Entry
                            </a>
                        </div>
                        <div class="card-body">

                            <div class="dropdown mt-4 mb-4">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Filter By
                                    <i class="flaticon-037-funnel"></i>
                                </button>
                                <div class="dropdown-menu" style="width:500px; height: auto">
                                    <div class="p-5">
                                        <div class="form-group">
                                            <label class="form-label">Term</label>
                                            <select class="form-control" name="Term"></select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Level</label>
                                            <select class="form-control" name="level"></select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Student</label>
                                            <select name="student" class="form-control"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="StudentsEndTermDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Term</th>
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Level</th>
                                            <th>Subject</th>
                                            <th>Score</th>
                                            <th>Percentage ({{ $exam_percentage }}%)</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {{-- {{ dd($EndTermRecords) }} --}}
                                        @unless(count($EndTermRecords) == 0)
                                            {{ $counter = 1 }}
                                            @foreach($EndTermRecords as $record)
                                                <tr>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>{{ $record->term->term_name }} - {{ $record->term->academic_year->academic_year_start .'/'. $record->term->academic_year->academic_year_end }}</td>
                                                    <td>{{ $record->student->student_id }}</td>
                                                    <td>{{ $record->student->student_firstname .' '. $record->student->student_lastname }}</td>
                                                    <td>{{ $record->end_term->level->level_name }}</td>
                                                    <td>{{ $record->subject->subject_name }}</td>
                                                    <td>{{ $record->score }}</td>
                                                    <td>{{ $record->percentage }}</td>
                                                </tr>
                                            @endforeach
                                        @endunless
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
            @include('admin/dashboard/assessment/end-of-term/EndTermModals')
        @endpush
    @endsection
    {{-- page js script --}}
    @push('page-js')
        @include('admin/dashboard/assessment/end-of-term/EndTermJS')
        @include('custom-functions/ActiveTermInputBasedOnSchoolJS')
        @include('custom-functions/LevelsInSelectInputBasedOnSchoolJS')
    @endpush
    {{-- page datatable script --}}
    @push('datatable')
        @include('admin/dashboard/assessment/end-of-term/StudentsEndTermDataTables')
    @endpush
