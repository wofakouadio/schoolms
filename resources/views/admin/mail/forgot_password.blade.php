@extends('layouts.auth-layout')

@section('content')

    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href=""><img src="{{ asset('images/logo-full.png') }}" alt=""></a>
                                    </div>
                                    <h4 class="text-center mb-4">Forgot Subject</h4>
                                    <p>Click on the button below to reset your password.</p>
                                    <a href="{{ route('admin_reset_password_get', [$token, $email]) }}" class="btn btn-primary text-center btn-block">Click to reset your password</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
