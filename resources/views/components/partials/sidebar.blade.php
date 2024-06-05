<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
                <img src="{{ asset('images/logos/logo-kawan-kerja.png') }}" width="180" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                @canany(['is-admin', 'is-hr'])
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                @endcanany
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Managements</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('users') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">User Data</span>
                    </a>
                </li>
                @cannot('')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('roles') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-shield-lock"></i>
                            </span>
                            <span class="hide-menu">Role Data</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('permissions') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-key"></i>
                            </span>
                            <span class="hide-menu">Permission Data</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('employees') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-briefcase"></i>
                            </span>
                            <span class="hide-menu">Employee Data</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('projects') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-message-2-code"></i>
                            </span>
                            <span class="hide-menu">Project Data</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('meetings') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-calendar-time"></i>
                            </span>
                            <span class="hide-menu">Meeting Data</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
