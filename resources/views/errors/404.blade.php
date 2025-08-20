@extends('errors::layout')

@section('title', __('Not Found'))
@section('content')
    <!-- Content -->
    <div class="flex-grow-1 container-fluid pt-5">
        <div class="row my-auto">
            <div class="col-md-12 text-center">
                <i class="fa-solid fa-circle-exclamation text-primary fa-10x mb-4"></i>
                <h3 class="mb-3">خطای ۴۰۴</h3>
                <h2>متاسفانه، صفحه مورد نظر یافت نشد!</h2>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection
