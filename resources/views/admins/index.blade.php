@extends('layouts.admin')

@section('content')
    <!-- Personnel Management Page -->
    <div id="page-personnel" class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">مدیریت پرسنل</h1>
            <button class="btn btn-primary d-flex align-items-center">
                <i data-feather="plus" class="me-2" style="width: 20px;"></i>
                <span>افزودن پرسنل</span>
            </button>
        </div>
        <livewire:admin.index />
    </div>
@endsection
