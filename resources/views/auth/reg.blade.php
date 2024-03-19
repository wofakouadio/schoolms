@extends('layouts.auth-layout')

@push('title')
    <title>Registration</title>
@endpush

@section('content')
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-xl-12 col-xxl-12">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>School Information</h5>
                                                <div class="row">
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="mb-3">
                                                            <label class="text-label form-label">Name*</label>
                                                            <input type="text" name="school-name"
                                                                class="form-control" placeholder="Parsley" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="mb-3">
                                                            <label class="text-label form-label">Location*</label>
                                                            <input type="text" name="school-location"
                                                                class="form-control" placeholder="Montana" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="mb-3">
                                                            <label class="text-label form-label">Email
                                                                Address*</label>
                                                            <input type="email" class="form-control"
                                                                id="inputGroupPrepend2"
                                                                aria-describedby="inputGroupPrepend2"
                                                                placeholder="example@example.com.com" required
                                                                name="school-email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="mb-3">
                                                            <label class="text-label form-label">Phone
                                                                Number*</label>
                                                            <input type="text" name="phoneNumber"
                                                                class="form-control"
                                                                placeholder="(+233)508-657-9007" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mb-3">
                                                        <div class="mb-3">
                                                            <label class="text-label form-label">Logo*</label>
                                                            <input class="form-control" type="file"
                                                                id="formFile" required name="school logo">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h5>Administrator Information</h5>
                                                <div class="row">
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="mb-3">
                                                            <label class="text-label form-label">FirstName*</label>
                                                            <input type="text" name="user-firstName"
                                                                class="form-control" placeholder="Kweku" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="mb-3">
                                                            <label class="text-label form-label">LastName*</label>
                                                            <input type="text" name="user-lastName"
                                                                class="form-control" placeholder="Mensah" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="mb-3">
                                                            <label class="text-label form-label">Email
                                                                Address*</label>
                                                            <input type="email" class="form-control"
                                                                id="emial1" placeholder="example@example.com.com"
                                                                required name="user-email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <div class="mb-3">
                                                            <label class="text-label form-label">Phone
                                                                Number*</label>
                                                            <input type="text" name="user-phoneNumber"
                                                                class="form-control"
                                                                placeholder="(+233)508-657-9007" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mb-2">
                                                        <div class="mb-3">
                                                            <label class="text-label form-label">Password*</label>
                                                            <input type="password" name="user-password"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit">Submit</button>
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
