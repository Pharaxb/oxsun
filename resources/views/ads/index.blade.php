@extends('layouts.admin')

@section('content')
    <!-- Ad Management Page -->
    <div id="page-ad" class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">مدیریت آگهی‌ها</h1>
            <a href="{{ route('ads.create') }}" class="btn btn-primary d-flex align-items-center">
                <i data-feather="plus" class="me-2" style="width: 20px;"></i>
                <span>افزودن آگهی</span>
            </a>
        </div>

        <div class="card">
            <div class="card-header justify-content-end" dir="ltr">
                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text"><i class="fa-solid fa-magnifying-glass" style="width: 20px;"></i></span>
                    <input type="text" class="form-control" placeholder="جستجو بر اساس نام، ایمیل..." dir="rtl">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-nowrap">
                        <thead>
                        <tr>
                            <th>عنوان</th>
                            <th>کاربر</th>
                            <th>تیراژ / دیده شده</th>
                            <th>هزینه هر آگهی</th>
                            <th>وضعیت</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
