@php
    session(['source' => Request::path()]);
@endphp
<header>
    <div class="hmd-outer">
        <div class="container">
            <div class="hmd-inner">
                <div class="hmd-logo">
                 {{-- <img src="{{ asset('web/images/logo.png') }}" alt="" height="40px"> --}}
                  <a href="https://homedesigns.ai/">  <img src="{{ asset('web/images/NewHomeDesignsAILogo.svg') }}" alt="homedesignsai logo" style="width: 70%;"> </a>
                </div>
                <div class="hmd-navflx">
                    <div class="hmd-nav">
                        <ul>
                           <!--  <li class="hmd-navlist active"><a class="active" href="{{ url('/') }}">Home</a></li> -->
                           <!-- <li class="hmd-navlist"><a href="https://homedesigns.ai/affiliate-program">Get Paid</a>  -->
                          <!--  <li class="hmd-navlist"><a href="https://homedesigns.ai/go/blog">Blog</a>  -->
							 @if (!auth()->check())
                                <li class="hmd-navlist"><a href="{{ route('login')}}">Login</a></li>
                            @else
                                <li class="hmd-navlist"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                <li class="hmd-navlist">
                                    <div style="cursor:pointer;">
                                        <a href="#" class="logout_user">
                                            Logout
                                        </a>
                                    </div>
                                </li>
                            @endif

                            @if(request()->routeIs('freeTrial') || request()->routeIs('freeTrialFB'))
                                <li class="hmd-navlist"><a href="#buy">Start 7-Day Trial</a></li>
                            @endif
							<li class="hmd-navlist"><a href="https://homedesigns.ai/#features">Features</a>
							<li class="hmd-navlist"><a href="https://homedesigns.ai/api">API</a>
							<li class="hmd-navlist"><a href="https://homedesigns.ai/go/blog">Blog</a>

                        </ul>
                    </div>
                    <div class="upgrade-subtn">
                        <a class="upgd-go" href="#buy">
                            <img class="strlight" src="{{ asset('web/images/light.svg') }}" loading="lazy" alt="button light version upgrade homedesigns">
                            Upgrade to PRO
                        </a>
                    </div>
                </div>

                <!-- mobile header -->
                <div class="mobileheader">
                    <div id="mySidenav" class="sidenav">
                        <div>
                            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                          <!--  <a class="menu-link active" href="{{ url('/') }}">Home</a> -->
                            @if (!auth()->check())
                                <a class="menu-link" href="{{ route('login') }}">Login</a>
                            @else
                                <a class="menu-link" href="{{ route('user.dashboard') }}">Dashboard</a>
                                <a class="logout_user" href="javascript:void(0)">Logout</a>
                            @endif
							<!--<a class="menu-link" href="https://homedesigns.ai/affiliate-program">Get Paid</a>      -->
                            <a class="menu-link cls_menu" href="#generate">Start Now</a>
							<a class="menu-link" href="https://homedesigns.ai/#features">Features</a>
							<a class="menu-link" href="https://homedesigns.ai/api">API</a>
							<a class="menu-link" href="https://homedesigns.ai/go/blog">Blog</a>
							<a class="menu-link cls_menu" href="#buy">Upgrade to PRO</a>



                           <!-- <a class="menu-link" href="https://homedesignsai.reamaze.com/">Contact</a> -->
                        </div>
                    </div>

                    <span class="only-mobile" style="font-size:40px; color: #7558ea;cursor:pointer"
                        onclick="openNav()">&#9776;</span>
                </div>
            </div>
        </div>
    </div>
</header>
