<!DOCTYPE html>
<html lang="fa" dir="rtl" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد مدیریتی</title>

    <!-- Bootstrap CSS (RTL) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" xintegrity="sha384-nU14brUcp6StFntEOOEBvcJm4huWjB0OcIeQ3fltAfSmuZFrkAif0T+UtNGlKKQv" crossorigin="anonymous">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" xintegrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts (Vazirmatn) -->
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --bs-body-font-family: 'Vazirmatn', sans-serif;
            --sidebar-width: 280px;
            --sidebar-bg: #ffffff;
            --sidebar-link-color: #5c677d;
            --sidebar-link-hover-bg: #f0f2f5;
            --sidebar-link-active-color: #F7941D;
            --sidebar-link-active-bg: #FBF1E6;
            --main-bg: #f8f9fa;
            --bs-primary: #F7941D;
        }

        [data-bs-theme="dark"] {
            --sidebar-bg: #212529;
            --sidebar-link-color: #adb5bd;
            --sidebar-link-hover-bg: #343a40;
            --sidebar-link-active-color: #F7941D;
            --sidebar-link-active-bg: #F7941D21;
            --main-bg: #1a1a1a;
            --bs-tertiary-bg: #2b3035;
        }

        body {
            font-family: var(--bs-body-font-family);
            background-color: var(--main-bg);
            transition: background-color 0.3s ease;
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: var(--sidebar-width);
            z-index: 1030; /* Higher than navbar */
            padding: 20px 0;
            background-color: var(--sidebar-bg);
            border-left: 1px solid var(--bs-border-color);
            transition: transform 0.3s ease;
            overflow-y: auto;
            transform: translateX(0);
        }

        .main-content {
            margin-right: var(--sidebar-width);
            transition: margin-right 0.3s ease;
        }

        /* Collapsed State */
        body.sidebar-collapsed .sidebar {
            transform: translateX(var(--sidebar-width));
        }
        body.sidebar-collapsed .main-content {
            margin-right: 0;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 500;
            color: var(--sidebar-link-color);
            border-radius: 0 30px 30px 0;
            margin: 4px 0 4px 15px;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link .feather {
            margin-left: 12px;
            width: 20px;
            height: 20px;
        }

        .sidebar .nav-link:hover {
            background-color: var(--sidebar-link-hover-bg);
            color: var(--bs-body-color);
        }

        .sidebar .nav-link.active {
            background-color: var(--sidebar-link-active-bg);
            color: var(--sidebar-link-active-color);
            font-weight: 600;
        }

        .sidebar-brand {
            padding: 0 25px 20px 25px;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
        }

        .top-navbar {
            background-color: var(--bs-tertiary-bg);
            border-bottom: 1px solid var(--bs-border-color);
        }

        .card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .05);
        }

        [data-bs-theme="dark"] .card {
            box-shadow: none;
        }

        .stat-card .feather {
            width: 40px;
            height: 40px;
            color: var(--bs-primary);
        }

        #theme-switch {
            cursor: pointer;
        }

        /* Responsive Styles */
        @media (max-width: 991.98px) {
            .sidebar {
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0,0,0,0.5);
                z-index: 1029; /* Below sidebar */
                display: none;
            }
            /* Show overlay only when sidebar is NOT collapsed on mobile */
            body:not(.sidebar-collapsed) .sidebar-overlay {
                display: block;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<nav class="sidebar">
    <div class="sidebar-brand">
        <a href="#" class="text-decoration-none d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box me-2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            <span>پنل مدیریت</span>
        </a>
    </div>
    <ul class="nav flex-column" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link active" href="#" data-page="dashboard">
                <i data-feather="home"></i> داشبورد
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-page="profile">
                <i data-feather="user"></i> پروفایل
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-page="personnel">
                <i data-feather="users"></i> مدیریت پرسنل
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-page="customers">
                <i data-feather="briefcase"></i> مدیریت مشتریان
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-page="ads">
                <i data-feather="airplay"></i> مدیریت آگهی‌ها
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-page="financial">
                <i data-feather="dollar-sign"></i> بخش مالی
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-page="settings">
                <i data-feather="settings"></i> تنظیمات
            </a>
        </li>
    </ul>
</nav>

<!-- Main Content -->
<div class="main-content">
    <div class="sidebar-overlay" id="sidebar-overlay"></div>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg sticky-top top-navbar p-3">
        <div class="container-fluid">
            <button class="btn me-2" type="button" id="sidebar-toggle">
                <i data-feather="menu"></i>
            </button>

            <div class="d-flex align-items-center ms-auto">
                <div id="theme-switch" class="nav-link me-3">
                    <i class="fas fa-sun d-none" id="sun-icon"></i>
                    <i class="fas fa-moon" id="moon-icon"></i>
                </div>

                <div class="nav-item dropdown">
                    <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell fs-5"></i>
                        <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle" style="font-size: 0.6em; padding: 0.3em 0.5em;">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-start">
                        <li><a class="dropdown-item" href="#">یک سفارش جدید ثبت شد.</a></li>
                        <li><a class="dropdown-item" href="#">تیکت پشتیبانی پاسخ داده شد.</a></li>
                        <li><a class="dropdown-item" href="#">یک کاربر جدید ثبت نام کرد.</a></li>
                    </ul>
                </div>

                <div class="vr mx-3 d-none d-sm-block"></div>

                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://placehold.co/150x150/7F5AF0/FFFFFF?text=A" class="rounded-circle" height="35" alt="User" loading="lazy" />
                        <div class="ms-2 me-2 d-none d-md-block">
                            <div class="fw-bold">علی رضایی</div>
                            <div class="small text-secondary">مدیر فروش</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-start">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i>پروفایل من</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>تنظیمات</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>خروج</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="container-fluid p-4">

        <!-- Dashboard Page -->
        <div id="page-dashboard" class="page-content">
            <h1 class="h3 mb-4">داشبورد</h1>
            <div class="row g-4">
                <!-- Stat Cards -->
                <div class="col-md-6 col-xl-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3"><i data-feather="users"></i></div>
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-1">مشتریان جدید</h5>
                                <h3 class="mb-0">۲,۳۸۲</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3"><i data-feather="dollar-sign"></i></div>
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-1">درآمد امروز</h5>
                                <h3 class="mb-0">۴۵,۲۱۰ <small>تومان</small></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3"><i data-feather="airplay"></i></div>
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-1">آگهی‌های فعال</h5>
                                <h3 class="mb-0">۱,۰۲۴</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card stat-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-shrink-0 me-3"><i data-feather="message-square"></i></div>
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-1">تیکت‌های باز</h5>
                                <h3 class="mb-0">۱۵</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="col-xl-7">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">تحلیل درآمد</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">توزیع مشتریان</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="customerChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Page -->
        <div id="page-profile" class="page-content d-none">
            <h1 class="h3 mb-4">پروفایل کاربری</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">ویرایش اطلاعات</h5>
                    <form>
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="https://placehold.co/150x150/E7F1FF/0D6EFD?text=A" class="img-thumbnail rounded-circle mb-3" alt="Avatar">
                                <button type="button" class="btn btn-sm btn-outline-primary">تغییر آواتار</button>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">نام و نام خانوادگی</label>
                                    <input type="text" class="form-control" id="fullName" value="علی رضایی">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">ایمیل</label>
                                    <input type="email" class="form-control" id="email" value="ali.rezaei@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">شماره تماس</label>
                                    <input type="text" class="form-control" id="phone" value="۰۹۱۲۳۴۵۶۷۸۹">
                                </div>
                                <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Other Pages (Placeholders) -->
        <div id="page-personnel" class="page-content d-none">
            <h1 class="h3 mb-4">مدیریت پرسنل</h1>
            <div class="card">
                <div class="card-body">
                    <p>اینجا محتوای صفحه مدیریت پرسنل قرار می‌گیرد. شامل جدول، جستجو و فیلترها.</p>
                </div>
            </div>
        </div>
        <div id="page-customers" class="page-content d-none">
            <h1 class="h3 mb-4">مدیریت مشتریان</h1>
            <div class="card">
                <div class="card-body">
                    <p>اینجا محتوای صفحه مدیریت مشتریان قرار می‌گیرد.</p>
                </div>
            </div>
        </div>
        <div id="page-ads" class="page-content d-none">
            <h1 class="h3 mb-4">مدیریت آگهی‌ها</h1>
            <div class="card">
                <div class="card-body">
                    <p>اینجا محتوای صفحه مدیریت آگهی‌ها قرار می‌گیرد.</p>
                </div>
            </div>
        </div>
        <div id="page-financial" class="page-content d-none">
            <h1 class="h3 mb-4">بخش مالی</h1>
            <div class="card">
                <div class="card-body">
                    <p>اینجا محتوای بخش مالی شامل گزارشات، تراکنش‌ها و... قرار می‌گیرد.</p>
                </div>
            </div>
        </div>
        <div id="page-settings" class="page-content d-none">
            <h1 class="h3 mb-4">تنظیمات</h1>
            <div class="card">
                <div class="card-body">
                    <p>اینجا محتوای صفحه تنظیمات قرار می‌گیرد.</p>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- Feather Icons -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // --- Initialize Feather Icons ---
    feather.replace();

    // --- Chart Variables and Functions ---
    let revenueChartInstance, customerChartInstance;

    const chartOptions = (theme) => {
        const isDark = theme === 'dark';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
        const textColor = isDark ? '#adb5bd' : '#495057';

        return {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: textColor
                    }
                }
            },
            scales: {
                y: {
                    ticks: { color: textColor },
                    grid: { color: gridColor }
                },
                x: {
                    ticks: { color: textColor },
                    grid: { color: gridColor }
                }
            }
        };
    };

    const updateChartsTheme = (theme) => {
        if (revenueChartInstance) {
            revenueChartInstance.options = chartOptions(theme);
            revenueChartInstance.update();
        }
        if (customerChartInstance) {
            customerChartInstance.options = {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: theme === 'dark' ? '#adb5bd' : '#495057'
                        }
                    }
                }
            }
            customerChartInstance.update();
        }
    };

    const createCharts = (theme) => {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        revenueChartInstance = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر'],
                datasets: [{
                    label: 'درآمد (میلیون تومان)',
                    data: [12, 19, 3, 5, 2, 3, 9],
                    borderColor: '#F7941D',
                    backgroundColor: 'rgba(217, 119, 6, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: chartOptions(theme)
        });

        // Customer Chart
        const customerCtx = document.getElementById('customerChart').getContext('2d');
        customerChartInstance = new Chart(customerCtx, {
            type: 'doughnut',
            data: {
                labels: ['تهران', 'اصفهان', 'شیراز'],
                datasets: [{
                    label: 'توزیع مشتری',
                    data: [300, 50, 100],
                    backgroundColor: ['#0d6efd', '#198754', '#ffc107'],
                    hoverOffset: 4
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: theme === 'dark' ? '#adb5bd' : '#495057'
                        }
                    }
                }
            }
        });
    };

    // --- Theme Toggler ---
    const themeSwitch = document.getElementById('theme-switch');
    const htmlEl = document.documentElement;
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');

    const setTheme = (theme) => {
        htmlEl.setAttribute('data-bs-theme', theme);
        if (theme === 'dark') {
            sunIcon.classList.remove('d-none');
            moonIcon.classList.add('d-none');
        } else {
            moonIcon.classList.remove('d-none');
            sunIcon.classList.add('d-none');
        }
        localStorage.setItem('theme', theme);
        if (revenueChartInstance || customerChartInstance) {
            updateChartsTheme(theme);
        }
    };

    themeSwitch.addEventListener('click', () => {
        const currentTheme = htmlEl.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        setTheme(newTheme);
    });

    // --- Sidebar & Page Navigation ---
    const bodyEl = document.body;
    const sidebarNav = document.getElementById('sidebar-nav');
    const pageContents = document.querySelectorAll('.page-content');
    const sidebarToggleBtn = document.getElementById('sidebar-toggle');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    // Main toggle button logic for all screen sizes
    sidebarToggleBtn.addEventListener('click', () => {
        bodyEl.classList.toggle('sidebar-collapsed');
    });

    // Overlay click should only collapse the sidebar
    sidebarOverlay.addEventListener('click', () => {
        bodyEl.classList.add('sidebar-collapsed');
    });

    // Navigation link click logic
    sidebarNav.addEventListener('click', (e) => {
        e.preventDefault();
        const link = e.target.closest('.nav-link');
        if (!link) return;

        // Update active link
        sidebarNav.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        link.classList.add('active');

        // Show selected page
        const pageId = 'page-' + link.dataset.page;
        pageContents.forEach(page => {
            page.classList.toggle('d-none', page.id !== pageId);
        });

        // On mobile, also close the sidebar after clicking a link
        if(window.innerWidth < 992) {
            bodyEl.classList.add('sidebar-collapsed');
        }
    });

    // --- Initial Load ---
    const savedTheme = localStorage.getItem('theme') || 'light';
    setTheme(savedTheme);
    createCharts(savedTheme);

    // Collapse sidebar on mobile by default for better initial view
    if (window.innerWidth < 992) {
        bodyEl.classList.add('sidebar-collapsed');
    }

</script>
</body>
</html>
