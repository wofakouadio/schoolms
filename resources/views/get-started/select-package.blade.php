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
                                                <p class="mb-0">Welcome to the New World</p>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="text-primary text-uppercase text-center mb-4">Choose your package</h4>

                                    @if(session('school'))
                                        <div class="row justify-content-center">
                                            <div class="col-xl-4 mb-4">
                                                <form action="{{route('school-package-selection')}}" method="POST">
                                                    @csrf
                                                    <input name="school_id" type="hidden" value="{{session('school')}}">
                                                    <div class="product-grid-card">
                                                        <div class="new-arrival-product">
                                                            <div class="new-arrivals-img-contnent">
                                                                <img class="img-fluid" src="{{asset
                                                                ('assets/images/product/1.jpg')}}" alt="">
                                                            </div>
                                                            <div class="new-arrival-content text-center mt-3">
                                                                <h4><a href="">Bonorum et Malorum</a></h4>
                                                                <ul class="star-rating">
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                </ul>
                                                                <del class="discount">$159</del>
                                                                <span class="price">$761.00</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-lg-center mt-4">
                                                            <button class="btn btn-primary" type="submit">
                                                                Select
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-xl-4 mb-4">
                                                <form action="{{route('school-package-selection')}}" method="POST">
                                                    @csrf
                                                    <input name="school_id" type="hidden" value="{{session('school')}}">
                                                    <div class="product-grid-card">
                                                        <div class="new-arrival-product">
                                                            <div class="new-arrivals-img-contnent">
                                                                <img class="img-fluid" src="{{asset
                                                                ('assets/images/product/1.jpg')}}" alt="">
                                                            </div>
                                                            <div class="new-arrival-content text-center mt-3">
                                                                <h4><a href="">Bonorum et Malorum</a></h4>
                                                                <ul class="star-rating">
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                </ul>
                                                                <del class="discount">$159</del>
                                                                <span class="price">$761.00</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-lg-center mt-4">
                                                            <button class="btn btn-primary" type="submit">
                                                                Select
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-xl-4 mb-4">
                                                <form action="{{route('school-package-selection')}}" method="POST">
                                                    @csrf
                                                    <input name="school_id" type="hidden" value="{{session('school')}}">
                                                    <div class="product-grid-card">
                                                        <div class="new-arrival-product">
                                                            <div class="new-arrivals-img-contnent">
                                                                <img class="img-fluid" src="{{asset
                                                                ('assets/images/product/1.jpg')}}" alt="">
                                                            </div>
                                                            <div class="new-arrival-content text-center mt-3">
                                                                <h4><a href="">Bonorum et Malorum</a></h4>
                                                                <ul class="star-rating">
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                    <li><i class="fa fa-star"></i></li>
                                                                </ul>
                                                                <del class="discount">$159</del>
                                                                <span class="price">$761.00</span>
                                                            </div>
                                                        </div>
                                                        <div class="text-lg-center mt-4">
                                                            <button class="btn btn-primary" type="submit">
                                                                Select
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('package-js')
    @include('get-started/onBoardingJS')
@endpush
