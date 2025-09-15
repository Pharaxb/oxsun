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
        <livewire:ad.index />
    </div>
@endsection
