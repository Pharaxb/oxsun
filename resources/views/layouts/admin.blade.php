<!DOCTYPE html>
<html lang="fa" dir="rtl" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد مدیریتی</title>

    @vite(['resources/sass/dashboard.scss', 'resources/js/dashboard.js', 'resources/js/charts.js'])

    <!-- Google Fonts (Vazirmatn) -->
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap" rel="stylesheet">


</head>
<body>

<!-- Sidebar -->
<nav class="sidebar">
    <div class="sidebar-brand">
        <a href="#" class="text-decoration-none d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box ms-2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            <span>پنل مدیریت</span>
        </a>
    </div>
    <ul class="nav flex-column" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link  @if(Request::is('admin')) active @endif" href="{{ route('dashboard') }}" data-page="dashboard">
                <i data-feather="home"></i> داشبورد
            </a>
        </li>
        @can('show-admin')
            <li class="nav-item">
                <a class="nav-link @if(Request::is('admin/admins*')) active @endif" href="{{ route('admins.index') }}" data-page="personnel">
                    <i data-feather="users"></i> مدیریت پرسنل
                </a>
            </li>
        @endcan
        @can('show-user')
        <li class="nav-item">
            <a class="nav-link" href="#" data-page="customers">
                <i data-feather="briefcase"></i> مدیریت مشتریان
            </a>
        </li>
        @endcan
        @can('show-ad')
        <li class="nav-item">
            <a class="nav-link" href="#" data-page="ads">
                <i data-feather="airplay"></i> مدیریت آگهی‌ها
            </a>
        </li>
        @endcan
        @can('show-admin')
        <li class="nav-item">
            <a class="nav-link" href="#" data-page="financial">
                <i data-feather="dollar-sign"></i> بخش مالی
            </a>
        </li>
        @endcan
        @can('show-admin')
        <li class="nav-item">
            <a class="nav-link" href="#" data-page="settings">
                <i data-feather="settings"></i> تنظیمات
            </a>
        </li>
        @endcan
        @can('developer')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('scramble.docs.ui') }}" data-page="settings">
                    <i data-feather="code"></i> مستندات API
                </a>
            </li>
        @endcan
    </ul>
    <div class="sidebar-footer">
        <span>{{ $version }}</span>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content">
    <div class="sidebar-overlay" id="sidebar-overlay"></div>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg sticky-top top-navbar p-3">
        <div class="container-fluid">
            <button class="btn ms-2" type="button" id="sidebar-toggle">
                <i data-feather="menu"></i>
            </button>

            <div class="d-flex align-items-center me-auto">
                <div id="theme-switch" class="nav-link ms-3">
                    <i class="fas fa-sun d-none" id="sun-icon"></i>
                    <i class="fas fa-moon" id="moon-icon"></i>
                </div>

                <div class="nav-item dropdown">
                    <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell fs-5"></i>
                        <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle" style="font-size: 0.6em; padding: 0.3em 0.5em;">{{ to_farsi_number(3) }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-end">
                        <li><a class="dropdown-item" href="#">یک سفارش جدید ثبت شد.</a></li>
                        <li><a class="dropdown-item" href="#">تیکت پشتیبانی پاسخ داده شد.</a></li>
                        <li><a class="dropdown-item" href="#">یک کاربر جدید ثبت نام کرد.</a></li>
                    </ul>
                </div>

                <div class="vr mx-3 d-none d-sm-block"></div>

                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <livewire:navbar.avatar :$admin  />
                        <div class="ms-2 me-2 d-none d-md-block">
                            <livewire:navbar.fullname :$admin  />
                            <div class="small text-secondary">{{ $admin->position }}</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-end">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-circle ms-2"></i>پروفایل من</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt ms-2"></i>خروج

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="container-fluid p-4">
        @yield('content')
    </main>
</div>
</body>
</html>
