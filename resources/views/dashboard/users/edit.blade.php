@extends('dashboard.layouts.app')

@section('title', 'ویرایش کاربر | سیستم مدیریت مدرسه')

@section('content')
    <!-- Hero Section -->
    <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp"
         style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="pulse-animation">
                    <i class="fa-solid fa-edit text-warning" style="font-size: 2rem;"></i>
                </div>
                <div>
                    <h4 class="mb-1 gradient-text fw-bold">ویرایش کاربر</h4>
                    <p class="mb-0 text-muted">ویرایش اطلاعات
                        کاربر: {{ $data['user']->first_name }} {{ $data['user']->last_name }}</p>
                </div>
            </div>
            <div class="d-flex gap-2">
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
                        <i class="fa-solid fa-edit me-2"></i>فرم ویرایش کاربر
                    </h5>
                </div>
                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger animate__animated animate__fadeInDown">
                            <i class="fa-solid fa-exclamation-triangle me-2"></i>
                            <strong>خطا در ورودی:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="row g-4 needs-validation"
                          action="{{ route('dashboard.users.update', ['user' => $data['user']->id]) }}" method="post"
                          novalidate>
                        @csrf
                        @method('put')
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-user me-2 text-primary"></i>نام <span class="text-danger">*</span>
                            </label>
                            <input type="text" value="{{ $data['user']->first_name }}" name="first_name"
                                   class="form-control" placeholder="نام را وارد کنید" required>
                            <div class="invalid-feedback">لطفاً نام را وارد کنید</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-user me-2 text-primary"></i>نام خانوادگی <span
                                    class="text-danger">*</span>
                            </label>
                            <input type="text" name="last_name" value="{{ $data['user']->last_name }}"
                                   class="form-control" placeholder="نام خانوادگی را وارد کنید" required>
                            <div class="invalid-feedback">لطفاً نام خانوادگی را وارد کنید</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-envelope me-2 text-info"></i>ایمیل <span
                                    class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" class="form-control" value="{{ $data['user']->email }}"
                                   placeholder="example@mail.com" required>
                            <div class="invalid-feedback">لطفاً ایمیل معتبر وارد کنید</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-phone me-2 text-success"></i>شماره تلفن
                            </label>
                            <input type="tel" name="phone" class="form-control" value="{{ $data['user']->phone }}"
                                   placeholder="09*********">
                            <div class="invalid-feedback">لطفاً شماره تلفن معتبر وارد کنید</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-code me-2 text-info"></i>کد ملی<span
                                    class="text-danger">*</span>
                            </label>
                            <input type="text" name="national_code" class="form-control" placeholder="example@mail.com"
                                   value="{{ $data['user']->national_code ?? '' }}" required>
                            <div class="invalid-feedback">لطفاً کد ملی معتبر وارد کنید</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-user-shield me-2 text-danger"></i>انتخاب نقش <span
                                    class="text-danger">*</span>
                            </label>
                            <select name="role_id" class="form-select" required>
                                <option value="">انتخاب نقش</option>
                                @foreach($data['roles'] as $role)
                                    <option
                                        value="{{ $role->id }}" {{ $data['user']->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">لطفاً نقش را انتخاب کنید</div>
                            <input type="hidden" name="school_id" value="{{ $data['user']->school_id }}">
                        </div>
                        @admin
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fa-solid fa-school me-2 text-info"></i>انتخاب مدرسه <span class="text-danger">*</span>
                            </label>
                            <select name="school_id" class="form-select" required>
                                <option value="">انتخاب مدرسه</option>
                                @foreach($data['schools'] as $school)
                                    <option
                                        value="{{ $school->id }}" {{ $data['user']->school_id == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">لطفاً مدرسه را انتخاب کنید</div>
                        </div>
                        @endadmin
                        <div class="col-12 d-flex gap-3 justify-content-center">
                            <button class="btn bg-success btn-pill">
                                <input type="submit" class="btn bg-success btn-pill px-4" value="بروزرسانی کاربر">
                            </button>
                            <a href="{{ url('dashboard/users') }}" class="btn bg-danger btn-pill px-4">
                                <i class="fa-solid fa-times me-2"></i>لغو
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
