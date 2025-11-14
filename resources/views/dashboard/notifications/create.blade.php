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

        .template-card {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 10px;
        }

        .template-card:hover {
            border-color: #ffc107;
            background-color: #fff9e6;
        }

        .template-card.active {
            border-color: #ffc107;
            background-color: #fff9e6;
        }

        .smart-field-btn {
            margin: 3px;
            padding: 5px 10px;
            font-size: 12px;
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
    @if (session('error'))
        <div class="alert alert-danger animate__animated animate__fadeInDown">
            <i class="fa-solid fa-exclamation-triangle me-2"></i>{{ session('error') }}
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
                               value="{{ old('title') }}" required>
                    </div>

                    <!-- Channel -->
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-share-nodes me-2 text-warning"></i>کانال ارسال
                        </label>
                        <div class="d-flex flex-wrap gap-2">
                            <label class="option-chip">
                                <input type="checkbox" name="channels[]" value="sms"
                                       class="form-check-input me-1" {{ in_array('sms', (array) old('channels', ['sms'])) ? 'checked' : 'checked' }}>پیامک
                            </label>
                        </div>
                    </div>

                    <!-- Templates Section -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-file-lines me-2 text-warning"></i>قالب‌های آماده (اختیاری)
                        </label>
                        <div class="row g-2">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="template-card" data-template="absence">
                                    <strong><i class="fa-solid fa-user-slash me-2"></i>پیام غیبت</strong>
                                    <p class="mb-0 mt-2 small text-muted">دانش‌آموز گرامی {نام}، غیبت شما در تاریخ {تاریخ} ثبت شد.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="template-card" data-template="holiday">
                                    <strong><i class="fa-solid fa-calendar-xmark me-2"></i>اعلام تعطیلی</strong>
                                    <p class="mb-0 mt-2 small text-muted">با احترام، به اطلاع می‌رساند مدرسه {اسم مدرسه} در تاریخ {تاریخ} تعطیل است.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="template-card" data-template="meeting">
                                    <strong><i class="fa-solid fa-handshake me-2"></i>دعوت جلسه</strong>
                                    <p class="mb-0 mt-2 small text-muted">اولیای محترم، جلسه انجمن اولیا و مربیان در تاریخ {تاریخ} برگزار می‌شود.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="template-card" data-template="financial">
                                    <strong><i class="fa-solid fa-money-bill-wave me-2"></i>هشدار مالی</strong>
                                    <p class="mb-0 mt-2 small text-muted">اولیای محترم {نام}، لطفاً بدهی مالی خود را تسویه فرمایید.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="template-card" data-template="program">
                                    <strong><i class="fa-solid fa-calendar-check me-2"></i>اعلام برنامه جدید</strong>
                                    <p class="mb-0 mt-2 small text-muted">به اطلاع می‌رساند برنامه جدید مدرسه {اسم مدرسه} در تاریخ {تاریخ} اعلام می‌شود.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="template-card" data-template="congratulations">
                                    <strong><i class="fa-solid fa-gift me-2"></i>تبریک</strong>
                                    <p class="mb-0 mt-2 small text-muted">دانش‌آموز گرامی {نام}، {اسم مدرسه} تبریک می‌گوید.</p>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="template_id" id="template_id" value="{{ old('template_id') }}">
                    </div>

                    <!-- Message Editor -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-message me-2 text-warning"></i>متن پیام
                        </label>
                        <div class="mb-2">
                            <small class="text-muted">فیلدهای هوشمند: </small>
                            @if(isset($data['smartFields']))
                                @foreach($data['smartFields'] as $field => $label)
                                    <button type="button" class="btn btn-sm btn-outline-warning smart-field-btn"
                                            onclick="insertSmartField('{{ $field }}')">
                                        {{ $label }} ({{ $field }})
                                    </button>
                                @endforeach
                            @else
                                <button type="button" class="btn btn-sm btn-outline-warning smart-field-btn" onclick="insertSmartField('{نام}')">نام ({نام})</button>
                                <button type="button" class="btn btn-sm btn-outline-warning smart-field-btn" onclick="insertSmartField('{کلاس}')">کلاس ({کلاس})</button>
                                <button type="button" class="btn btn-sm btn-outline-warning smart-field-btn" onclick="insertSmartField('{تاریخ}')">تاریخ ({تاریخ})</button>
                                <button type="button" class="btn btn-sm btn-outline-warning smart-field-btn" onclick="insertSmartField('{اسم مدرسه}')">اسم مدرسه ({اسم مدرسه})</button>
                            @endif
                        </div>
                        <textarea name="message" id="message" rows="6" class="form-control"
                                  placeholder="متن نوتیفیکیشن را وارد کنید یا از قالب‌های آماده استفاده کنید...">{{ old('message') }}</textarea>
                        <small class="text-muted">حداکثر 1000 کاراکتر</small>
                    </div>

                    <!-- Audience selector -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-bullseye me-2 text-warning"></i>انتخاب گیرندگان
                        </label>
                        <select class="form-control" name="audience_data" id="audience" required>
                            <option value="">-- انتخاب کنید --</option>

                            <!-- Single Selection -->
                            <optgroup label="انتخاب تکی">
                                <option value="student" {{ old('audience_data') === 'student' ? 'selected' : '' }}>۱ دانش‌آموز</option>
                            </optgroup>

                            <!-- Multiple Selection -->
                            <optgroup label="انتخاب چندتایی">
                                <option value="multipleStudents" {{ old('audience_data') === 'multipleStudents' ? 'selected' : '' }}>چند دانش‌آموز انتخابی</option>
                            </optgroup>

                            <!-- Class & Grade -->
                            <optgroup label="کلاس و پایه">
                                <option value="class" {{ old('audience_data') === 'class' ? 'selected' : '' }}>یک کلاس</option>
                                <option value="studyBase" {{ old('audience_data') === 'studyBase' ? 'selected' : '' }}>یک پایه</option>
                            </optgroup>

                            <!-- School Wide -->
                            <optgroup label="مدرسه">
                                <option value="allSchool" {{ old('audience_data') === 'allSchool' ? 'selected' : '' }}>کل مدرسه</option>
                                <option value="allSchoolStudents" {{ old('audience_data') === 'allSchoolStudents' ? 'selected' : '' }}>کل دانش‌آموزان مدرسه</option>
                                <option value="allTeachers" {{ old('audience_data') === 'allTeachers' ? 'selected' : '' }}>کل معلمان</option>
                            </optgroup>

                            <!-- System Wide -->
                            <optgroup label="سیستم">
                                <option value="allUsers" {{ old('audience_data') === 'allUsers' ? 'selected' : '' }}>همه کاربران سیستم</option>
                                <option value="attendanceSchool" {{ old('audience_data') === 'attendanceSchool' ? 'selected' : '' }}>غایبین امروز</option>
                            </optgroup>
                        </select>
                    </div>

                    <!-- Dynamic filters based on audience -->
                    <div class="col-12 audience-block audience-student d-none">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-user-graduate me-2 text-warning"></i>انتخاب دانش‌آموز
                        </label>
                        <select class="form-control" name="student_id">
                            <option value="">-- انتخاب کنید --</option>
                            @isset($data['students'])
                                @foreach($data['students'] as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->user->first_name . ' ' . $student->user->last_name }}
                                        | {{ $student->school->name ?? '' }} | {{ $student->user->phone }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="col-12 audience-block audience-multipleStudents d-none">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-users me-2 text-warning"></i>انتخاب چند دانش‌آموز
                        </label>
                        <select class="form-control" name="student_ids[]" id="student_ids" multiple size="8">
                            @isset($data['students'])
                                @foreach($data['students'] as $student)
                                    <option value="{{ $student->id }}" {{ in_array($student->id, (array) old('student_ids', [])) ? 'selected' : '' }}>
                                        {{ $student->user->first_name . ' ' . $student->user->last_name }}
                                        | {{ $student->school->name ?? '' }} | {{ $student->user->phone }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <small class="text-muted">برای انتخاب چند مورد، کلید Ctrl (یا Cmd در Mac) را نگه دارید</small>
                    </div>

                    <div class="col-12 audience-block audience-class d-none">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-chalkboard me-2 text-warning"></i>انتخاب کلاس
                        </label>
                        <select class="form-control" name="class_id">
                            <option value="">-- انتخاب کنید --</option>
                            @isset($data['classes'])
                                @foreach($data['classes'] as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="col-12 audience-block audience-studyBase d-none">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-layer-group me-2 text-warning"></i>انتخاب پایه
                        </label>
                        <select class="form-control" name="study_base_id">
                            <option value="">-- انتخاب کنید --</option>
                            @isset($data['studyBases'])
                                @foreach($data['studyBases'] as $studyBase)
                                    <option value="{{ $studyBase->id }}" {{ old('study_base_id') == $studyBase->id ? 'selected' : '' }}>
                                        {{ $studyBase->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="col-12 audience-block audience-lowGradeStudents d-none">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-chart-line me-2 text-warning"></i>حداقل نمره
                        </label>
                        <input type="number" name="min_grade" class="form-control"
                               value="{{ old('min_grade', 10) }}" min="0" max="20" step="0.1"
                               placeholder="مثال: 10">
                        <small class="text-muted">دانش‌آموزانی که میانگین نمره آن‌ها کمتر از این مقدار است انتخاب می‌شوند</small>
                    </div>

                    <!-- Actions -->
                    <div class="col-12 mt-2">
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ url()->previous() }}" class="btn bg-danger btn-pill">
                                <i class="fa-solid fa-times me-2"></i>انصراف
                            </a>
                            <input type="submit" class="btn bg-warning btn-pill" value="ارسال نوتیف">
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
                    'student': '.audience-student',
                    'parent': '.audience-student',
                    'multipleStudents': '.audience-multipleStudents',
                    'class': '.audience-class',
                    'studyBase': '.audience-studyBase',
                    'lowGradeStudents': '.audience-lowGradeStudents'
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

                // Template selection
                const templateCards = document.querySelectorAll('.template-card');
                const messageTextarea = document.getElementById('message');
                const templateIdInput = document.getElementById('template_id');

                templateCards.forEach(card => {
                    card.addEventListener('click', function() {
                        // Remove active class from all cards
                        templateCards.forEach(c => c.classList.remove('active'));
                        // Add active class to clicked card
                        this.classList.add('active');

                        // Get template text
                        const templateText = this.querySelector('p').textContent;
                        messageTextarea.value = templateText;
                        templateIdInput.value = this.dataset.template;
                    });
                });

                // Smart field insertion
                window.insertSmartField = function(field) {
                    const textarea = document.getElementById('message');
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    const text = textarea.value;
                    const before = text.substring(0, start);
                    const after = text.substring(end, text.length);

                    textarea.value = before + field + after;
                    textarea.focus();
                    textarea.setSelectionRange(start + field.length, start + field.length);
                };
            })();
        </script>
    @endpush
@endsection
