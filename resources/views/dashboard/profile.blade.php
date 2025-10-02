@extends('dashboard.layouts.app')

@section('title', 'پروفایل کاربری | سیستم مدیریت مدرسه')

@section('content')
    <!-- Hero Section -->
    <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp"
         style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="mb-2 gradient-text fw-bold">
                    <i class="fa-solid fa-user me-2"></i>پروفایل کاربری
                </h3>
                <p class="text-muted mb-0">مدیریت اطلاعات شخصی و تنظیمات حساب کاربری</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary btn-pill">
                    <i class="fa-solid fa-camera me-2"></i>تغییر عکس
                </button>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if ($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger animate__animated animate__fadeInDown">
                <i class="fa-solid fa-exclamation-circle me-2"></i>{{ $error }}
            </div>
        @endforeach
    @endif

    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp"
                 style="animation-delay: 0.2s;">
                <div class="card-body text-center p-4">
                    <div class="position-relative d-inline-block mb-4">
                        <img
                            src="{{ Auth::user()->avatar_src ? asset(Auth::user()->avatar_src) : asset('assets/img/users/Kylian_Mbappé_2018.jpg') }}"
                            class="rounded-circle border border-3 border-primary" width="150" height="150" alt="avatar">
                        <div class="position-absolute bottom-0 end-0">
                            <button class="btn btn-primary btn-sm rounded-circle">
                                <i class="fa-solid fa-camera"></i>
                            </button>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-2">{{ Auth::user()->first_name ." ". Auth::user()->last_name }}</h4>
                    <p class="text-muted mb-3">{{ Auth::user()->email }}</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                                <span class="badge bg-success rounded-pill">
                                    <i class="fa-solid fa-check me-1"></i>فعال
                                </span>
                        <span class="badge bg-primary rounded-pill">
                                    <i class="fa-solid fa-user-shield me-1"></i>{{ Auth::user()->role->name ?? 'کاربر' }}
                                </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="col-lg-8">
            <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp"
                 style="animation-delay: 0.3s;">
                <div class="card-header glass-effect border-0">
                    <h5 class="mb-0 gradient-text fw-bold">
                        <i class="fa-solid fa-edit me-2"></i>ویرایش اطلاعات شخصی
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form class="row g-3" method="post" action="{{ route('profile.update') }}">
                        @csrf
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-user me-2 text-primary"></i>نام
                            </label>
                            <input type="text" name="first_name" class="form-control"
                                   value="{{ Auth::user()->first_name }}" placeholder="نام خود را وارد کنید">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-user me-2 text-primary"></i>نام خانوادگی
                            </label>
                            <input type="text" name="last_name" class="form-control"
                                   value="{{ Auth::user()->last_name }}" placeholder="نام خانوادگی خود را وارد کنید">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-envelope me-2 text-warning"></i>ایمیل
                            </label>
                            <input type="email" disabled class="form-control" value="{{ Auth::user()->email }}"
                                   style="opacity: 0.7;">
                            <small class="text-muted">ایمیل قابل تغییر نیست</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-phone me-2 text-success"></i>شماره تلفن
                            </label>
                            <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone }}"
                                   placeholder="شماره تلفن خود را وارد کنید">
                        </div>
                        <div class="col-12">
                            <div class="d-flex gap-2">
                                    <input type="submit" value="ذخیره تغییرات" class="btn btn-primary btn-pill">
                                    <i class="fa-solid fa-save me-2"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
