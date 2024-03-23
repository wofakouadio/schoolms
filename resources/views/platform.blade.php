@extends('layouts.auth-layout')

@push('title')
    <title>Platform</title>
@endpush

@section('content')
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col">
                    <div class="authincation-content">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h2 class="text-center mb-4">School Management System</h2>
                                    <p class="mb-4 mt-4 text-center">Select the appropriate platform in which your credentials were created for below </p>
                                    <div class="row">
                                        <div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
                                            <div class="widget-stat card bg-primary">
                                                <a href="{{route('admin_login')}}">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <span class="me-3">
                                                                <i class="flaticon-381-home-3"></i>
                                                            </span>
                                                            <div class="media-body text-white text-end">
                                                                <h4 class="mb-1 text-white">Admin</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
                                            <div class="widget-stat card bg-primary">
                                                <a href="">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <span class="me-3">
                                                                <i class="flaticon-381-briefcase"></i>
                                                            </span>
                                                            <div class="media-body text-white text-end">
                                                                <h4 class="mb-1 text-white">Teacher</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
                                            <div class="widget-stat card bg-primary">
                                                <a href="">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <span class="me-3">
                                                                <i class="flaticon-381-user-7"></i>
                                                            </span>
                                                            <div class="media-body text-white text-end">
                                                                <h4 class="mb-1 text-white">Student</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="/" class="btn btn-primary rounded">
                                        <span class="btn-icon-start text-primary">
                                            <i class="flaticon-381-exit-1 text-primary"></i>
                                        </span>
                                        Home
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
