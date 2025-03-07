@extends('layouts.dash-layout')

@push('title')
    <title>Levels | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Levels
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
                <div class="col-2">
                    <div class="card" style="height: auto">
                        <div class="card-body">
                            {{-- <div class="form-group mt-3">
                                <h5>{{ count($teacherLevels) }} Levels/Classes Taught</h5>
                                <ol class="item-list">
                                    @foreach ($teacherLevels as $teacherLevel)
                                        <li>{{ $teacherLevel->level->level_name }}</li>
                                    @endforeach
                                </ol>
                            </div> --}}
                            <form method="get" action="" id="teacher_level_students_form">
                                @csrf
                                <div class="form-group mt-3">
                                    <h5>{{ count($subjectsTaught) }} Subjects Taught</h5>
                                    <ol class="item-list">
                                        @foreach ($subjectsTaught as $subject)
                                            <li>{{ $subject->subject->subject_name }}</li>
                                        @endforeach
                                    </ol>
                                </div>
                                <div class="form-group">
                                    <label>Levels/Classes Taught</label>
                                   {{-- {{dd($teacherLevels)}} --}}
                                    <select class="form-control" name="teacher_level" id="teacher_level">
                                        <option>Choose</option>
                                        @foreach($teacherLevels as $teacherLevel)
                                            <option
                                                value="{{$teacherLevel->level_id}}">{{$teacherLevel->level->level_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn btn-primary mt-2 btn-xl" type="submit">View Students</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-10">
                    <div class="card" style="height: auto">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="TeacherLevelsDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
{{--                                        <th>Profile</th>--}}
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Level/Class</th>
                                        <th>Residency</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   {{-- {{dd($teacherStudents)}} --}}
{{--                                    @if(is_array($teacherStudents) || is_object($teacherStudents))--}}
{{--                                        @unless($teacherStudents->isEmpty())--}}
                                            {{-- @foreach($teacherStudents as $teacherStudent)
                                                <tr>
                                                    <td>{{$teacherStudent['student_id']}}</td>
                                                    <td>{{$teacherStudent['student_firstname'].' '
                                                    .$teacherStudent['student_lastname']}}</td>
                                                    <td>{{$teacherStudent['student_gender']}}</td>
                                                    <td>{{$teacherStudent['level']['level_name']}}</td>
                                                    <td>{{$teacherStudent['student_residency_type']}}</td>
                                                    <td>
                                                        <button class="btn btn-primary light" data-bs-toggle="modal"
                                                                data-bs-target="" data-student_id="{{$teacherStudent['student_id']}}">
                                                            View
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach --}}
{{--                                        @endunless--}}
{{--                                    @endif--}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{--Modals--}}
    @push('modals')
        @include('teacher/dashboard/level/LevelsModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('teacher/dashboard/level/levelsJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('teacher/dashboard/level/levelsDataTables')
@endpush
