<!DOCTYPE html>
<html lang="fa" dir="rtl" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به پنل مدیریت</title>

    @vite(['resources/sass/login.scss', 'resources/js/login.js'])
</head>
<body>
<div class="theme-toggle-container">
    <div id="theme-switch" class="nav-link">
        <i class="fas fa-sun d-none" id="sun-icon"></i>
        <i class="fas fa-moon" id="moon-icon"></i>
    </div>
</div>

<div class="card login-card p-4">
    <div class="card-body">
        <div class="brand-logo">
            <img src="{{ asset('assets/images/favicon/favicon-64x64.png') }}" alt="logo">
        </div>
        <h4 class="card-title text-center mb-4">ورود به حساب کاربری</h4>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">آدرس ایمیل</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" dir="ltr" required autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">گذرواژه</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="********" dir="ltr" required>

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="rememberMe" checked>
                    <label class="form-check-label" for="rememberMe">
                        مرا به خاطر بسپار
                    </label>
                </div>
                <a href="{{ route('password.request') }}" class="form-text text-decoration-none">فراموشی رمز عبور</a>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">ورود</button>
            </div>
        </form>
        <p class="text-center mt-4 mb-0">
            حساب کاربری ندارید؟ <a href="{{ route('register') }}" class="text-decoration-none">ثبت نام</a>
        </p>
    </div>
</div>
</body>
</html>
