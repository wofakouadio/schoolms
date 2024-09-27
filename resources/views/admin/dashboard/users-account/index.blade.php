@extends('layouts.dash-layout')

@push('title')
    <title>Users Account Permissions | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Users Account Permissions
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-user-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New User
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="UsersDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @unless($users->isEmpty())
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{$user->teacher->teacher_firstname .' '.
                                                $user->teacher->teacher_lastname}}</td>
                                                <td>{{$user->teacher->teacher_email}}</td>
                                                <td>
                                                    @if($user->status == 1)
                                                        <div class="bootstrap-badge">
                                                            <span class="badge badge-xl light badge-success
                                                            text-uppercase">Can login</span>
                                                        </div>
                                                    @elseif($user->status == 2)
                                                        <div class="bootstrap-badge">
                                                            <span class="badge badge-xl light badge-warning
                                                            text-uppercase">Lock Account</span>
                                                        </div>
                                                    @elseif($user->status == 3)
                                                        <div class="bootstrap-badge">
                                                            <span class="badge badge-xl light badge-danger
                                                            text-uppercase">Disabled Account</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" class="btn btn-primary light sharp" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                    <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                                    <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                                    <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                                </g>
                                                            </svg>
                                                        </button>
                                                        <div class="dropdown-menu" style="">
                                                            <a class="dropdown-item" data-bs-toggle="modal"
                                                               data-bs-target="#edit-user-modal" data-id=>Edit User</a>
                                                            <a class="dropdown-item"  data-bs-toggle="modal"
                                                               data-bs-target="#delete-user-modal" data-id=>Delete User</a>
                                                        </div>
                                                    </div>
                                                </td>
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
    {{--Modals--}}
    @push('modals')
        @include('admin/dashboard/users-account/UsersModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('admin/dashboard/users-account/usersJS')
    @include('custom-functions/admin/TeachersInSelectInputBasedOnSchoolJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/users-account/usersDataTables')
@endpush
