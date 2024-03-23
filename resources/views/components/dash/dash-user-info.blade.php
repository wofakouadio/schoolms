@auth('admin')
    <div class="dropdown header-profile2 ">
        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="header-info2 d-flex align-items-center">
                <img src="{{asset('assets/images/profile/pic1.jpg')}}" alt="">
                <div class="d-flex align-items-center sidebar-info">
                    <div>
                        <span class="font-w400 d-block">{{Auth::guard('admin')->user()->admin_firstName.' '.Auth::guard
                        ('admin')->user()->admin_lastName}}</span>
                        <small class="text-end font-w400">SuperAdmin</small>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div>

            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end" style="">
            <a href="" class="dropdown-item ai-icon ">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span class="ms-2">Profile </span>
            </a>
            <a href="" class="dropdown-item ai-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                <span class="ms-2">Inbox </span>
            </a>
            @auth('admin')
                <a href="{{route('admin_logout')}}" class="dropdown-item ai-icon">
                    <svg  xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="ms-2">Logout </span>
                </a>
            @endauth
        </div>
    </div>
@else
    <div class="dropdown header-profile2 ">
        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="header-info2 d-flex align-items-center">
                <img src="{{asset('assets/images/profile/pic1.jpg')}}" alt="">
                <div class="d-flex align-items-center sidebar-info">
                    <div>
                        <span class="font-w400 d-block">Franklin Jr</span>
                        <small class="text-end font-w400">Superadmin</small>
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div>

            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end" style="">
            <a href="" class="dropdown-item ai-icon ">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span class="ms-2">Profile </span>
            </a>
            <a href="" class="dropdown-item ai-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                <span class="ms-2">Inbox </span>
            </a>
            <a href="" class="dropdown-item ai-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                <span class="ms-2">Logout </span>
            </a>
        </div>
    </div>
@endauth
