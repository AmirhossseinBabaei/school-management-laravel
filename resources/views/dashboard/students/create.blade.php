@extends('dashboard.layouts.app')

@section('title', 'ایجاد دانش آموز جدید | سیستم مدیریت مدانش آموزه')

@push('styles')
<style>
.btn-pill {
    border-radius: 25px;
}
</style>
@endpush

@section('content')
            <!-- Hero Section -->
            <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp" style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h3 class="mb-2 gradient-text fw-bold">
                            <i class="fa-solid fa-user-shield me-2"></i>ایجاد دانش آموز جدید
                        </h3>
                        <p class="text-muted mb-0">افزودن دانش آموز جدید به سیستم</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.students.index') }}" class="btn bg-secondary btn-pill">
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

            <!-- Create Form -->
            <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                <div class="card-header glass-effect border-0">
                    <h5 class="mb-0 gradient-text fw-bold">
                        <i class="fa-solid fa-plus me-2"></i>فرم ایجاد دانش آموز
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('dashboard.students.store') }}">
                        @csrf
                        <div class="row g-3">

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="fa-solid fa-toggle-on me-2 text-success"></i> انتخاب کاربر
                                </label>
                                <select name="user_id" class="form-control">
                                    @foreach($data['users'] as  $user)
                                        <option value="{{  $user->id  }}">{{ $user->first_name }}-{{ $user->last_name  }}
                                            /{{ $user->phone  }}/{{ $user->school->name ?? 'نا مشخص'}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="fa-solid fa-toggle-on me-2 text-success"></i>رشته تحصیلی
                                </label>
                                <select name="study_field_id" class="form-control">
                                    @foreach($data['study_fields'] as  $study_field)
                                        <option value="{{ $study_field->id  }}">{{ $study_field->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="fa-solid fa-toggle-on me-2 text-success"></i> پایه تحصیلی
                                </label>
                                <select name="study_base_id" class="form-control">
                                    @foreach($data['study_bases'] as  $study_base)
                                        <option value="{{ $study_base->id  }}">{{ $study_base->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="fa-solid fa-toggle-on me-2 text-success"></i>  کلاس
                                </label>
                                <select name="class_id" class="form-control">
                                    @foreach($data['classes'] as  $class)
                                        <option value="{{ $class->id  }}">{{ $class->name }}-{{ $class->school->name  }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @admin
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="fa-solid fa-toggle-on me-2 text-success"></i> مدرسه
                                </label>
                                <select name="school_id" class="form-control">
                                    @foreach($data['schools'] as  $school)
                                        <option value="{{ $school->id  }}">{{ $school->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endadmin

                            @owner
                            <input type="hidden" name="school_id" value="{{ Auth::user()->school_id }}">
                            @endowner

                            <div class="col-12">
                                <div class="d-flex gap-3 justify-content-end">
                                    <a href="{{ route('dashboard.students.index') }}" class="btn bg-danger btn-pill">
                                        <i class="fa-solid fa-times me-2"></i>انصراف
                                    </a>

                                    <input class="btn bg-success btn-pill" value="ایجاد دانش آموز" type="submit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
@endsection
