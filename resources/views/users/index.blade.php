@extends('layouts.admin')

@section('content')
    <!-- User Management Page -->
    <div id="page-user" class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">مدیریت کاربر</h1>
            <button class="btn btn-primary d-flex align-items-center">
                <i data-feather="plus" class="me-2" style="width: 20px;"></i>
                <span>افزودن کاربر</span>
            </button>
        </div>
        <livewire:user.index />
    </div>
@endsection
