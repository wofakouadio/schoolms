@extends('layouts.auth-layout')

@push('title')
    <title>Package Selection</title>
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
                                    @if (session('message'))
                                        <div class="alert alert-success left-icon-big alert-dismissible fade show">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="btn-close"><span><i class="mdi mdi-btn-close"></i></span>
                                            </button>
                                            <div class="media">
                                                <div class="alert-left-icon-big">
                                                    <span><i class="mdi mdi-check-circle-outline"></i></span>
                                                </div>
                                                <div class="media-body">
                                                    <h5 class="mt-1 mb-2">Congratulations!</h5>
                                                    <p class="mb-0">{{ session('message') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="alert alert-success">

                                        </div> --}}
                                    @endif
                                    <form action="/new-account" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <h4 class="text-primary text-uppercase text-center mb-4">Choose your package</h4>



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
