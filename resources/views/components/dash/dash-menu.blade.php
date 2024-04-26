<div class="dlabnav">
    <div class="dlabnav-scroll">
        <x-dash.dash-user-info/>
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{route('admin_dashboard')}}">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-album"></i>
                    <span class="nav-text">Departments</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('admin_department')}}">ListView</a></li>
{{--                    <li><a href="{{route('admin_assign_department_level')}}">Assign Department to Level</a></li>--}}
                </ul>
            </li>
            <li>
                <a href="{{route('admin_teacher')}}">
                    <i class="flaticon-381-user-9"></i>
                    <span class="nav-text">Teachers</span>
                </a>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-school"></i>
                    <span class="nav-text">Students</span>
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
                    <li>
                        <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                            <span class="nav-text">Students</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{route('admin_student_bill')}}">Bills</a></li>
                        </ul>
                    </li>
                    <li><a href="{{route('admin_expenditure')}}">Expenditure</a></li>
                    <li><a href="#">Activity Log</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="bi bi-pen"></i>
                    <span class="nav-text">Subjects</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('admin_subject')}}">View Subjects</a></li>
                    <li><a href="{{route('assign-subject-to-level')}}">Assign Subject To Level</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-album-3"></i>
                    <span class="nav-text">Assessment</span>
                </a>
                <ul aria-expanded="false">
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
                    <li><a href="{{route('admin_student_mid_term')}}">Mid-Term Exams</a></li>
                    <li><a href="{{route('admin_student_end_term')}}">End of Term Exams</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">

                    <i class="flaticon-381-user-4"></i>
                    <span class="nav-text">Users</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="javascript:void()">Add New</a></li>
                    <li><a href="#">View Users</a></li>
                    <li><a href="#">Account Settings</a></li>
                    <li><a href="#">Activity Log</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-settings-5"></i>
                    <span class="nav-text">Portfolio</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('admin_school')}}">Main</a></li>
                    <li><a href="{{route('admin_school_branch')}}">Branches</a></li>
                    <li><a href="{{route('admin_school_level')}}">Levels</a></li>
                    <li><a href="{{route('admin_school_house')}}">Houses</a></li>
                    <li><a href="{{route('admin_school_category')}}">Categories</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-book"></i>
                    <span class="nav-text">Permissions</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="javascript:void()">Add New</a></li>
                    <li><a href="#">View Users</a></li>
                </ul>
            </li>
            <!-- <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-093-waving"></i>
                    <span class="nav-text">Jobs</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="job-list.html">Job Lists</a></li>
                    <li><a href="job-view.html">Job View</a></li>
                    <li><a href="job-application.html">Job Application</a></li>
                    <li><a href="apply-job.html">Apply Job</a></li>
                    <li><a href="new-job.html">New Job</a></li>
                    <li><a href="user-profile.html">User Profile</a></li>
                </ul>
            </li>
            <li><a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                <i class="fa-solid fa-gear"></i>


                <span class="nav-text">CMS</span>
                <span class="badge badge-xs style-1 badge-danger">New</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="content.html">Content</a></li>
                    <li><a href="menu.html">Menu</a></li>
                    <li><a href="email-template.html">Email Template</a></li>
                    <li><a href="blog.html">Blog</a></li>
                </ul>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                <i class="flaticon-050-info"></i>
                    <span class="nav-text">Apps</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="app-profile.html">Profile</a></li>
                        <li><a href="edit-profile.html">Edit Profile <span class="badge badge-xs badge-danger ms-3">New</span></a></li>
                    <li><a href="post-details.html">Post Details</a></li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Email</a>
                        <ul aria-expanded="false">
                            <li><a href="email-compose.html">Compose</a></li>
                            <li><a href="email-inbox.html">Inbox</a></li>
                            <li><a href="email-read.html">Read</a></li>
                        </ul>
                    </li>
                    <li><a href="app-calender.html">Calendar</a></li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Shop</a>
                        <ul aria-expanded="false">
                            <li><a href="ecom-product-grid.html">Product Grid</a></li>
                            <li><a href="ecom-product-list.html">Product List</a></li>
                            <li><a href="ecom-product-detail.html">Product Details</a></li>
                            <li><a href="ecom-product-order.html">Order</a></li>
                            <li><a href="ecom-checkout.html">Checkout</a></li>
                            <li><a href="ecom-invoice.html">Invoice</a></li>
                            <li><a href="ecom-customers.html">Customers</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-041-graph"></i>
                    <span class="nav-text">Charts</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="chart-flot.html">Flot</a></li>
                    <li><a href="chart-morris.html">Morris</a></li>
                    <li><a href="chart-chartjs.html">Chartjs</a></li>
                    <li><a href="chart-chartist.html">Chartist</a></li>
                    <li><a href="chart-sparkline.html">Sparkline</a></li>
                    <li><a href="chart-peity.html">Peity</a></li>
                </ul>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-086-star"></i>
                    <span class="nav-text">Bootstrap</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="ui-accordion.html">Accordion</a></li>
                    <li><a href="ui-alert.html">Alert</a></li>
                    <li><a href="ui-badge.html">Badge</a></li>
                    <li><a href="ui-button.html">Button</a></li>
                    <li><a href="ui-modal.html">Modal</a></li>
                    <li><a href="ui-button-group.html">Button Group</a></li>
                    <li><a href="ui-list-group.html">List Group</a></li>
                    <li><a href="ui-card.html">Cards</a></li>
                    <li><a href="ui-carousel.html">Carousel</a></li>
                    <li><a href="ui-dropdown.html">Dropdown</a></li>
                    <li><a href="ui-popover.html">Popover</a></li>
                    <li><a href="ui-progressbar.html">Progressbar</a></li>
                    <li><a href="ui-tab.html">Tab</a></li>
                    <li><a href="ui-typography.html">Typography</a></li>
                    <li><a href="ui-pagination.html">Pagination</a></li>
                    <li><a href="ui-grid.html">Grid</a></li>

                </ul>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-045-heart"></i>
                    <span class="nav-text">Plugins</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="uc-select2.html">Select 2</a></li>
                    <li><a href="uc-nestable.html">Nestedable</a></li>
                    <li><a href="uc-noui-slider.html">Noui Slider</a></li>
                    <li><a href="uc-sweetalert.html">Sweet Alert</a></li>
                    <li><a href="uc-toastr.html">Toastr</a></li>
                    <li><a href="map-jqvmap.html">Jqv Map</a></li>
                    <li><a href="uc-lightgallery.html">Light Gallery</a></li>
                </ul>
            </li>
            <li><a href="widget-basic.html" class="" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Widget</span>
                </a>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-072-printer"></i>
                    <span class="nav-text">Forms</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="form-element.html">Form Elements</a></li>
                    <li><a href="form-wizard.html">Wizard</a></li>
                    <li><a href="form-ckeditor.html">CkEditor</a></li>
                    <li><a href="form-pickers.html">Pickers</a></li>
                    <li><a href="form-validation.html">Form Validate</a></li>
                </ul>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-043-menu"></i>
                    <span class="nav-text">Table</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="table-bootstrap-basic.html">Bootstrap</a></li>
                    <li><a href="table-datatable-basic.html">Datatable</a></li>
                </ul>
            </li>
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-022-copy"></i>
                    <span class="nav-text">Pages</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="page-login.html">Login</a></li>
                    <li><a href="page-register.html">Register <span class="badge badge-xs badge-danger ms-3">New</span></a></li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Error</a>
                        <ul aria-expanded="false">
                            <li><a href="page-error-400.html">Error 400</a></li>
                            <li><a href="page-error-403.html">Error 403</a></li>
                            <li><a href="page-error-404.html">Error 404</a></li>
                            <li><a href="page-error-500.html">Error 500</a></li>
                            <li><a href="page-error-503.html">Error 503</a></li>
                        </ul>
                    </li>
                    <li><a href="page-lock-screen.html">Lock Screen</a></li>
                    <li><a href="empty-page.html">Empty Page</a></li>
                </ul>
            </li> -->
        </ul>
    </div>
</div>
