@extends('layouts.dash-layout')

@push('title')
    <title>Teacher Profile | School Mgt Sys</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Teacher Profile
    </div>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            @if($schoolTerm == null)
                <x-dash.dash-no-term/>
            @else
                <x-dash.dash-term :term_name="$schoolTerm['term_name']"
                                  :academic_year_start="$schoolTerm['academic_year']['academic_year_start']"
                                  :academic_year_end="$schoolTerm['academic_year']['academic_year_end']"/>
            @endif
            <div class="row">
                <div class="alert menu-alert">
                    <ul></ul>
                </div>
                <div class="col-xl-12">
                    <div class="profile-back">
                        <img src="{{asset('assets/images/background/bg6.jpg')}}" alt="">
{{--                        <div class="social-btn">--}}
{{--                            <a href="javascript:void(0);" class="btn btn-light social">245 Following</a>--}}
{{--                            <a href="javascript:void(0);" class="btn btn-light social">872 Followers</a>--}}
{{--                            <a href="javascript:void(0);" class="btn btn-primary">Update Profile</a>--}}
{{--                        </div>--}}
                    </div>
                    <div class="profile-pic d-flex">
                        @if($teacherData['media']->count() == 0)
                            <img src="{{asset('assets/images/profile/pic1.jpg')}}" alt="">
                        @else
                            <img src="{{$teacherData['media'][0]->getUrl()}}" alt="">
                        @endif
                        <div class="profile-info2">
                            <h2 class="mb-0">{{$teacherData->teacher_firstname . ' ' .
                            $teacherData->teacher_lastname}}</h2>
                            <h4>Teacher</h4>
                            <span class="d-block"><i class="fas fa-map-marker-alt
                            me-2"></i>{{$teacherData->teacher_address}}</span>
                        </div>
                    </div>
                </div>
                <div class="card">
{{--                    <div class="card-header border-0 flex-wrap align-items-start">--}}
{{--                        <div class="col-md-8">--}}
{{--                            <div class="user d-sm-flex d-block pe-md-5 pe-0">--}}
{{--                                <img src="images/user.jpg" alt="">--}}
{{--                                <div class="ms-sm-3 ms-0 me-md-5 md-0">--}}
{{--                                    <h5 class="mb-1 font-w600"><a href="javascript:void(0);" class="text-black">Andrew Jonson</a></h5>--}}
{{--                                    <div class="listline-wrapper mb-2">--}}
{{--                                        <span class="item"><i class="text-primary far fa-envelope"></i>example@gmail.com</span>--}}
{{--                                        <span class="item"><i class="text-primary far fa-id-badge"></i>Manager</span>--}}
{{--                                        <span class="item"><i class="text-primary fas fa-map-marker-alt"></i>Indonesia</span>--}}
{{--                                    </div>--}}
{{--                                    <p>A data analyst collects, interprets and visualizes data to uncover insights. A data analyst assigns a numerical value to business functions so performance.</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4 col-12 text-end">--}}
{{--                            <a href="javascript:void(0);" class="btn btn-sm btn-primary me-2">Ask</a>--}}
{{--                            <a href="javascript:void(0);" class="btn btn-sm btn-info">Hire</a>--}}
{{--                            <div class="mt-3">--}}
{{--                                <h6 class="text-start">Progress--}}
{{--                                    <span class="float-end">85%</span>--}}
{{--                                </h6>--}}
{{--                                <div class="progress ">--}}
{{--                                    <div class="progress-bar bg-danger progress-animated" style="width: 85%; height:6px;" role="progressbar">--}}
{{--                                        <span class="sr-only">60% Complete</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="card-body pt-0">
                        <h4 class="fs-20">Description</h4>
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Full Name :
                                    </span><span class="font-w400">{{$teacherData->teacher_firstname . ' '
                                    .$teacherData->teacher_othername.' ' .
                                    $teacherData->teacher_lastname}}</span></p>
                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Date of Birth :
                                    </span><span
                                        class="font-w400">{{date('F j Y', strtotime($teacherData->teacher_dob))
                                        }}</span></p>
                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Place of Birth :
                                    </span><span class="font-w400">{{$teacherData->teacher_pob}}</span></p>
                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Nationality :
                                    </span><span class="font-w400">{{$teacherData->teacher_nationality}}</span></p>
                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Address : </span><span
                                        class="font-w400">{{$teacherData->teacher_address}}</span></p>
                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Email : </span><span
                                        class="font-w400">{{$teacherData->teacher_email}}</span></p>
{{--                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Location :</span> <span class="font-w400">USA</span></p>--}}
{{--                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Preferred Location : </span><span class="font-w400">USA</span></p>--}}
{{--                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Qualification: </span><span class="font-w400">B.Tech(CSE)</span></p>--}}
{{--                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Key Skills: </span><span class="font-w400">Good Communication, Planning and research skills</span></p>--}}
                            </div>
{{--                            <div class="col-xl-6 col-md-6">--}}
{{--                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Launguages :</span> <span class="font-w400">English, German, Spanish</span></p>--}}
{{--                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Email :</span> <span class="font-w400">andrew@gmail.com</span></p>--}}
{{--                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Phone : </span><span class="font-w400">1234598765</span></p>--}}
{{--                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Industry :</span> <span class="font-w400">it Software/ Developer</span></p>--}}
{{--                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Date Of Birth : </span><span class="font-w400">13 June 1996</span></p>--}}
{{--                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Gender : </span><span class="font-w400">Female</span></p>--}}
{{--                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Marital Status : </span><span class="font-w400">Unmarried</span></p>--}}
{{--                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Permanent Address :</span> <span class="font-w400">USA</span></p>--}}
{{--                                <p class="font-w600 mb-2 d-flex"><span class="custom-label-2">Zip code: </span><span class="font-w400">12345</span></p>--}}
{{--                            </div>--}}
                        </div>
                    </div>
{{--                    <div class="card-footer d-flex flex-wrap justify-content-between align-items-center">--}}
{{--                        <div class="mb-md-2 mb-3 exp-del">--}}
{{--                            <span class="d-block mb-1"><i class="fas fa-circle me-2"></i>Currently Working at  <strong>Abcd Pvt Ltd</strong></span>--}}
{{--                            <span><i class="fas fa-circle me-2"></i>3 Yrs Of Working Experience in   <strong>Abcd Pvt Ltd</strong></span>--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <a href="javascript:void(0);" class="btn btn-primary btn-sm me-2"><i class="fas fa-download me-2"></i>Download Ruseme</a>--}}
{{--                            <a href="javascript:void(0);" class="btn btn-warning btn-sm me-2"><i class="fas fa-share-alt me-2"></i>Share Profile</a>--}}
{{--                            <a href="javascript:void(0);" class="btn btn-info btn-sm me-2"><i class="fas fa-phone-alt me-2"></i>Contact</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
{{--                <div class="col-xl-3 col-xxl-4 col-lg-6 mt-5">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-xl-12">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-header border-0">--}}
{{--                                    <h4 class="fs-20">Skills</h4>--}}
{{--                                </div>--}}
{{--                                <div class="card-body pt-0">--}}
{{--                                    <div id="pieChart2" class="mb-4"></div>--}}
{{--                                    <div class="progress default-progress">--}}
{{--                                        <div class="progress-bar bg-green progress-animated" style="width: 90%; height:13px;" role="progressbar">--}}
{{--                                            <span class="sr-only">90% Complete</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="d-flex align-items-end mt-2 pb-4 justify-content-between">--}}
{{--                                        <span class="fs-14 font-w500">Figma</span>--}}
{{--                                        <span class="fs-16"><span class="text-black pe-2"></span>90%</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="progress default-progress">--}}
{{--                                        <div class="progress-bar bg-info progress-animated" style="width: 68%; height:13px;" role="progressbar">--}}
{{--                                            <span class="sr-only">45% Complete</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="d-flex align-items-end mt-2 pb-4 justify-content-between">--}}
{{--                                        <span class="fs-14 font-w500">Adobe XD</span>--}}
{{--                                        <span class="fs-16"><span class="text-black pe-2"></span>68%</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="progress default-progress">--}}
{{--                                        <div class="progress-bar bg-blue progress-animated" style="width: 85%; height:13px;" role="progressbar">--}}
{{--                                            <span class="sr-only">85% Complete</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="d-flex align-items-end mt-2 pb-4 justify-content-between">--}}
{{--                                        <span class="fs-14 font-w500">Photoshop</span>--}}
{{--                                        <span class="fs-16"><span class="text-black pe-2"></span>85%</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-xl-9 col-xxl-8 col-lg-6 mt-lg-5 mt-0">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-xl-8 col-xxl-7">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-header border-0 pb-0">--}}
{{--                                    <h4 class="fs-20 mb-0">About Me</h4>--}}
{{--                                </div>--}}
{{--                                <div class="card-body pt-2">--}}
{{--                                    <p class="fs-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>--}}
{{--                                    <h4 class="fs-20  my-4">Contact</h4>--}}
{{--                                    <div class="d-flex flex-wrap">--}}
{{--                                        <div class="d-flex contacts-social align-items-center mb-3  me-sm-5 me-0">--}}
{{--												<span class="me-3">--}}
{{--													<i class="fas fa-phone-alt"></i>--}}
{{--												</span>--}}
{{--                                            <div>--}}
{{--                                                <span>Phone</span>--}}
{{--                                                <h5 class="mb-0 fs-18">1234598765</h5>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="d-flex contacts-social align-items-center mb-3">--}}
{{--												<span class="me-3">--}}
{{--													<i class="fas fa-envelope-open"></i>--}}
{{--												</span>--}}
{{--                                            <div>--}}
{{--                                                <span>Email</span>--}}
{{--                                                <h5 class="mb-0 fs-18">demo@example.com</h5>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-xl-4 col-xxl-5">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-header border-0 pb-0">--}}
{{--                                    <h4 class="fs-20">Socials</h4>--}}
{{--                                </div>--}}
{{--                                <div class="card-body pt-2">--}}
{{--                                    <div>--}}
{{--                                        <a href="javascript:void(0);" class="btn text-start d-block mb-3 bg-facebook light"><i class="fab fa-facebook-f scale5  text-facebook"></i>/franklin.jr123</a>--}}
{{--                                        <a href="javascript:void(0);" class="btn text-start d-block mb-3 bg-linkedin light"><i class="fab fa-linkedin-in scale5 text-linkedin"></i>/franklin.jr123</a>--}}
{{--                                        <a href="javascript:void(0);" class="btn text-start d-block mb-3 bg-dribble light"><i class="fab fa-dribbble scale5 text-dribble"></i>/franklin.jr123</a>--}}
{{--                                        <a href="javascript:void(0);" class="btn text-start d-block mb-3 bg-youtube light"><i class="fab fa-youtube scale5 text-youtube"></i>--}}
{{--                                            /franklin.jr123</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-xl-12">--}}
{{--                            <div class="card bg-dark">--}}
{{--                                <div class="card-body d-flex align-items-center">--}}
{{--                                    <div>--}}
{{--                                        <h4 class="fs-20 mb-2 text-white">Upload your curriculum vitae</h4>--}}
{{--                                        <p class="text-white mb-0 op6">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut</p>--}}
{{--                                    </div>--}}
{{--                                    <div class="upload">--}}
{{--                                        <a href="javascript:void(0);"><i class="fas fa-arrow-up"></i></a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

            </div>
        </div>
    {{--Modals--}}
    @push('modals')
        @include('teacher/dashboard/profile/PortfolioModals')
    @endpush
@endsection
{{--page js script--}}
@push('page-js')
    @include('teacher/dashboard/profile/portfolioJS')
@endpush
{{--page datatable script--}}
@push('datatable')
    @include('teacher/dashboard/profile/termsDataTables')
@endpush
