@extends('dashboard.layouts.app')

@section('title', 'ایجاد رشته تحصیلی جدید | سیستم مدیریت مدرسه')

@push('styles')
    <style>
        .btn-pill {
            border-radius: 25px;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp"
         style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="mb-2 gradient-text fw-bold">
                    <i class="fa-solid fa-graduation-cap me-2"></i>ایجاد رشته تحصیلی جدید
                </h3>
                <p class="text-muted mb-0">افزودن رشته تحصیلی جدید به سیستم</p>
            </div>
            <div class="d-flex gap-2">
                <x-button 
                    variant="danger" 
                    type="link" 
                    href="{{ route('dashboard.studyFields.index') }}"
                    icon="fa-solid fa-arrow-right"
                    class="btn-pill"
                >
                    بازگشت
                </x-button>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if ($errors->any())
        <x-alert type="danger" icon="fa-solid fa-exclamation-triangle" class="animate__animated animate__fadeInDown">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <!-- Create Form -->
    <x-card 
        type="glass" 
        title="فرم ایجاد رشته تحصیلی" 
        icon="fa-solid fa-plus"
        class="animate__animated animate__fadeInUp"
        style="animation-delay: 0.2s;"
    >
        <x-form method="POST" action="{{ route('dashboard.studyFields.store') }}">
            <div class="row g-3">
                <div class="col-12">
                    <x-input
                        name="name"
                        label="نام رشته تحصیلی"
                        placeholder="مثال: ریاضی، فیزیک، شیمی"
                        icon="fa-solid fa-graduation-cap"
                        required
                    />
                </div>

                <div class="col-12">
                    <x-select
                        name="study_base_id"
                        label="نام پایه تحصیلی"
                        icon="fa-solid fa-graduation-cap"
                        :options="$data['studyBases']->pluck('name', 'id')->toArray()"
                        required
                    />
                </div>

                <div class="col-12">
                    <x-select
                        name="parent_id"
                        label="انتخاب رشته والد"
                        icon="fa-solid fa-graduation-cap"
                        placeholder="بدون والد"
                        :options="$data['studyFields']->pluck('name', 'id')->toArray()"
                        help-text="توجه فرمایید که در صورتی که رشته تحصیلی والد است از انتخاب پرنت خود داری کنید"
                    />
                </div>

                <div class="col-12">
                    <div class="d-flex gap-3 justify-content-end">
                        <x-button 
                            variant="danger" 
                            type="link" 
                            href="{{ route('dashboard.studyFields.index') }}"
                            icon="fa-solid fa-times"
                            class="btn-pill"
                        >
                            انصراف
                        </x-button>
                        
                        <x-button 
                            variant="warning" 
                            type="submit"
                            icon="fa-solid fa-save"
                            class="btn-pill"
                        >
                            ایجاد رشته تحصیلی
                        </x-button>
                    </div>
                </div>
            </div>
        </x-form>
    </x-card>
@endsection
