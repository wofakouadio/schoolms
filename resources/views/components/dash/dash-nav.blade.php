@if(Auth::guard('admin')->check())
    <div class="nav-header">
        <a href="{{route('admin_dashboard')}}" class="brand-logo">
            <img src="{{asset('storage/school/logo/profile.png')}}" alt="profile.png" class="rounded" width="62.074"
                 height="65.771" id="school_logo">
            <div class="brand-title"></div>
        </a>
        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
    </div>
@elseif(Auth::guard('teacher')->check())
    <div class="nav-header">
        <a href="{{route('teacher_dashboard')}}" class="brand-logo">
            <img src="{{asset('storage/school/logo/profile.png')}}" alt="profile.png" class="rounded" width="62.074"
                 height="65.771" id="school_logo">
            <div class="brand-title"></div>
        </a>
        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
    </div>
@endif
