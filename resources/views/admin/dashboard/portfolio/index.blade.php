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
            {{-- <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)" id="breadcrumb-header">Form</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)" id="breadcrumb-title">Element</a></li>
                </ol>
            </div> --}}
            <form action="{{route('admin_school_update')}}" method="post" enctype="multipart/form-data"
                  id="school-basic-form">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="alert menu-alert">
                        <ul></ul>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Basic Data</h4>
                            </div>
                            <div class="card-body">
                                @foreach($schoolData as $data)
                                    <div class="col mb-4 text-center">
                                        @if($data->school_logo === null ?? 'profile.png')
                                            <img src="{{asset('storage/school/logo/profile.png')}}" alt="profile.png"
                                                 class="rounded">
                                            @else
                                            <img src="{{asset('storage/'.$data->school_logo)}}" alt="profile.png"
                                                 class="rounded" width="60">
                                        @endif
                                    </div>
                                    <div class="col mb-4">
                                        <label  class="form-label font-w600">Name<span class="text-danger scale5
                            ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name" name="school_name"
                                               value="{{$data->school_name}}">
                                    </div>
                                    <div class="col mb-4">
                                        <label  class="form-label font-w600">Location</label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                               name="school_location" value="{{$data->school_location}}">
                                    </div>
                                    <div class="col mb-4">
                                        <label  class="form-label font-w600">Email Address</label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                               name="school_email" value="{{$data->school_email}}">
                                    </div>
                                    <div class="col mb-4">
                                        <label  class="form-label font-w600">Contact</label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                               name="school_contact" value="{{$data->school_phoneNumber}}">
                                    </div>
                                    <div class="col mb-4">
                                        <label  class="form-label font-w600">Upload new logo</label>
                                        <input type="file" class="form-control solid" aria-label="name"
                                               name="school_logo">
                                        <input type="hidden" name="school_fetched_logo" value="{{$data->school_logo}}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
{{--    @include('admin/dashboard/portfolio/teachersDataTables')--}}
@endpush
