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
                                  :term_academic_year="$schoolTerm['term_academic_year']"/>
            @endif
            <div class="row">
                <div class="alert menu-alert">
                    <ul></ul>
                </div>
                <div class="col-xl-4">
                    <form action="{{route('admin_school_update')}}" method="post" enctype="multipart/form-data"
                          id="school-basic-form">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <h4>Basic Data</h4>
                            </div>
                            <div class="card-body">
{{--                                {{dd($schoolData['media'])}}--}}
{{--                                @foreach($schoolData as $data)--}}
                                    <div class="col mb-4 text-center">
                                        @if($schoolData['media']->count() == 0)
{{--                                        @if(empty($schoolData['media']['school_logo']) ?? $schoolData['school_logo'] ===--}}
{{--                                        'profile.png' ?? null)--}}
{{--                                        @if($data->school_logo === null ?? 'profile.png')--}}
                                            <img src="{{asset('storage/school/logo/profile.png')}}" alt="profile.png"
                                                 class="rounded">
                                        @else
{{--                                            <img src="{{asset('storage/'.$data->school_logo)}}" alt="profile.png"--}}
{{--                                                 class="rounded" width="60">--}}
                                            <img src="{{$schoolData['media'][0]->getUrl()}}" alt="profile
                                            .png"
                                                 class="rounded" width="200">
                                        @endif
                                    </div>
                                    <div class="col mb-4">
                                        <label  class="form-label font-w600">Name<span class="text-danger scale5
                            ms-2">*</span></label>
                                        <input type="text" class="form-control solid" aria-label="name" name="school_name"
                                               value="{{$schoolData['school_name']}}">
                                    </div>
                                    <div class="col mb-4">
                                        <label  class="form-label font-w600">Location</label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                               name="school_location" value="{{$schoolData['school_location']}}">
                                    </div>
                                    <div class="col mb-4">
                                        <label  class="form-label font-w600">Email Address</label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                               name="school_email" value="{{$schoolData['school_email']}}">
                                    </div>
                                    <div class="col mb-4">
                                        <label  class="form-label font-w600">Contact</label>
                                        <input type="text" class="form-control solid" aria-label="name"
                                               name="school_contact" value="{{$schoolData['school_phoneNumber']}}">
                                    </div>
                                    <div class="col mb-4">
                                        <label  class="form-label font-w600">Upload new logo</label>
                                        <input type="file" class="form-control solid" aria-label="name"
                                               name="school_logo">
                                    </div>
{{--                                @endforeach--}}
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-rounded btn-primary" data-bs-toggle="modal"
                               data-bs-target="#new-term-modal">
                                <span class="btn-icon-start text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span> New Term
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="TermsDataTables" class="display" style="min-width: 845px">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Opening</th>
                                        <th>Closing</th>
                                        <th>Academic Year</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
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
        @include('admin/dashboard/portfolio/PortfolioModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('admin/dashboard/portfolio/portfolioJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('admin/dashboard/portfolio/termsDataTables')
@endpush
