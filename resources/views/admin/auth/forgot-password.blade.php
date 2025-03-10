@extends('layouts.auth-layout')

@push('title')
<title>Forgot Password | School Mgt System</title>
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
                                <h4 class="text-center mb-4">Forgot Password</h4>
                                <form action="{{ route('admin_forgot_password') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label><strong>Email</strong></label>
                                        <input type="email" class="form-control" value="{{ old('admin_email') }}" name="admin_email">
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
