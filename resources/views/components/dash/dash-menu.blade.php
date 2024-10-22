<div class="dlabnav">
    <div class="dlabnav-scroll">
        <x-dash.dash-user-info/>
        @if(Auth::guard('admin')->check())
            <ul class="metismenu" id="menu">
                <li>
                    <a href="{{route('admin_dashboard')}}">
                        <i class="flaticon-025-dashboard"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin_school_branch')}}">
                        <i class="flaticon-381-funnel"></i>
                        <span class="nav-text">Branch</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin_school_level')}}">
                        <i class="flaticon-381-hourglass-2"></i>
                        <span class="nav-text">Level</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin_school_house')}}">
                        <i class="flaticon-381-home-3"></i>
                        <span class="nav-text">House</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin_school_category')}}">
                        <i class="flaticon-381-knob-1"></i>
                        <span class="nav-text">Category</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin_department')}}">
                        <i class="flaticon-381-album"></i>
                        <span class="nav-text">Department</span></a>
                </li>
                <li>
                    <a href="{{route('admin_school_subject')}}">
                        <i class="flaticon-381-book"></i>
                        <span class="nav-text">Subject</span>
                    </a>
                </li>
                <li>
                    <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-user-9"></i>
                        <span class="nav-text">Teacher</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin_teacher')}}">List</a></li>
                        <li><a href="{{route('assign-levels-to-teacher')}}">Assign Class/Level to Teacher</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-school"></i>
                        <span class="nav-text">Student</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin_student_admission')}}">Admissions</a></li>
                        <li><a href="{{route('admin_student')}}">Students List</a></li>
                        <li><a href="#">Activity Log</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-bank"></i>
                        <span class="nav-text">Finance</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin_finance')}}">Dashboard</a></li>
                        <li><a href="{{route('admin_term_bill')}}">Term Billings</a></li>
                        <li><a href="{{route('admin_finance_admission_fee')}}">Admission Fees</a></li>
                        <li><a href="{{ route('admin_student_bill') }}">Student Billing</a></li>
                        <li><a href="{{route('admin_finance_fee_collection')}}">Fee Collection</a></li>
                        <li><a href="{{ route('admin_student_transactions') }}">Student Fee Collection</a></li>
                        <li><a href="{{ route('admin_finance_report') }}">Financial Report</a></li>
                        {{-- <li><a href="{{route('admin_expenditure')}}">Expenditure</a></li> --}}
                        {{-- <li><a href="#">Activity Log</a></li> --}}
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-album-3"></i>
                        <span class="nav-text">Assessment</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin_assessment_settings')}}">Settings</a></li>
                        <li><a href="{{route('admin_student_attendance')}}">Attendance</a></li>
                        <li>
                            <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                                <span class="nav-text">Mock</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{route('admin_student_mock')}}">Setup</a></li>
                                <li><a href="{{route('admin_student_mock_examination')}}">Examination</a></li>
                            </ul>
                        </li>
                        <li><a href="{{route('admin_assessment_level')}}">Level Assessment</a></li>
                        <li><a href="{{route('admin_student_mid_term')}}">Mid-Term Exams</a></li>
                        <li><a href="{{route('admin_student_end_term')}}">End of Term Exams</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-folder-19"></i>
                        <span class="nav-text">Report</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin_student_attendance_report')}}">Attendance</a></li>
                        <li><a href="{{route('admin_student_mock_report')}}">Mock</a></li>
                        <li><a href="{{route('admin_student_mid_term_report')}}">Mid-Term</a></li>
                        <li><a href="{{route('admin_student_end_term_report')}}">End of Term Exams</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-settings-5"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin_school')}}">Profile</a></li>
                        <li><a href="{{route('admin_academic_year')}}">Academic-Year</a></li>
                        <li><a href="{{route('admin_school_term')}}">Term</a></li>
                        <li><a href="{{route('admin_class_assessment_size')}}">Class Assessment Size</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="javascript:void()" aria-expanded="false">

                        <i class="flaticon-381-user-4"></i>
                        <span class="nav-text">Users</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('admin_user_account_permission')}}">View Users</a></li>
                    </ul>
                </li>
            </ul>
        @elseif(Auth::guard('teacher')->check())
            <ul class="metismenu" id="menu">
                <li>
                    <a href="{{route('teacher_dashboard')}}">
                        <i class="flaticon-025-dashboard"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-settings-5"></i>
                        <span class="nav-text">Profile</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{route('teacher_profile')}}">View</a></li>
{{--                        <li><a href="{{route('admin_school_branch')}}">Branches</a></li>--}}
{{--                        <li><a href="{{route('admin_school_level')}}">Levels</a></li>--}}
{{--                        <li><a href="{{route('admin_school_house')}}">Houses</a></li>--}}
{{--                        <li><a href="{{route('admin_school_category')}}">Categories</a></li>--}}
                    </ul>
                </li>
                <li>
                    <a href="{{route('teacher_levels')}}">
                        <i class="flaticon-381-user-5"></i>
                        <span class="nav-text">My Levels/Classes</span>
                    </a>
                </li>
                <li>
                    <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-album-3"></i>
                        <span class="nav-text">Assessment</span>
                    </a>
                    <ul aria-expanded="false">
{{--                        <li><a href="{{route('admin_student_attendance')}}">Attendance</a></li>--}}
                        <li><a href="{{route('teacher_mock_assessment')}}">Mock</a></li>
                        <li><a href="{{route('teacher_level_assessment')}}">Level/Class</a></li>
                        <li><a href="{{route('teacher_mid_term_assessment')}}">Mid-Term</a></li>
                        <li><a href="{{route('teacher_end_term_assessment')}}">End of Term</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-folder-19"></i>
                        <span class="nav-text">Reports</span>
                    </a>
                    <ul aria-expanded="false">
{{--                        <li><a href="{{route('admin_student_attendance_report')}}">Attendance</a></li>--}}
                        <li><a href="{{route('teacher_mock_report')}}">Mock</a></li>
                        <li><a href="{{route('teacher_mid_term_report')}}">Mid-Term</a></li>
                        <li><a href="{{route('teacher_end_of_term_report')}}">End of Term</a></li>
                    </ul>
                </li>
{{--                <li>--}}
{{--                    <a class="has-arrow " href="javascript:void()" aria-expanded="false">--}}
{{--                        <i class="flaticon-381-settings-5"></i>--}}
{{--                        <span class="nav-text">Portfolio</span>--}}
{{--                    </a>--}}
{{--                    <ul aria-expanded="false">--}}
{{--                        <li><a href="{{route('admin_school')}}">Main</a></li>--}}
{{--                        <li><a href="{{route('admin_school_branch')}}">Branches</a></li>--}}
{{--                        <li><a href="{{route('admin_school_level')}}">Levels</a></li>--}}
{{--                        <li><a href="{{route('admin_school_house')}}">Houses</a></li>--}}
{{--                        <li><a href="{{route('admin_school_category')}}">Categories</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a class="has-arrow " href="javascript:void()" aria-expanded="false">--}}

{{--                        <i class="flaticon-381-user-4"></i>--}}
{{--                        <span class="nav-text">Users</span>--}}
{{--                    </a>--}}
{{--                    <ul aria-expanded="false">--}}
{{--                        <li><a href="{{route('admin_user_account_permission')}}">View Users</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
            </ul>
        @endauth
    </div>
</div>
