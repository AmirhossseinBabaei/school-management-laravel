@extends('dashboard.layouts.app')

@section('title', 'مشاهده رشته تحصیلی | سیستم مدیریت مدرسه')

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
                            <i class="fa-solid fa-eye me-2"></i>مشاهده رشته تحصیلی
                        </h3>
                        <p class="text-muted mb-0">جزئیات رشته: <span class="fw-semibold text-primary">{{ $data['studyField']->name }}</span></p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.studyFields.edit', $data['studyField']->id) }}" class="btn bg-warning btn-pill">
                            <i class="fa-solid fa-edit me-2"></i>ویرایش
                        </a>
                        <a href="{{ route('dashboard.studyFields.index') }}" class="btn bg-danger btn-pill">
                            <i class="fa-solid fa-arrow-right me-2"></i>بازگشت
                        </a>
            </div>
        </div>
            </div>

            <!-- Study Field Information -->
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                        <div class="card-header glass-effect border-0">
                            <h5 class="mb-0 gradient-text fw-bold">
                                <i class="fa-solid fa-info-circle me-2"></i>اطلاعات رشته تحصیلی
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="info-card">
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa-solid fa-graduation-cap me-2 text-warning"></i>نام رشته:
                                    </div>
                                    <div class="info-value">{{ $data['studyField']->name }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa-solid fa-align-right me-2 text-info"></i>نام پایه تحصیلی:
                                    </div>
                                    <div class="info-value">{{ $data['studyField']->studyBase->name ?? 'بدون پایه' }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa-solid fa-align-right me-2 text-info"></i>  والد:
                                    </div>
                                    <div class="info-value">{{ $data['studyField']->parent->name ?? 'بدون والد' }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa-solid fa-calendar me-2 text-success"></i>تاریخ ایجاد:
                                    </div>
                                    <div class="info-value">{{ $data['studyField']->created_at ? $data['studyField']->created_at : 'نامشخص' }}</div>
                                </div>

                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fa-solid fa-clock me-2 text-primary"></i>آخرین بروزرسانی:
                                    </div>
                                    <div class="info-value">{{ $data['studyField']->updated_at ? $data['studyField']->updated_at : 'نامشخص' }}</div>
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
                                <a href="{{ route('dashboard.studyFields.edit', $data['studyField']->id) }}" class="btn bg-warning btn-pill">
                                    <i class="fa-solid fa-edit me-2"></i>ویرایش رشته
                                </a>
                                <a href="{{ route('dashboard.studyFields.create') }}" class="btn bg-success btn-pill">
                                    <i class="fa-solid fa-plus me-2"></i>ایجاد رشته جدید
                                </a>
                                <a href="{{ route('dashboard.studyFields.index') }}" class="btn bg-primary btn-pill">
                                    <i class="fa-solid fa-list me-2"></i>لیست رشته‌ها
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
