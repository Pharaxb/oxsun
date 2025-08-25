@extends('layouts.admin')

@section('content')
    <!-- Profile Page -->
    <div id="page-profile" class="page-content">
        <h1 class="h3 mb-4">پروفایل کاربری</h1>
        <div class="card mb-3">
            <div class="card-body">
                <livewire:user.information :$user />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <livewire:user.transactions :$user />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <livewire:user.locations :$user />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
