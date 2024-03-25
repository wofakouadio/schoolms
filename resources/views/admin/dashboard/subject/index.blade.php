@extends('layouts.dash-layout')

@push('title')
    <title>Subjects | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Subjects
    </div>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            {{-- <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)" id="breadcrumb-header">Form</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)" id="breadcrumb-title">Element</a></li>
                </ol>
            </div> --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-subject-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Subject
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="SubjectsDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
{{--                                    @foreach($SubjectsDataTableView as $subject)--}}
{{--                                        <tr>--}}
{{--                                            <td>{{$subject->name}}</td>--}}
{{--                                            <td>--}}
{{--                                                @if($subject->is_active === 0)--}}
{{--                                                    <span class="badge badge-xl light badge-success text-uppercase">active</span>--}}
{{--                                                @else--}}
{{--                                                    <span class="badge badge-xl light badge-danger text-uppercase">disabled</span>--}}
{{--                                                @endif--}}
{{--                                            </td>--}}
{{--                                            <td>--}}
{{--                                                <div class="d-flex">--}}
{{--                                                    <a href="/admin/subject/{{$subject->id}}/edit" class="btn--}}
{{--                                                    btn-primary shadow--}}
{{--                                                    btn-xs--}}
{{--                                                    sharp--}}
{{--                                                    me-1"><i--}}
{{--                                                            class="fas fa-pencil-alt"></i></a>--}}
{{--                                                    <a href="/admin/subject/{{$subject->id}}" class="btn--}}
{{--                                                    btn-danger shadow btn-xs--}}
{{--                                                    sharp"><i class="fa fa-trash"></i></a>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
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
        @include('admin/dashboard/subject/subjectsJS')
    @endpush
    {{--page datatable script--}}
    @push('datatable')
        @include('admin/dashboard/subject/subjectsDataTables')
    @endpush
