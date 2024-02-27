<div class="navbar-area">
    <div class="main-responsive-nav">
        <div class="main-responsive-menu">
            <div class="responsive-burger-menu d-lg-none d-block">
                <span class="top-bar"></span>
                <span class="middle-bar"></span>
                <span class="bottom-bar"></span>
            </div>
        </div>
    </div>

    <div class="main-navbar">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">
                <h4 class="text-white">ALEX</h4>
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-burger-menu m-auto">
                    <span class="top-bar"></span>
                    <span class="middle-bar"></span>
                    <span class="bottom-bar"></span>
                </div>

                <div class="search-box m-auto">
                    <form>
                        <input type="text" class="input-search" placeholder="Search...">
                        <button type="submit"><i class="ri-search-line"></i></button>
                    </form>
                </div>

                <div class="others-options d-flex align-items-center">
                    <div class="option-item">
                        <a href="{{ route('home') }}" class="home-btn"><i class="flaticon-home"></i></a>
                    </div>
                    
                    <div class="option-item">
                        <div class="dropdown notifications-nav-item">
                            <a href="#" class="dropdown-bs-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="notifications-btn">
                                    <i class="flaticon-bell"></i>
                                    <span id="notification-counter"></span>
                                </div>
                            </a>
                            @auth
                                <div id="notification-dropdown" style="display: none" class="dropdown-menu">
                                    <div class="notifications-header d-flex justify-content-between align-items-center">
                                        <h3>Notifications</h3>
                                        <span id="mark-read" style="border-radius: 5px; cursor: pointer;" >Mar All Read</span>
                                    </div>
                                    <div id="notifications-body" class="notifications-body" data-simplebar>
                                        
                                        
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                   
                    <div class="option-item">
                        <div class="dropdown profile-nav-item">
                            <a href="#" class="dropdown-bs-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="menu-profile">
                                    @if(auth()->user()->profile_pic)
                                        <img src="{{ auth()->user()->profile_pic }}" alt="{{ auth()->user()->name }}">
                                    @else
                                        <img src="{{ asset('assets/images/user/user-default.png') }}" alt="{{ auth()->user()->name }}">
                                    @endif
                                    <span class="name">{{ auth()->user()->name }}</span>
                                    <span class="status-online"></span>
                                </div>
                            </a>

                            <div class="dropdown-menu">
                                <div class="profile-header">
                                    <h3>{{ auth()->user()->name }}</h3>
                                    <a href="mailto:{{ auth()->user()->email }}">{{ auth()->user()->email }}</a>
                                </div>
                                <ul class="profile-body">
                                   <li><i class="flaticon-logout"></i> <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();">
                                                      Logout
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>

         
</div>