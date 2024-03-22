@extends('layouts.dash-layout')

@push('title')
    <title>Departments | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Departments
    </div>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="/admin/department" id="breadcrumb-header">Departments</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)" id="breadcrumb-title">New</a></li>
                </ol>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session('message'))
                                <div class="col-xl-12">
                                    <div class="alert alert-success left-icon-big alert-dismissible fade show">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
                                        </button>
                                        <div class="media">
                                            <div class="alert-left-icon-big">
                                                <span><i class="mdi mdi-check-circle-outline"></i></span>
                                            </div>
                                            <div class="media-body">
                                                <h5 class="mt-1 mb-2">Congratulations!</h5>
                                                <p class="mb-0">{{session('message')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <form action="/department/store" method="POST" id="new-department-form">
                                @csrf
                                <div class="col-xl-12 mb-4">
                                    <label  class="form-label font-w600">Name<span class="text-danger scale5 ms-2">*</span></label>
                                    <input type="text" class="form-control solid" placeholder="Name" aria-label="name" name="name" value="{{old('name')}}">
                                    @error('name')
                                        <span class="text-mute text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-xl-12 mb-4">
                                    <label  class="form-label font-w600">Description</label>
                                    <textarea class="form-control solid" rows="5" aria-label="With textarea" name="description">{{old('description')}}</textarea>
                                </div>
                                <div class="col-xl-12 mb-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
