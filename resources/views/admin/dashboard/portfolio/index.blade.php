@extends('layouts.dash-layout')

@push('title')
    <title>School Portfolio | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        School Portfolio
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
                <div class="alert menu-alert">
                    <ul></ul>
                </div>
                <div class="col-xl-6">
                    <form action="{{route('admin_school_update')}}" method="post" enctype="multipart/form-data"
                          id="school-basic-form">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <h4>School Data</h4>
                            </div>
                            <div class="card-body">
                                <div class="col mb-4 text-center">
                                    @if($schoolData['media']->count() == 0)
                                        <img src="{{asset('storage/school/logo/profile.png')}}" alt="profile.png"
                                             class="rounded">
                                    @else
                                        <img src="{{$schoolData['media'][0]->getUrl()}}" alt="profile
                                        .png"
                                             class="rounded" width="200">
                                    @endif
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <label  class="form-label font-w600">Name<span class="text-danger scale5
                            ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name" name="school_name"
                                               value="{{$schoolData['school_name']}}">
                                    </div>
                                    <div class="col">
                                        <label  class="form-label font-w600">Location</label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                               name="school_location" value="{{$schoolData['school_location']}}">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <label  class="form-label font-w600">Email Address</label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                               name="school_email" value="{{$schoolData['school_email']}}">
                                    </div>
                                    <div class="col">
                                        <label  class="form-label font-w600">Contact</label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                               name="school_contact" value="{{$schoolData['school_phoneNumber']}}">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <label  class="form-label font-w600">Upload new logo</label>
                                        <input type="file" class="form-control solid" aria-label="name"
                                               name="school_logo">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xl-6">
                    <div class="card" style="height: auto">
                        <div class="card-header">
                            <h4>Administrator Data</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4 text-center">
                                @if($adminData['media']->count() == 0)
                                    <img src="{{asset('assets/images/profile/pic1.jpg')}}" alt="profile.png"
                                         class="rounded">
                                @else
                                    <img src="{{$adminData['media'][0]->getUrl()}}" alt="profile
                                            .png"
                                         class="rounded" width="200">
                                @endif
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-6">
                                    <label class="form-label font-w600">Firstname</label>
                                    <input type="text" name="admin_firstname" class="form-control solid"
                                           value="{{$adminData->admin_firstName}}">
                                    <input type="hidden" name="admin_id" value="{{$adminData->id}}">
                                    <input type="hidden" name="school_id" value="{{$adminData->school_id}}">
                                </div>
                                <div class="col-xl-6">
                                    <label class="form-label font-w600">Lastname</label>
                                    <input type="text" name="admin_lastname" class="form-control solid"
                                           value="{{$adminData->admin_lastName}}">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-6">
                                    <label class="form-label font-w600">Email</label>
                                    <input type="text" name="admin_email" class="form-control solid" value="{{$adminData->admin_email}}">
                                </div>
                                <div class="col-xl-6">
                                    <label class="form-label font-w600">Contact</label>
                                    <input type="text" name="admin_contact" class="form-control solid" value="{{$adminData->admin_phoneNumber}}">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-12">
                                    <label class="form-label font-w600">Upload new Profile Picture</label>
                                    <input type="file" name="admin_profile" class="form-control solid">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-xl-12">
                                    <label class="form-label font-w600">Password</label>
                                    <input type="password" name="admin_password" class="form-control solid" value="">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{--Modals--}}
    @push('modals')
        @include('admin/dashboard/portfolio/PortfolioModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('admin/dashboard/portfolio/portfolioJS')
@endpush
{{--page datatable script--}}
@push('datatable')

@endpush
