@extends('dashboard.layouts.app')

@section('title', 'ارسال نوتیفیکیشن | سیستم مدیریت مدرسه')

@push('styles')
    <style>
        .btn-pill {
            border-radius: 25px;
        }

        .glass-effect {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.03) 100%);
            backdrop-filter: blur(6px);
        }

        .gradient-text {
            background: linear-gradient(90deg, #ffb703, #fb8500);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .option-chip {
            border: 1px dashed #ffc107;
            border-radius: 10px;
            padding: 6px 10px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
    </style>
@endpush

@section('content')
    <!-- Hero -->
    <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="mb-2 gradient-text fw-bold">
                    <i class="fa-solid fa-bell me-2"></i>ارسال نوتیفیکیشن
                </h3>
                <p class="text-muted mb-0">ارسال پیام به همه کاربران، بر اساس نقش/مدرسه/کلاس یا دانش‌آموز خاص</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn bg-danger btn-pill">
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
    @if (session('status'))
        <div class="alert alert-success animate__animated animate__fadeInDown">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('status') }}
        </div>
    @endif

    <!-- Create Form -->
    <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp" style="animation-delay: .1s;">
        <div class="card-header glass-effect border-0">
            <h5 class="mb-0 gradient-text fw-bold">
                <i class="fa-solid fa-paper-plane me-2"></i>فرم ارسال نوتیفیکیشن
            </h5>
        </div>
        <div class="card-body p-4">
            <form method="post" action="{{ route('dashboard.notifications.store') }}">
                @csrf
                <div class="row g-3">
                    <!-- Title -->
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-heading me-2 text-warning"></i>عنوان
                        </label>
                        <input type="text" name="title" class="form-control" placeholder="مثال: اطلاعیه مهم"
                               value="{{ old('title') }}">
                    </div>

                    <!-- Channel -->
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-share-nodes me-2 text-warning"></i>کانال ارسال
                        </label>
                        <div class="d-flex flex-wrap gap-2">
                            <label class="option-chip">
                                <input type="checkbox" name="channels[]" value="sms"
                                       class="form-check-input me-1" {{ in_array('sms', (array) old('channels', [])) ? 'checked' : '' }}>پیامک
                            </label>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-message me-2 text-warning"></i>متن پیام
                        </label>
                        <textarea name="message" rows="5" class="form-control"
                                  placeholder="متن نوتیفیکیشن را وارد کنید...">{{ old('message') }}</textarea>
                    </div>

                    <!-- Audience selector -->
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-bullseye me-2 text-warning"></i>دریافت‌کنندگان
                        </label>
                        <select class="form-control" name="audience_data" id="audience">
                            <option value="allUsers" {{ old('audience') === 'allUsers' ? 'selected' : '' }}>همه
                                کاربران
                            </option>
                            {{--                            <option value="role" {{ old('audience') === 'AllRoles' ? 'selected' : '' }}>بر اساس نقش</option>--}}
                            <option value="allOwners" {{ old('audience') === 'allOwners' ? 'selected' : '' }}>بر اساس
                                مدیران مدرسه
                            </option>
                            <option
                                value="attendanceSchool" {{ old('audience') === 'attendanceSchool' ? 'selected' : '' }}>
                                بر اساس غایبین امروز
                            </option>
                            <option value="student" {{ old('audience') === 'student' ? 'selected' : '' }}>دانش‌آموز
                                خاص
                            </option>
                        </select>
                    </div>

                    <!-- Schedule -->
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-clock me-2 text-warning"></i>زمان‌بندی (اختیاری)
                        </label>
                        <!-- Schedule_at -->
                        <input  type="datetime-local" class="form-control"
                               value="{{ old('send_at') }}">
                        <small class="text-muted">در صورت خالی بودن، پیام بلافاصله ارسال می‌شود،</small>
                        <small class="text-muted text-warning">این ویژگی هنوز فعال نشده است.</small>
                    </div>

                    <!-- Dynamic filters -->
                    <div class="col-12 audience-block audience-role d-none">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-user-shield me-2 text-warning"></i>انتخاب نقش
                        </label>
                        <select class="form-control" name="role_id">
                            @isset($data['roles'])
                                @foreach($data['roles'] as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="col-12 audience-block audience-school d-none">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-school me-2 text-warning"></i>انتخاب مدرسه
                        </label>
                        <select class="form-control" name="school_id">
                            @isset($data['schools'])
                                @foreach($data['schools'] as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="col-12 audience-block audience-student d-none">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-user-graduate me-2 text-warning"></i>انتخاب دانش‌آموز
                        </label>
                        <select class="form-control" name="student_id">
                            @isset($data['students'])
                                @foreach($data['students'] as $student)
                                    <option
                                        value="{{ $student->id }}">{{ $student->user->first_name . $student->user->last_name }}
                                        | {{ $student->school->name}} | {{ $student->user->phone }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <!-- Actions -->
                    <div class="col-12 mt-2">
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ url()->previous() }}" class="btn bg-danger btn-pill">
                                <i class="fa-solid fa-times me-2"></i>انصراف
                            </a>
                            <button type="submit" class="btn bg-warning btn-pill">
                                <i class="fa-solid fa-paper-plane me-2"></i>ارسال نوتیفیکیشن
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            (function () {
                const audienceSelect = document.getElementById('audience');
                const blocks = document.querySelectorAll('.audience-block');
                const map = {
                    role: '.audience-role',
                    school: '.audience-school',
                    class: '.audience-class',
                    student: '.audience-student',
                    custom: '.audience-custom'
                };

                function applyVisibility() {
                    blocks.forEach(b => b.classList.add('d-none'));
                    const val = audienceSelect.value;
                    if (map[val]) {
                        document.querySelector(map[val])?.classList.remove('d-none');
                    }
                }

                audienceSelect?.addEventListener('change', applyVisibility);
                applyVisibility();
            })();
        </script>
    @endpush
@endsection


