@extends('dashboard.layouts.app')

@section('title', 'ویرایش رشته تحصیلی | سیستم مدیریت مدرسه')

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
                    <i class="fa-solid fa-edit me-2"></i>ویرایش رشته تحصیلی
                </h3>
                <p class="text-muted mb-0">ویرایش اطلاعات رشته: <span
                        class="fw-semibold text-primary">{{ $data['studyField']->name }}</span></p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.studyFields.index') }}" class="btn bg-danger btn-pill">
                    <i class="fa-solid fa-arrow-right me-2"></i>بازگشت
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if ($errors->any())
        <div class="alert alert-danger animate__animated animate__fadeInDown">
            <i class="fa-solid fa-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Form -->
    <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp"
         style="animation-delay: 0.2s;">
        <div class="card-header glass-effect border-0">
            <h5 class="mb-0 gradient-text fw-bold">
                <i class="fa-solid fa-edit me-2"></i>فرم ویرایش رشته تحصیلی
            </h5>
        </div>
        <div class="card-body p-4">
            <form method="post" action="{{ route('dashboard.studyFields.update', $data['studyField']->id) }}">
                @csrf
                @method('put')
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-graduation-cap me-2 text-warning"></i>نام رشته تحصیلی
                        </label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: ریاضی، فیزیک، شیمی"
                               value="{{ $data['studyField']->name }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-graduation-cap me-2 text-warning"></i> نام پایه تحصیلی
                        </label>
                        <select class="form-control" name="study_base_id">
                            <option
                                value="{{ $data['studyField']->studyBase->id }}">{{ $data['studyField']->studyBase->name }}</option>
                            @foreach($data['studyBases'] as $studyBase)
                                <option value="{{ $studyBase->id }}">{{ $studyBase->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-graduation-cap me-2 text-warning"></i> انتخاب رشته ی والد :
                            <small>توجه فرمایید که در صورتی که رشته ی تحصیلی والد است از انتخاب پرنت خود داری
                                کنید</small>
                        </label>
                        <select class="form-control" name="parent_id">
                            <option
                                value="{{ $data['studyField']->parent->name ?? NULL }}">{{ $data['studyField']->parent->name ?? 'بدون والد' }}</option>
                            @foreach($data['studyFields'] as $studyFields)
                                <option value="{{ $studyFields->id }}">{{ $studyFields->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('dashboard.studyFields.index') }}" class="btn bg-danger btn-pill">
                                <i class="fa-solid fa-times me-2"></i>انصراف
                            </a>
                            <button type="submit" class="btn bg-warning btn-pill">
                                <i class="fa-solid fa-save me-2"></i>ویرایش رشته تحصیلی
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
