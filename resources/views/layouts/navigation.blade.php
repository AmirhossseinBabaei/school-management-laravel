<!-- Main Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('images/school/school.png') }}" alt="School Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">سیستم مدیریت مدرسه</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('images/school/school.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>داشبورد</p>
                    </a>
                </li>

                <!-- Students Management -->
                <li class="nav-item {{ request()->routeIs('dashboard.students.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('dashboard.students.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            مدیریت دانش‌آموزان
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.students.index') }}" class="nav-link {{ request()->routeIs('dashboard.students.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>لیست دانش‌آموزان</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.students.create') }}" class="nav-link {{ request()->routeIs('dashboard.students.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>افزودن دانش‌آموز</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Study Fields Management -->
                <li class="nav-item {{ request()->routeIs('dashboard.studyFields.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('dashboard.studyFields.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            مدیریت رشته‌ها
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.studyFields.index') }}" class="nav-link {{ request()->routeIs('dashboard.studyFields.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>لیست رشته‌ها</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.studyFields.create') }}" class="nav-link {{ request()->routeIs('dashboard.studyFields.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>افزودن رشته</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Lessons Management -->
                <li class="nav-item {{ request()->routeIs('dashboard.lessons.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('dashboard.lessons.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            مدیریت دروس
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.lessons.index') }}" class="nav-link {{ request()->routeIs('dashboard.lessons.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>لیست دروس</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.lessons.create') }}" class="nav-link {{ request()->routeIs('dashboard.lessons.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>افزودن درس</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Attendance Management -->
                <li class="nav-item {{ request()->routeIs('dashboard.attendances.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('dashboard.attendances.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>
                            مدیریت حضور و غیاب
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.attendances.index') }}" class="nav-link {{ request()->routeIs('dashboard.attendances.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>لیست حضور و غیاب</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.attendances.create') }}" class="nav-link {{ request()->routeIs('dashboard.attendances.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ثبت حضور و غیاب</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Admin Only Sections -->
                @if(Auth::user()->role && in_array(Auth::user()->role->name, ['مدیر', 'admin']))
                    <li class="nav-header">مدیریت سیستم</li>
                    
                    <!-- Users Management -->
                    <li class="nav-item {{ request()->routeIs('dashboard.users.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>
                                مدیریت کاربران
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dashboard.users.index') }}" class="nav-link {{ request()->routeIs('dashboard.users.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>لیست کاربران</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.users.create') }}" class="nav-link {{ request()->routeIs('dashboard.users.create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>افزودن کاربر</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Roles Management -->
                    <li class="nav-item {{ request()->routeIs('dashboard.roles.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shield-alt"></i>
                            <p>
                                مدیریت نقش‌ها
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('dashboard.roles.index') }}" class="nav-link {{ request()->routeIs('dashboard.roles.index') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>لیست نقش‌ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('dashboard.roles.create') }}" class="nav-link {{ request()->routeIs('dashboard.roles.create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>افزودن نقش</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Logout -->
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>خروج</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
