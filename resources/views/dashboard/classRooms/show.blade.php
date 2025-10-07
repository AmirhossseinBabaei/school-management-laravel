@extends('dashboard.layouts.app')

@section('title', 'مشاهده کلاس درس | سیستم مدیریت مکلاس درسه')

@push('styles')
<style>
.btn-pill {
    border-radius: 25px;
}

.info-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 1.5rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: rgba(255, 255, 255, 0.8);
    min-width: 120px;
}

.info-value {
    color: #ffffff;
    font-weight: 500;
}
</style>
@endpush

@section('content')
            <!-- Hero Section -->
            <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp" style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h3 class="mb-2 gradient-text fw-bold">
                            <i class="fa-solid fa-eye me-2"></i>مشاهده کلاس درس
                        </h3>
                        <p class="text-muted mb-0">جزئیات کلاس درس: <span class="fw-semibold text-primary">{{ $data['classRoom']->name }}</span></p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.classRooms.edit', $data['classRoom']->id) }}" class="btn bg-warning btn-pill">
                            <i class="fa-solid fa-edit me-2"></i>ویرایش
                        </a>
                        <a href="{{ route('dashboard.classRooms.index') }}" class="btn bg-secondary btn-pill">
                            <i class="fa-solid fa-arrow-right me-2"></i>بازگشت
                        </a>
            </div>
        </div>
            </div>

            <!-- Role Information -->
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                        <div class="card-header glass-effect border-0">
                            <h5 class="mb-0 gradient-text fw-bold">
                                <i class="fa-solid fa-info-circle me-2"></i>اطلاعات کلاس درس
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="info-card">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa-solid fa-tag me-2 text-primary"></i>نام کلاس درس:
                                    </div>
                                    <div class="info-value">{{ $data['classRoom']->name }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa-solid fa-toggle-on me-2 text-success"></i> نام مدرسه:
                                    </div>
                                    <div class="info-value">{{ $data['classRoom']->school->name  }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa-solid fa-calendar me-2 text-info"></i>تاریخ ایجاد:
                                    </div>
                                    <div class="info-value">{{ $data['classRoom']->created_at ? $data['classRoom']->created_at : 'نامشخص' }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa-solid fa-clock me-2 text-warning"></i>آخرین بروزرسانی:
                                    </div>
                                    <div class="info-value">{{ $data['classRoom']->updated_at ? $data['classRoom']->updated_at : 'نامشخص' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                        <div class="card-header glass-effect border-0">
                            <h5 class="mb-0 gradient-text fw-bold">
                                <i class="fa-solid fa-bolt me-2"></i>اکشن‌های سریع
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-grid gap-3">
                                <a href="{{ route('dashboard.classRooms.edit', $data['classRoom']->id) }}" class="btn bg-warning btn-pill">
                                    <i class="fa-solid fa-edit me-2"></i>ویرایش کلاس درس
                                </a>
                                <a href="{{ route('dashboard.classRooms.create') }}" class="btn bg-success btn-pill">
                                    <i class="fa-solid fa-plus me-2"></i>ایجاد کلاس درس جدید
                                </a>
                                <a href="{{ route('dashboard.classRooms.index') }}" class="btn bg-primary btn-pill">
                                    <i class="fa-solid fa-list me-2"></i>لیست کلاس درس‌ها
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
