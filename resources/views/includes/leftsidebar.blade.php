<div class="sidemenu-area">
    <div class="responsive-burger-menu d-lg-none d-block">
        <span class="top-bar"></span>
        <span class="middle-bar"></span>
        <span class="bottom-bar"></span>
    </div>

    <div class="sidemenu-body">
        <ul class="sidemenu-nav metisMenu h-100" id="sidemenu-nav" data-simplebar>
            <li class="nav-item active">
                <a href="{{ route('home') }}" class="nav-link">
                    <span class="icon"><i class="flaticon-newspaper"></i></span>
                    <span class="menu-title">News Feed</span>
                </a>
            </li>
           
            
            <li class="nav-item">
                <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();" class="nav-link">
                    <span class="icon"><i class="flaticon-logout"></i></span>
                    <span class="menu-title">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>