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
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="/admin/Subject" id="breadcrumb-header">Subjects</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)" id="breadcrumb-title">Edit</a></li>
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

{{--                            @foreach($data as $Subject)--}}
                                <form action="/Subject/" method="POST" id="update-Subject-form">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-xl-12 mb-4">
                                        <label  class="form-label font-w600">Subject Name<span class="text-danger scale5 ms-2">*</span></label>
                                        <input type="hidden" name="Subject_id" value="">
                                        <input type="text" class="form-control solid" placeholder="Subject Name"
                                               aria-label="name" name="name" value="">
                                        @error('name')
                                        <span class="text-mute text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-xl-6 mb-4">
                                        <label  class="form-label font-w600">Subject<span class="text-danger scale5 ms-2">*</span></label>
                                        <input type="text" class="form-control solid" placeholder="Subject" aria-label="name" name="name" value="{{old('name')}}">
                                        @error('name')
                                            <span class="text-mute text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12 mb-4">
                                        <label  class="form-label font-w600">Description</label>
                                        <textarea class="form-control solid" rows="5" aria-label="With textarea"
                                                  name="description"></textarea>
                                    </div>
                                    <div class="col-xl-12 mb-4">
                                        <label  class="form-label font-w600">Status</label>
                                        <div class="dropdown bootstrap-select default-select form-control wide mb-3">
                                            <select class="default-select form-control wide mb-3" name="is_active">
                                                <option>Choose</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 mb-4">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
{{--                            @endforeach--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
