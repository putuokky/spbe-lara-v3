@auth
    <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="https://spbe.denpasarkota.go.id/">{{ env('APP_NAME') }}</a>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <a href="https://spbe.denpasarkota.go.id/">{{ env('APP_NAME') }}</a>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li class="{{ Request::is('dashboard-app') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('dashboard-app') }}"><i class="fas fa-fire"></i><span>Dashboard
                            Aplikasi</span></a>
                </li>
                <li class="{{ Request::is('dashboard-spbe') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('dashboard-spbe') }}"><i class="fas fa-fire"></i><span>Dashboard
                            SPBE</span></a>
                </li>
                @if (Auth::user()->role == 'superadmin')
                    <li class="menu-header">Hak Akses</li>
                    <li class="{{ Request::is('hakakses') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('hakakses') }}"><i class="fas fa-user-shield"></i> <span>Hak
                                Akses</span></a>
                    </li>
                @endif
                <!-- profile ganti password -->
                <li class="menu-header">Profile</li>
                <li class="{{ Request::is('profile/edit') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('profile/edit') }}"><i class="far fa-user"></i>
                        <span>Profile</span></a>
                </li>
                <li class="{{ Request::is('profile/change-password') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('profile/change-password') }}"><i class="fas fa-key"></i> <span>Ganti
                            Password</span></a>
                </li>
                <li class="menu-header">Starter</li>
                <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('blank-page') }}"><i class="far fa-square"></i> <span>Blank
                            Page</span></a>
                </li>
            </ul>
        </aside>
    </div>
@endauth
