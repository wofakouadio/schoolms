<x-dash.dash-header/>

    @include('sweetalert::alert')

    <x-dash.dash-preloader/>

    <div id="main-wrapper">

        {{-- nav --}}
        <x-dash.dash-nav/>

        {{-- chatbox --}}
        {{-- it can be added --}}

        {{-- heading --}}
        <x-dash.dash-heading/>

        {{-- menu --}}
        <x-dash.dash-menu/>

        {{-- content --}}
        @yield('content')

        {{-- Modals --}}
        @stack('modals')

        {{-- version control --}}
        <x-dash.dash-version/>

    </div>

<x-dash.dash-footer/>
