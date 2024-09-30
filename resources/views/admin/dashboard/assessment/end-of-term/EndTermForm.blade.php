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
                        <div class="card-body">
                            <form method="post" id="insert-student-end-term-form">
                                @csrf
                                <div class="alert menu-alert">
                                    <ul></ul>
                                </div>
                                <div class="row">
                                    {{--                                                {{dd($studentData)}} --}}
                                    {{--                                                {{dd($studentSubjectsLevel)}} --}}
                                    {{--                                                {{dd($academicYearSession)}} --}}
                                    {{--                                                {{dd($studentClassAssessment)}} --}}
                                    <h4 class="text-primary">Student Data</h4>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Student ID<span
                                                class="text-danger scale5
                            ms-2">*</span></label>
                                        <input type="text" class="form-control solid" name="student_id"
                                            value="{{ $studentData->student_id }}" readonly>
                                        <input type="hidden" name="studentId" value="{{ $studentData->id }}">
                                        <input type="hidden" name="branch_id" value="{{ $studentData->branch_id }}">
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Name<span
                                                class="text-danger scale5
                            ms-2">*</span></label>
                                        <input type="text" class="form-control solid" name="student_name"
                                            value="{{ $studentData->student_firstname .
                                                ' ' .
                                                $studentData->student_othername .
                                                ' ' .
                                                $studentData->student_lastname }}"
                                            readonly>
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Gender<span
                                                class="text-danger scale5
                            ms-2">*</span></label>
                                        <input type="text" class="form-control solid" name="student_gender"
                                            value="{{ $studentData->student_gender }}" readonly>
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Level<span
                                                class="text-danger scale5
                            ms-2">*</span></label>
                                        <input type="text" class="form-control solid" name="student_level"
                                            value="{{ $studentData->level->level_name }}" readonly>
                                        <input type="hidden" name="level_id" value="{{ $studentData->student_level }}">
                                    </div>
                                    <div class="col-xl-4 mb-4">
                                        <label class="form-label font-w600">Residency<span
                                                class="text-danger scale5
                            ms-2">*</span></label>
                                        <input class="form-control solid" name="student_residency" type="text"
                                            value="{{ $studentData->student_residency_type }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <h4 class="text-primary">Term Calendar</h4>
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Term<span
                                                class="text-danger scale5
                            ms-2">*</span></label>
                                        <input class="form-control solid" name="term_name" type="text"
                                            value="{{ $academicYearSession->term_name }}" readonly>
                                        <input type="hidden" name="term_id" value="{{ $academicYearSession->id }}">
                                    </div>
                                    <div class="col-xl-6 mb-4">
                                        <label class="form-label font-w600">Academic Year<span
                                                class="text-danger scale5
                            ms-2">*</span></label>
                                        <input class="form-control solid" name="academic_year_name" type="text"
                                            value="{{ $academicYearSession->academic_year->academic_year_start . '/' . $academicYearSession->academic_year->academic_year_end }}"
                                            readonly>
                                        <input type="hidden" name="academic_year"
                                            value="{{ $academicYearSession->term_academic_year }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <h4 class="text-primary">End of Term Exams Entry</h4>
                                    <div class="col-xl-12 mb-4">
                                        <div class="row" id="Subjects">
                                            @foreach ($studentClassAssessment as $key => $subject)
                                                <div class="col-md-4">
                                                    <label class="form-label font-w600">Subject</label>
                                                    <input type="text" name="end_term[{{ $key }}][subject]"
                                                        class="form-control solid"
                                                        value="{{ $subject->subject->subject_name }}" readonly>
                                                    <input type="hidden" name="end_term[{{ $key }}][subject_id]"
                                                        value="{{ $subject->subject_id }}">
                                                </div>
                                                <div class="col-md-2">
                                                    @php
                                                        $a = $subject->score;
                                                        $b = 25;

                                                        $d = $classPercentage ?? 0;

                                                        $classScore = ($a / $b) * $d;
                                                    @endphp
                                                    <label class="form-label font-w600">Class Score</label>
                                                    <input type="text" name="end_term[{{ $key }}][class_score]"
                                                        class="form-control solid" value="{{ $classScore }}" readonly>
                                                    <label class="form-label font-w600">Exam Score</label>
                                                    <input type="text"
                                                        name="end_term[{{ $key }}][exam_score]"
                                                        class="form-control solid" value="">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <h4 class="text-primary">Other Information</h4>
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Conduct<span
                                                class="text-danger scale5
                        ms-2">*</span></label>
                                        <select class="form-control solid" name="conduct">
                                            <option value="">Choose</option>
                                            <option value="Satisfactory">Satisfactory</option>
                                            <option value="Good">Good</option>
                                            <option value="Very Good">Very Good</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Attitude</label>
                                        <select name="attitude" class="form-control solid">
                                            <option value="">Choose</option>
                                            <option value="Sociable">Sociable</option>
                                            <option value="Respectful">Respectful</option>
                                            <option value="Obedient">Obedient</option>
                                            <option value="Dependable">Dependable</option>
                                            <option value="Lazy">Lazy</option>
                                            <option value="Slow">Slow</option>
                                            <option value="Humble">Humble</option>
                                            <option value="Calm">Calm</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">Interest</label>
                                        <select name="interest" class="form-control solid">
                                            <option value="">Choose</option>
                                            <option value="Reading">Reading</option>
                                            <option value="Sports and Games">Sports and Games</option>
                                            <option value="Music and Dance">Music and Dance</option>
                                            <option value="Art work">Art work</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="I.T">I.T</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-3 mb-4">
                                        <label class="form-label font-w600">General Remarks</label>
                                        <select name="general_remarks" class="form-control solid">
                                            <option value="">Choose</option>
                                            <option value="Could do better">Could do better</option>
                                            <option value="Excellent Performance">Excellent Performance</option>
                                            <option value="Keep it up">Keep it up</option>
                                            <option value="Has improved">Has improved</option>
                                            <option value="Hardworking">Hardworking</option>
                                            <option value="Not serious in class">Not serious in class</option>
                                            <option value="Very promising student">Very promising student</option>
                                            <option value="More room for improvement">More room for improvement</option>
                                            <option value="Declined in performance">Declined in performance</option>
                                            <option value="Should learn seriously to catch up">Should learn seriously to
                                                catch up</option>
                                            <option value="Should Buckle up">Should Buckle up</option>
                                            <option value="More room for improvement">More room for improvement</option>
                                            <option value="Good in Maths">Good in Maths</option>
                                            <option value="Good in Information Technology">Good in Information Technology
                                            </option>
                                            <option value="Good in English Language">Good in English Language</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
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
        @include('custom-functions/admin/ActiveTermInputBasedOnSchoolJS')
        @include('custom-functions/admin/LevelsInSelectInputBasedOnSchoolJS')
    @endpush
    {{-- page datatable script --}}
    @push('datatable')
        @include('admin/dashboard/assessment/end-of-term/StudentsEndTermDataTables')
    @endpush
