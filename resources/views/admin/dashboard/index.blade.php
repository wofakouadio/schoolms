@extends('layouts/dash-layout')

@push('title')
    <title>Admin Dashboard | SmS</title>
@endpush

@push('page_name')
    <div class="dashboard_bar" id="dash_page_name">
        Admin Dashboard
    </div>
@endpush

@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <x-dash.dash-term :term_name="$schoolTerm['term_name']"
                              :term_academic_year="$schoolTerm['term_academic_year']"/>
            <div class="row">
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row separate-row">
                                        <div class="col-sm-6">
                                            <div class="job-icon pb-4 d-flex justify-content-between">
                                                <div>
                                                    <div class="d-flex align-items-center mb-1">
                                                        <h2 class="mb-0 lh-1">342</h2>
                                                        <span class="text-success ms-3">+0.5 %</span>
                                                    </div>
                                                    <span class="fs-14 d-block mb-2">Interview Schedules</span>
                                                </div>
                                                <div id="NewCustomers"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="job-icon pb-4 pt-4 pt-sm-0 d-flex justify-content-between">
                                                <div>
                                                    <div class="d-flex align-items-center mb-1">
                                                        <h2 class="mb-0 lh-1">984</h2>
                                                    </div>
                                                    <span class="fs-14 d-block mb-2">Application Sent</span>
                                                </div>
                                                <div id="NewCustomers1"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="job-icon pt-4 pb-sm-0 pb-4 pe-3 d-flex justify-content-between">
                                                <div>
                                                    <div class="d-flex align-items-center mb-1">
                                                        <h2 class="mb-0 lh-1">1,567k</h2>
                                                        <span class="text-danger ms-3">-2 % </span>
                                                    </div>
                                                    <span class="fs-14 d-block mb-2">Profile Viewed</span>
                                                </div>
                                                <div id="NewCustomers2"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="job-icon pt-4  d-flex justify-content-between">
                                                <div>
                                                    <div class="d-flex align-items-center mb-1">
                                                        <h2 class="mb-0 lh-1">437</h2>
                                                    </div>
                                                    <span class="fs-14 d-block mb-2">Unread Messages</span>
                                                </div>
                                                <div id="NewCustomers3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="card " id="user-activity">
                                <div class="card-header border-0 pb-0 flex-wrap">
                                    <h4 class="fs-20 mb-0">Vacany Start</h4>
                                    <div class="card-action coin-tabs mt-3 mt-sm-0">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link " data-bs-toggle="tab" href="#Daily"
                                                   role="tab">Daily</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " data-bs-toggle="tab" href="#Daily"
                                                   role="tab">Weekly</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#Daily"
                                                   role="tab">Monthly</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="pb-4 d-flex flex-wrap">
                                        <span class="d-flex align-items-center">
                                            <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="13"
                                                 height="13" viewBox="0 0 13 13">
                                                <rect width="13" height="13" rx="6.5" fill="#35c556" />
                                            </svg>
                                            Application Sent
                                        </span>
                                        <span class="application d-flex align-items-center">
                                            <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="13"
                                                 height="13" viewBox="0 0 13 13">
                                                <rect width="13" height="13" rx="6.5" fill="#3f4cfe" />
                                            </svg>

                                            Interviews
                                        </span>
                                        <span class="application d-flex align-items-center">
                                            <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="13"
                                                 height="13" viewBox="0 0 13 13">
                                                <rect width="13" height="13" rx="6.5" fill="#f34040" />
                                            </svg>

                                            Rejected
                                        </span>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="Daily">
                                            <canvas id="activity" height="115"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="card" id="user-activity1">
                                <div class="card-header border-0 pb-0">
                                    <h4 class="fs-20 mb-0">Chart</h4>
                                    <div class="card-action coin-tabs  mt-0">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link " data-bs-toggle="tab" href="#Daily1"
                                                   role="tab">Daily</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " data-bs-toggle="tab" href="#Daily1"
                                                   role="tab">Weekly</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#Daily1"
                                                   role="tab">Monthly</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <span class="me-sm-5 me-3 font-w500">
                                        <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="13"
                                             height="13" viewBox="0 0 13 13">
                                            <rect width="13" height="13" fill="#f73a0b" />
                                        </svg>
                                        Delivered
                                    </span>
                                    <span class="fs-16 font-w600 me-5">239 <small
                                            class="text-success fs-12 font-w400">+0.4%</small></span>
                                    <span class="ms-sm-5 ms-3 font-w500">
                                        <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="13"
                                             height="13" viewBox="0 0 13 13">
                                            <rect width="13" height="13" fill="#6e6e6e" />
                                        </svg>
                                        Expense
                                    </span>
                                    <span class="fs-16 font-w600">239</span>
                                    <div class="tab-content mt-5" id="myTabContent">
                                        <div class="tab-pane fade show active" id="monthly1">
                                            <canvas id="activity1" class="chartjs"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 pb-0">
                                    <h4 class="fs-20 mb-1">Featured Companies</h4>
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="btn-link" data-bs-toggle="dropdown"
                                           aria-expanded="false">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z"
                                                    stroke="#575757" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z"
                                                    stroke="#575757" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z"
                                                    stroke="#575757" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-3 loadmore-content dlab-scroll height370 " id="scroll-y">
                                    <div class="row " id="FeaturedCompaniesContent">
                                        <div class="col-xl-6 col-sm-6 mt-4 ">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71"
                                                         viewBox="0 0 71 71">
                                                        <g transform="translate(-457 -443)">
                                                            <rect width="71" height="71" rx="12"
                                                                  transform="translate(457 443)" fill="#c5c5c5" />
                                                            <g transform="translate(457 443)">
                                                                <rect data-name="placeholder" width="71"
                                                                      height="71" rx="12" fill="#2769ee" />
                                                                <circle data-name="Ellipse 12" cx="18"
                                                                        cy="18" r="18" transform="translate(15 20)"
                                                                        fill="#fff" />
                                                                <circle data-name="Ellipse 11" cx="11"
                                                                        cy="11" r="11" transform="translate(36 15)"
                                                                        fill="#ffe70c"
                                                                        style="mix-blend-mode: multiply;isolation: isolate" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <div class="ms-3 featured">
                                                    <h4 class="mb-1">Kleon Team</h4>
                                                    <span>Desgin Team Agency</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 mt-4 col-sm-6">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71"
                                                         viewBox="0 0 71 71">
                                                        <g transform="translate(-457 -443)">
                                                            <rect width="71" height="71" rx="12"
                                                                  transform="translate(457 443)" fill="#c5c5c5" />
                                                            <g transform="translate(457 443)">
                                                                <rect data-name="placeholder" width="71"
                                                                      height="71" rx="12" fill="#7630d2" />
                                                                <circle data-name="Ellipse 12" cx="18"
                                                                        cy="18" r="18" transform="translate(15 20)"
                                                                        fill="#fff" />
                                                                <circle data-name="Ellipse 11" cx="11"
                                                                        cy="11" r="11" transform="translate(36 15)"
                                                                        fill="#ffe70c"
                                                                        style="mix-blend-mode: multiply;isolation: isolate" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <div class="ms-3 featured">
                                                    <h4 class="mb-1">Ziro Studios Inc.</h4>
                                                    <span>Desgin Team Agency</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6  col-sm-6 mt-4">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71"
                                                         viewBox="0 0 71 71">
                                                        <g transform="translate(-457 -443)">
                                                            <rect width="71" height="71" rx="12"
                                                                  transform="translate(457 443)" fill="#c5c5c5" />
                                                            <g transform="translate(457 443)">
                                                                <rect data-name="placeholder" width="71"
                                                                      height="71" rx="12" fill="#b848ef" />
                                                                <circle data-name="Ellipse 12" cx="18"
                                                                        cy="18" r="18" transform="translate(15 20)"
                                                                        fill="#fff" />
                                                                <circle data-name="Ellipse 11" cx="11"
                                                                        cy="11" r="11" transform="translate(36 15)"
                                                                        fill="#ffe70c"
                                                                        style="mix-blend-mode: multiply;isolation: isolate" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <div class="ms-3 featured">
                                                    <h4 class="mb-1">Qerza</h4>
                                                    <span>Desgin Team Agency</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-sm-6 mt-4">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71"
                                                         viewBox="0 0 71 71">
                                                        <g transform="translate(-457 -443)">
                                                            <rect width="71" height="71" rx="12"
                                                                  transform="translate(457 443)" fill="#c5c5c5" />
                                                            <g transform="translate(457 443)">
                                                                <rect data-name="placeholder" width="71"
                                                                      height="71" rx="12" fill="#7e1d74" />
                                                                <circle data-name="Ellipse 12" cx="18"
                                                                        cy="18" r="18" transform="translate(15 20)"
                                                                        fill="#fff" />
                                                                <circle data-name="Ellipse 11" cx="11"
                                                                        cy="11" r="11" transform="translate(36 15)"
                                                                        fill="#ffe70c"
                                                                        style="mix-blend-mode: multiply;isolation: isolate" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <div class="ms-3 featured">
                                                    <h4 class="mb-1">Kripton Studios</h4>
                                                    <span>Desgin Team Agency</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-sm-6 mt-4">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71"
                                                         viewBox="0 0 71 71">
                                                        <g transform="translate(-457 -443)">
                                                            <rect width="71" height="71" rx="12"
                                                                  transform="translate(457 443)" fill="#c5c5c5" />
                                                            <g transform="translate(457 443)">
                                                                <rect data-name="placeholder" width="71"
                                                                      height="71" rx="12" fill="#0411c2" />
                                                                <circle data-name="Ellipse 12" cx="18"
                                                                        cy="18" r="18" transform="translate(15 20)"
                                                                        fill="#fff" />
                                                                <circle data-name="Ellipse 11" cx="11"
                                                                        cy="11" r="11" transform="translate(36 15)"
                                                                        fill="#ffe70c"
                                                                        style="mix-blend-mode: multiply;isolation: isolate" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <div class="ms-3 featured">
                                                    <h4 class="mb-1">Omah Ku Inc.</h4>
                                                    <span>Desgin Team Agency</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-sm-6 mt-4">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71"
                                                         viewBox="0 0 71 71">
                                                        <g transform="translate(-457 -443)">
                                                            <rect width="71" height="71" rx="12"
                                                                  transform="translate(457 443)" fill="#c5c5c5" />
                                                            <g transform="translate(457 443)">
                                                                <rect data-name="placeholder" width="71"
                                                                      height="71" rx="12" fill="#378a82" />
                                                                <circle data-name="Ellipse 12" cx="18"
                                                                        cy="18" r="18" transform="translate(15 20)"
                                                                        fill="#fff" />
                                                                <circle data-name="Ellipse 11" cx="11"
                                                                        cy="11" r="11" transform="translate(36 15)"
                                                                        fill="#ffe70c"
                                                                        style="mix-blend-mode: multiply;isolation: isolate" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <div class="ms-3 featured">
                                                    <h4 class="fs-20 mb-1">Ventic</h4>
                                                    <span>Desgin Team Agency</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-sm-6 mt-4">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71"
                                                         viewBox="0 0 71 71">
                                                        <g transform="translate(-457 -443)">
                                                            <rect width="71" height="71" rx="12"
                                                                  transform="translate(457 443)" fill="#c5c5c5" />
                                                            <g transform="translate(457 443)">
                                                                <rect data-name="placeholder" width="71"
                                                                      height="71" rx="12" fill="#175baa" />
                                                                <circle data-name="Ellipse 12" cx="18"
                                                                        cy="18" r="18" transform="translate(15 20)"
                                                                        fill="#fff" />
                                                                <circle data-name="Ellipse 11" cx="11"
                                                                        cy="11" r="11" transform="translate(36 15)"
                                                                        fill="#ffe70c"
                                                                        style="mix-blend-mode: multiply;isolation: isolate" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <div class="ms-3 featured">
                                                    <h4 class="mb-1">Sakola</h4>
                                                    <span>Desgin Team Agency</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-sm-6 mt-4">
                                            <div class="d-flex align-items-center">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71"
                                                         viewBox="0 0 71 71">
                                                        <g transform="translate(-457 -443)">
                                                            <rect width="71" height="71" rx="12"
                                                                  transform="translate(457 443)" fill="#c5c5c5" />
                                                            <g transform="translate(457 443)">
                                                                <rect data-name="placeholder" width="71"
                                                                      height="71" rx="12" fill="#eeb927" />
                                                                <circle data-name="Ellipse 12" cx="18"
                                                                        cy="18" r="18" transform="translate(15 20)"
                                                                        fill="#fff" />
                                                                <circle data-name="Ellipse 11" cx="11"
                                                                        cy="11" r="11" transform="translate(36 15)"
                                                                        fill="#ffe70c"
                                                                        style="mix-blend-mode: multiply;isolation: isolate" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <div class="ms-3 featured">
                                                    <h4 class="mb-1">Uena Foods</h4>
                                                    <span>Desgin Team Agency</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-0 m-auto">
                                    <a href="javascript:void(0);" class="btn btn-outline-primary m-auto dlab-load-more"
                                       id="FeaturedCompanies" rel="ajax/featuredcompanies.html">View more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-xl-8 col-xxl-7 col-sm-7">
                                            <div class="update-profile d-flex">
                                                <img src="images/profile/pic1.jpg" alt="">
                                                <div class="ms-4">
                                                    <h3 class="fs-24 font-w600 mb-0">Franklin Jr</h3>
                                                    <span class="text-primary d-block mb-4">UI / UX Designer</span>
                                                    <span><i class="fas fa-map-marker-alt me-1"></i>Medan, Sumatera Utara -
                                                        ID</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-xxl-5 col-sm-5 sm-mt-auto mt-3 text-sm-end">
                                            <a href="javascript:void(0);" class="btn btn-primary">Update Profile</a>
                                        </div>
                                    </div>
                                    <div class="row mt-4 align-items-center">
                                        <h4 class="fs-20 mb-3">Skills</h4>
                                        <div class="col-xl-6 col-sm-6">
                                            <div class="progress default-progress">
                                                <div class="progress-bar bg-green progress-animated"
                                                     style="width: 90%; height:13px;" role="progressbar">
                                                    <span class="sr-only">90% Complete</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end mt-2 pb-4 justify-content-between">
                                                <span class="fs-14 font-w500">Figma</span>
                                                <span class="fs-16"><span class="text-black pe-2"></span>90%</span>
                                            </div>
                                            <div class="progress default-progress">
                                                <div class="progress-bar bg-info progress-animated"
                                                     style="width: 68%; height:13px;" role="progressbar">
                                                    <span class="sr-only">45% Complete</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end mt-2 pb-4 justify-content-between">
                                                <span class="fs-14 font-w500">Adobe XD</span>
                                                <span class="fs-16"><span class="text-black pe-2"></span>68%</span>
                                            </div>
                                            <div class="progress default-progress">
                                                <div class="progress-bar bg-blue progress-animated"
                                                     style="width: 85%; height:13px;" role="progressbar">
                                                    <span class="sr-only">85% Complete</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end mt-2 pb-4 justify-content-between">
                                                <span class="fs-14 font-w500">Photoshop</span>
                                                <span class="fs-16"><span class="text-black pe-2"></span>85%</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-sm-6">
                                            <div id="pieChart1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 pb-0">
                                    <h4 class="fs-20 mb-0">Recent Activity</h4>
                                    <div>
                                        <select class="default-select dashboard-select">
                                            <option data-display="Newest">Newest</option>
                                            <option value="1">latest</option>

                                            <option value="2">oldest</option>
                                        </select>
                                        <div class="dropdown custom-dropdown mb-0">
                                            <div class="btn sharp tp-btn dark-btn" data-bs-toggle="dropdown">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z"
                                                        stroke="#342E59" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z"
                                                        stroke="#342E59" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z"
                                                        stroke="#342E59" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0);">Details</a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body loadmore-content dlab-scroll height370 recent-activity-wrapper"
                                     id="RecentActivityContent">
                                    <div class="d-flex recent-activity">
                                        <span class="me-3 activity">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                 viewBox="0 0 17 17">
                                                <circle cx="8.5" cy="8.5" r="8.5" fill="#f93a0b" />
                                            </svg>
                                        </span>
                                        <div class="d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71"
                                                 viewBox="0 0 71 71">
                                                <g transform="translate(-457 -443)">
                                                    <rect width="71" height="71" rx="12"
                                                          transform="translate(457 443)" fill="#c5c5c5" />
                                                    <g transform="translate(457 443)">
                                                        <rect data-name="placeholder" width="71" height="71"
                                                              rx="12" fill="#2769ee" />
                                                        <circle data-name="Ellipse 12" cx="18" cy="18"
                                                                r="18" transform="translate(15 20)" fill="#fff" />
                                                        <circle data-name="Ellipse 11" cx="11" cy="11"
                                                                r="11" transform="translate(36 15)" fill="#ffe70c"
                                                                style="mix-blend-mode: multiply;isolation: isolate" />
                                                    </g>
                                                </g>
                                            </svg>
                                            <div class="ms-3">
                                                <h5 class="mb-1">Bubles Studios have 5 available positions for you</h5>
                                                <span>8min ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex recent-activity">
                                        <span class="me-3 activity">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                 viewBox="0 0 17 17">
                                                <circle cx="8.5" cy="8.5" r="8.5" fill="#d9d9d9" />
                                            </svg>
                                        </span>
                                        <div class="d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71"
                                                 viewBox="0 0 71 71">
                                                <g transform="translate(-457 -443)">
                                                    <rect width="71" height="71" rx="12"
                                                          transform="translate(457 443)" fill="#c5c5c5" />
                                                    <g transform="translate(457 443)">
                                                        <rect data-name="placeholder" width="71" height="71"
                                                              rx="12" fill="#eeac27" />
                                                        <circle data-name="Ellipse 12" cx="18" cy="18"
                                                                r="18" transform="translate(15 20)" fill="#fff" />
                                                        <circle data-name="Ellipse 11" cx="11" cy="11"
                                                                r="11" transform="translate(36 15)" fill="#ffe70c"
                                                                style="mix-blend-mode: multiply;isolation: isolate" />
                                                    </g>
                                                </g>
                                            </svg>
                                            <div class="ms-3">
                                                <h5 class="mb-1">Elextra Studios has invited you to interview meeting
                                                    tomorrow</h5>
                                                <span>8min ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex recent-activity">
                                        <span class="me-3 activity">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                 viewBox="0 0 17 17">
                                                <circle cx="8.5" cy="8.5" r="8.5" fill="#d9d9d9" />
                                            </svg>
                                        </span>
                                        <div class="d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71"
                                                 viewBox="0 0 71 71">
                                                <g transform="translate(-457 -443)">
                                                    <rect width="71" height="71" rx="12"
                                                          transform="translate(457 443)" fill="#c5c5c5" />
                                                    <g transform="translate(457 443)">
                                                        <rect data-name="placeholder" width="71" height="71"
                                                              rx="12" fill="#22bc32" />
                                                        <circle data-name="Ellipse 12" cx="18" cy="18"
                                                                r="18" transform="translate(15 20)" fill="#fff" />
                                                        <circle data-name="Ellipse 11" cx="11" cy="11"
                                                                r="11" transform="translate(36 15)" fill="#ffe70c"
                                                                style="mix-blend-mode: multiply;isolation: isolate" />
                                                    </g>
                                                </g>
                                            </svg>
                                            <div class="ms-3">
                                                <h5 class="mb-1">Highspeed Design Team have 2 available positions for you
                                                </h5>
                                                <span>8min ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex recent-activity">
                                        <span class="me-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                 viewBox="0 0 17 17">
                                                <circle cx="8.5" cy="8.5" r="8.5" fill="#d9d9d9" />
                                            </svg>
                                        </span>
                                        <div class="d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71"
                                                 viewBox="0 0 71 71">
                                                <g transform="translate(-457 -443)">
                                                    <rect width="71" height="71" rx="12"
                                                          transform="translate(457 443)" fill="#c5c5c5" />
                                                    <g transform="translate(457 443)">
                                                        <rect data-name="placeholder" width="71" height="71"
                                                              rx="12" fill="#9933cb" />
                                                        <circle data-name="Ellipse 12" cx="18" cy="18"
                                                                r="18" transform="translate(15 20)" fill="#fff" />
                                                        <circle data-name="Ellipse 11" cx="11" cy="11"
                                                                r="11" transform="translate(36 15)" fill="#ffe70c"
                                                                style="mix-blend-mode: multiply;isolation: isolate" />
                                                    </g>
                                                </g>
                                            </svg>
                                            <div class="ms-3">
                                                <h5 class="mb-1">Kleon Studios have 5 available positions for you</h5>
                                                <span>8min ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex recent-activity">
                                        <span class="me-3 activity">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
                                                 viewBox="0 0 17 17">
                                                <circle cx="8.5" cy="8.5" r="8.5" fill="#d9d9d9" />
                                            </svg>
                                        </span>
                                        <div class="d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="71" height="71"
                                                 viewBox="0 0 71 71">
                                                <g transform="translate(-457 -443)">
                                                    <rect width="71" height="71" rx="12"
                                                          transform="translate(457 443)" fill="#c5c5c5" />
                                                    <g transform="translate(457 443)">
                                                        <rect data-name="placeholder" width="71" height="71"
                                                              rx="12" fill="#eeac27" />
                                                        <circle data-name="Ellipse 12" cx="18" cy="18"
                                                                r="18" transform="translate(15 20)" fill="#fff" />
                                                        <circle data-name="Ellipse 11" cx="11" cy="11"
                                                                r="11" transform="translate(36 15)" fill="#ffe70c"
                                                                style="mix-blend-mode: multiply;isolation: isolate" />
                                                    </g>
                                                </g>
                                            </svg>
                                            <div class="ms-3">
                                                <h5 class="mb-1">Elextra Studios has invited you to interview meeting
                                                    tomorrow</h5>
                                                <span>8min ago</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-0 text-center">
                                    <a href="javascript:void(0);" class="btn btn-outline-primary m-auto dlab-load-more"
                                       id="RecentActivity" rel="ajax/recentactivity.html">View more</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header pb-0 border-0 flex-wrap">
                                    <h4 class="fs-20 mb-0 ">Available Jobs For You</h4>
                                    <div>
                                        <select class="default-select dashboard-select">
                                            <option data-display="Newest">Newest</option>

                                            <option value="2">oldest</option>
                                        </select>
                                        <div class="dropdown custom-dropdown mb-0">
                                            <div class="btn sharp tp-btn dark-btn" data-bs-toggle="dropdown">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z"
                                                        stroke="#342E59" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M12 6C12.5523 6 13 5.55228 13 5C13 4.44772 12.5523 4 12 4C11.4477 4 11 4.44772 11 5C11 5.55228 11.4477 6 12 6Z"
                                                        stroke="#342E59" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path
                                                        d="M12 20C12.5523 20 13 19.5523 13 19C13 18.4477 12.5523 18 12 18C11.4477 18 11 18.4477 11 19C11 19.5523 11.4477 20 12 20Z"
                                                        stroke="#342E59" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void(0);">Details</a>
                                                <a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="owl-carousel owl-carousel owl-loaded front-view-slider ">
                                        <div class="items">
                                            <div class="jobs">
                                                <div class="text-center">
                                                    <span>
                                                        <svg class="mb-2" xmlns="http://www.w3.org/2000/svg"
                                                             width="71" height="71" viewBox="0 0 71 71">
                                                            <g transform="translate(-457 -443)">
                                                                <rect width="71" height="71" rx="12"
                                                                      transform="translate(457 443)" fill="#c5c5c5" />
                                                                <g transform="translate(457 443)">
                                                                    <rect data-name="placeholder" width="71"
                                                                          height="71" rx="12" fill="#2769ee" />
                                                                    <circle data-name="Ellipse 12" cx="18"
                                                                            cy="18" r="18" transform="translate(15 20)"
                                                                            fill="#fff" />
                                                                    <circle data-name="Ellipse 11" cx="11"
                                                                            cy="11" r="11" transform="translate(36 15)"
                                                                            fill="#ffe70c"
                                                                            style="mix-blend-mode: multiply;isolation: isolate" />
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <h4 class="mb-0">UI Designer</h4>
                                                    <span class="text-primary mb-3 d-block">Bubbles Studios</span>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block mb-1"><i
                                                            class="fas fa-map-marker-alt me-2"></i>Manchester,
                                                        England</span>
                                                    <span><i class="fas fa-comments-dollar me-2"></i>$ 2,000 - $
                                                        2,500</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="items">
                                            <div class="jobs">
                                                <div class="text-center">
                                                    <span>
                                                        <svg class="mb-2" xmlns="http://www.w3.org/2000/svg"
                                                             width="71" height="71" viewBox="0 0 71 71">
                                                            <g transform="translate(-457 -443)">
                                                                <rect width="71" height="71" rx="12"
                                                                      transform="translate(457 443)" fill="#c5c5c5" />
                                                                <g transform="translate(457 443)">
                                                                    <rect data-name="placeholder" width="71"
                                                                          height="71" rx="12" fill="#ee27c0" />
                                                                    <circle data-name="Ellipse 12" cx="18"
                                                                            cy="18" r="18" transform="translate(15 20)"
                                                                            fill="#fff" />
                                                                    <circle data-name="Ellipse 11" cx="11"
                                                                            cy="11" r="11" transform="translate(36 15)"
                                                                            fill="#ffe70c"
                                                                            style="mix-blend-mode: multiply;isolation: isolate" />
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <h4 class="mb-0">Researcher</h4>
                                                    <span class="text-primary mb-3 d-block">Kleon Studios</span>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block mb-1"><i
                                                            class="fas fa-map-marker-alt me-2"></i>Manchester,
                                                        England</span>
                                                    <span><i class="fas fa-comments-dollar me-2"></i>$ 2,000 - $
                                                        2,500</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="items">
                                            <div class="jobs">
                                                <div class="text-center">
                                                    <span>
                                                        <svg class="mb-2" xmlns="http://www.w3.org/2000/svg"
                                                             width="71" height="71" viewBox="0 0 71 71">
                                                            <g transform="translate(-457 -443)">
                                                                <rect width="71" height="71" rx="12"
                                                                      transform="translate(457 443)" fill="#c5c5c5" />
                                                                <g transform="translate(457 443)">
                                                                    <rect data-name="placeholder" width="71"
                                                                          height="71" rx="12" fill="#2db532" />
                                                                    <circle data-name="Ellipse 12" cx="18"
                                                                            cy="18" r="18" transform="translate(15 20)"
                                                                            fill="#fff" />
                                                                    <circle data-name="Ellipse 11" cx="11"
                                                                            cy="11" r="11" transform="translate(36 15)"
                                                                            fill="#ffe70c"
                                                                            style="mix-blend-mode: multiply;isolation: isolate" />
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <h4 class="mb-0">Frontend</h4>
                                                    <span class="text-primary mb-3 d-block">Green Comp.</span>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block mb-1"><i
                                                            class="fas fa-map-marker-alt me-2"></i>Manchester,
                                                        England</span>
                                                    <span><i class="fas fa-comments-dollar me-2"></i>$ 2,000 - $
                                                        2,500</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="items">
                                            <div class="jobs">
                                                <div class="text-center">
                                                    <span>
                                                        <svg class="mb-2" xmlns="http://www.w3.org/2000/svg"
                                                             width="71" height="71" viewBox="0 0 71 71">
                                                            <g transform="translate(-457 -443)">
                                                                <rect width="71" height="71" rx="12"
                                                                      transform="translate(457 443)" fill="#c5c5c5" />
                                                                <g transform="translate(457 443)">
                                                                    <rect data-name="placeholder" width="71"
                                                                          height="71" rx="12" fill="#2769ee" />
                                                                    <circle data-name="Ellipse 12" cx="18"
                                                                            cy="18" r="18" transform="translate(15 20)"
                                                                            fill="#fff" />
                                                                    <circle data-name="Ellipse 11" cx="11"
                                                                            cy="11" r="11" transform="translate(36 15)"
                                                                            fill="#ffe70c"
                                                                            style="mix-blend-mode: multiply;isolation: isolate" />
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <h4 class="mb-0">UI Designer</h4>
                                                    <span class="text-primary mb-3 d-block">Bubbles Studios</span>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block mb-1"><i
                                                            class="fas fa-map-marker-alt me-2"></i>Manchester,
                                                        England</span>
                                                    <span><i class="fas fa-comments-dollar me-2"></i>$ 2,000 - $
                                                        2,500</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="items">
                                            <div class="jobs">
                                                <div class="text-center">
                                                    <span>
                                                        <svg class="mb-2" xmlns="http://www.w3.org/2000/svg"
                                                             width="71" height="71" viewBox="0 0 71 71">
                                                            <g transform="translate(-457 -443)">
                                                                <rect width="71" height="71" rx="12"
                                                                      transform="translate(457 443)" fill="#c5c5c5" />
                                                                <g transform="translate(457 443)">
                                                                    <rect data-name="placeholder" width="71"
                                                                          height="71" rx="12" fill="#ee27c0" />
                                                                    <circle data-name="Ellipse 12" cx="18"
                                                                            cy="18" r="18" transform="translate(15 20)"
                                                                            fill="#fff" />
                                                                    <circle data-name="Ellipse 11" cx="11"
                                                                            cy="11" r="11" transform="translate(36 15)"
                                                                            fill="#ffe70c"
                                                                            style="mix-blend-mode: multiply;isolation: isolate" />
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <h4 class="mb-0">Researcher</h4>
                                                    <span class="text-primary mb-3 d-block">Kleon Studios</span>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block mb-1"><i
                                                            class="fas fa-map-marker-alt me-2"></i>Manchester,
                                                        England</span>
                                                    <span><i class="fas fa-comments-dollar me-2"></i>$ 2,000 - $
                                                        2,500</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="items">
                                            <div class="jobs">
                                                <div class="text-center">
                                                    <span>
                                                        <svg class="mb-2" xmlns="http://www.w3.org/2000/svg"
                                                             width="71" height="71" viewBox="0 0 71 71">
                                                            <g transform="translate(-457 -443)">
                                                                <rect width="71" height="71" rx="12"
                                                                      transform="translate(457 443)" fill="#c5c5c5" />
                                                                <g transform="translate(457 443)">
                                                                    <rect data-name="placeholder" width="71"
                                                                          height="71" rx="12" fill="#2db532" />
                                                                    <circle data-name="Ellipse 12" cx="18"
                                                                            cy="18" r="18" transform="translate(15 20)"
                                                                            fill="#fff" />
                                                                    <circle data-name="Ellipse 11" cx="11"
                                                                            cy="11" r="11" transform="translate(36 15)"
                                                                            fill="#ffe70c"
                                                                            style="mix-blend-mode: multiply;isolation: isolate" />
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                    <h4 class="mb-0">Frontend</h4>
                                                    <span class="text-primary mb-3 d-block">Green Comp.</span>
                                                </div>
                                                <div class="text-center">
                                                    <span class="d-block mb-1"><i
                                                            class="fas fa-map-marker-alt me-2"></i>Manchester,
                                                        England</span>
                                                    <span><i class="fas fa-comments-dollar me-2"></i>$ 2,000 - $
                                                        2,500</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


