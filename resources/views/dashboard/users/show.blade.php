@extends('dashboard.layouts.app')

@section('title', 'مشاهده کاربر | سیستم مدیریت مدرسه')

@section('content')
            <!-- Hero Section -->
            <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp" style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="pulse-animation">
                            <i class="fa-solid fa-eye text-info" style="font-size: 2rem;"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 gradient-text fw-bold">مشاهده کاربر</h4>
                            <p class="mb-0 text-muted">اطلاعات کاربر: {{ $data['user']->first_name }} {{ $data['user']->last_name }}</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.users.edit', $data['user']->id) }}" class="btn bg-warning btn-pill">
                            <i class="fa-solid fa-edit me-2"></i>ویرایش
                        </a>
                        <a href="{{ url('dashboard/users') }}" class="btn btn-outline-primary btn-pill">
                            <i class="fa-solid fa-arrow-left me-2"></i>بازگشت
                        </a>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-8">
                    <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp">
                        <div class="card-header glass-effect border-0">
                            <h5 class="mb-0 gradient-text fw-bold text-center">
                                <i class="fa-solid fa-eye me-2"></i>اطلاعات کاربر
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fa-solid fa-user me-2 text-primary"></i>نام
                                    </label>
                                    <input type="text" disabled value="{{ $data['user']->first_name }}" class="form-control" style="background: rgba(255,255,255,0.05);">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fa-solid fa-user me-2 text-primary"></i>نام خانوادگی
                                    </label>
                                    <input type="text" disabled value="{{ $data['user']->last_name }}" class="form-control" style="background: rgba(255,255,255,0.05);">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fa-solid fa-envelope me-2 text-info"></i>ایمیل
                                    </label>
                                    <input type="email" disabled value="{{ $data['user']->email }}" class="form-control" style="background: rgba(255,255,255,0.05);">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fa-solid fa-phone me-2 text-success"></i>شماره تلفن
                                    </label>
                                    <input type="tel" disabled value="{{ $data['user']->phone }}" class="form-control" style="background: rgba(255,255,255,0.05);">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fa-solid fa-user-shield me-2 text-danger"></i>نقش
                                    </label>
                                    <input type="text" disabled value="{{ $data['user']->role->name ?? 'تعریف نشده' }}" class="form-control" style="background: rgba(255,255,255,0.05);">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fa-solid fa-school me-2 text-info"></i>مدرسه
                                    </label>
                                    <input type="text" disabled value="{{ $data['user']->school->name ?? 'تعریف نشده' }}" class="form-control" style="background: rgba(255,255,255,0.05);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
