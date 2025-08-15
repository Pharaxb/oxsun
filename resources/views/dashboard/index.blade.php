@extends('layouts.admin')

@section('content')
    <!-- Dashboard Page -->
    <div id="page-dashboard" class="page-content">
        <h1 class="h3 mb-4">داشبورد</h1>
        <div class="row mb-3">
            <!-- Stat Cards -->
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 ms-3"><i data-feather="users"></i></div>
                        <livewire:dashboard.users-count />
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 ms-3"><i data-feather="dollar-sign"></i></div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">درآمد امروز</h5>
                            <h3 class="mb-0">۰ <small>تومان</small></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 ms-3"><i data-feather="airplay"></i></div>
                        <livewire:dashboard.ads-count />
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 ms-3"><i data-feather="message-square"></i></div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1">تیکت‌های باز</h5>
                            <h3 class="mb-0">۰</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">تحلیل درآمد</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">استان</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="provinceChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">شهر</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="cityChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">جنسیت</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">اپراتور موبایل</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="operatorChart"></canvas>
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
@endsection
