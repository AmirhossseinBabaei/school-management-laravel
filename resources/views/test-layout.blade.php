@extends('dashboard.layouts.app')

@section('title', 'تست Layout | سیستم مدیریت مدرسه')

@section('content')
    <!-- Hero Section -->
    <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp"
         style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="mb-2 gradient-text fw-bold">
                    <i class="fa-solid fa-graduation-cap me-2"></i>تست Layout
                </h3>
                <p class="text-muted mb-0">تست کردن استایل‌های مختلف</p>
            </div>
        </div>
    </div>

    <!-- Test Form -->
    <x-card 
        type="glass" 
        title="فرم تست" 
        icon="fa-solid fa-test-tube"
        class="animate__animated animate__fadeInUp"
        style="animation-delay: 0.2s;"
    >
        <x-form method="POST" action="#">
            <div class="row g-3">
                <div class="col-12">
                    <x-input
                        name="test_input"
                        label="فیلد تست"
                        placeholder="متن تست را وارد کنید"
                        icon="fa-solid fa-pencil"
                        required
                    />
                </div>

                <div class="col-12">
                    <x-select
                        name="test_select"
                        label="انتخاب تست"
                        icon="fa-solid fa-list"
                        :options="['1' => 'گزینه 1', '2' => 'گزینه 2', '3' => 'گزینه 3']"
                        required
                    />
                </div>

                <div class="col-12">
                    <div class="d-flex gap-3 justify-content-end">
                        <x-button 
                            variant="danger" 
                            type="button"
                            icon="fa-solid fa-times"
                            class="btn-pill"
                        >
                            انصراف
                        </x-button>
                        
                        <x-button 
                            variant="primary" 
                            type="submit"
                            icon="fa-solid fa-save"
                            class="btn-pill"
                        >
                            ذخیره
                        </x-button>
                    </div>
                </div>
            </div>
        </x-form>
    </x-card>

    <!-- Test Buttons -->
    <div class="mt-4">
        <x-card type="glass" title="تست دکمه‌ها" icon="fa-solid fa-mouse-pointer">
            <div class="d-flex gap-3 flex-wrap">
                <x-button variant="primary" icon="fa-solid fa-check">دکمه اصلی</x-button>
                <x-button variant="danger" icon="fa-solid fa-times">دکمه خطر</x-button>
                <x-button variant="warning" icon="fa-solid fa-exclamation">دکمه هشدار</x-button>
                <x-button variant="info" icon="fa-solid fa-info">دکمه اطلاعات</x-button>
                <x-button variant="outline-primary" icon="fa-solid fa-outline">دکمه outline</x-button>
                <x-button variant="outline-danger" icon="fa-solid fa-outline">دکمه outline خطر</x-button>
            </div>
        </x-card>
    </div>

    <!-- Test Alert -->
    <div class="mt-4">
        <x-alert type="success" icon="fa-solid fa-check-circle">
            این یک پیام موفقیت است! تم تاریک به عنوان پیش‌فرض تنظیم شده.
        </x-alert>
    </div>

    <div class="mt-2">
        <x-alert type="danger" icon="fa-solid fa-exclamation-triangle">
            این یک پیام خطا است! می‌توانید با دکمه بالا تم را تغییر دهید.
        </x-alert>
    </div>

    <div class="mt-2">
        <x-alert type="warning" icon="fa-solid fa-exclamation-circle">
            این یک پیام هشدار است! تم انتخاب شده در localStorage ذخیره می‌شود.
        </x-alert>
    </div>

    <div class="mt-2">
        <x-alert type="info" icon="fa-solid fa-info-circle">
            این یک پیام اطلاعاتی است! تمام استایل‌ها برای هر دو تم بهینه شده‌اند.
        </x-alert>
    </div>
@endsection
