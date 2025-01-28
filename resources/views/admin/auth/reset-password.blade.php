@extends('layouts.auth-layout')

@push('title')
<title>Reset Password | School Mgt System</title>
@endpush

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
                                    <a href=""><img src="images/logo-full.png" alt=""></a>
                                </div>
                                <h4 class="text-center mb-4">Reset Password</h4>
                                <form action="{{ route('admin_reset_password_post') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label><strong>Email</strong></label>
                                        <input type="email" class="form-control" value="{{ $email }}" name="email" readonly>
                                        <input type="hidden" name="token" value="{{ $token }}">
                                    </div>
                                    <div class="mb-3">
                                        <label><strong>New Password</strong></label>
                                        <input type="password" class="form-control" name="new_password">
                                    </div>
                                    <div class="mb-3">
                                        <label><strong>Confirm Password</strong></label>
                                        <input type="password" class="form-control" name="confirm_password">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">SUBMIT</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
