@auth
    <div class="navbar-bg"></div>
    <nav class="navbar navbar-expand-lg main-navbar">
        <!-- Sidebar Toggle Button on the Left -->
        <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
            <i class="fas fa-bars"></i>
        </a>

        <!-- Right Side Navbar Items -->
        <ul class="navbar-nav ml-auto">
            <li class="dropdown dropdown-list-toggle">
                <a href="{{ route('helper.helper.changelog') }}" class="nav-link nav-link-lg beep" title="Change Log">
                    <i class="fas fa-history"></i>
                </a>
            </li>
            <li class="dropdown dropdown-list-toggle">
                <a href="{{ route('helper.helper.faq') }}" class="nav-link nav-link-lg" title="FAQ">
                    <i class="fas fa-question-circle"></i></a>
            </li>
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                    <div class="d-sm-none d-lg-inline-block">
                        Hai, {{ auth()->user()->name }}
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-title">
                        Selamat Datang, {{ auth()->user()->name }}
                    </div>
                    <a class="dropdown-item has-icon" href="{{ route('profile.edit') }}">
                        <i class="fa fa-user"></i> Profile
                    </a>
                    <a class="dropdown-item has-icon" href="{{ route('profile.change-password') }}">
                        <i class="fa fa-key"></i> Ganti Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
@endauth
