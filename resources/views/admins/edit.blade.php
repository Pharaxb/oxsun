@extends('layouts.admin')

@section('content')

    <!-- Personnel Management Page -->
    <div id="page-personnel" class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">ویرایش پرسنل</h1>
        </div>
        <div class="card">
            <div class="card-body p-4">
                <livewire:admin.edit :$admin />
            </div>
        </div>
    </div>
@endsection
