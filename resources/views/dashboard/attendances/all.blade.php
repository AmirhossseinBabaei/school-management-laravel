@extends('dashboard.layouts.app')

@section('title', 'مدیریت حضور و غیاب دانش‌آموزان | سیستم مدیریت مدرسه')

@push('styles')
    <style>
        /* ====== Global Styles ====== */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            min-height: 100vh;
            font-family: "Vazirmatn", sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 1.5rem;
            transition: all 0.3s ease;
        }

        .glass-effect:hover {
            background: rgba(255, 255, 255, 0.18);
        }

        .hero {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            color: #fff;
            box-shadow: 0 4px 40px rgba(0, 0, 0, 0.15);
            animation: fadeDown 0.8s ease;
        }

        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .gradient-text {
            background: linear-gradient(90deg, #89f7fe, #66a6ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            animation: fadeUp 0.8s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background: linear-gradient(90deg, #764ba2, #667eea);
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            border-top-left-radius: 1.5rem;
            border-top-right-radius: 1.5rem;
        }

        /* ====== Buttons ====== */
        .btn-gradient {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: #fff;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #89f7fe, #66a6ff);
            box-shadow: 0 4px 12px rgba(102, 166, 255, 0.4);
            transform: translateY(-2px);
        }

        .status-btn {
            transition: all 0.25s ease;
            border-radius: 12px;
        }

        .status-btn.active {
            transform: scale(1.15);
            filter: brightness(1.1);
        }

        /* ====== Table ====== */
        .table {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            overflow: hidden;
            color: #fff;
        }

        .table thead {
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .table th {
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .table td {
            color: #f3f3f3;
        }

        .note {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: #fff;
            border-radius: 8px;
        }

        .note::placeholder {
            color: #ddd;
        }

        /* ====== Animations ====== */
        .fadeIn {
            animation: fadeIn 0.6s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .blur-bg {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(25px);
            border-radius: 15px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="container-fluid px-3 px-md-5 py-4">

        <!-- Hero -->
        <div class="hero glass-effect p-4 mb-4 shadow-lg">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="fw-bold mb-1 gradient-text">
                        <i class="fa-solid fa-user-check me-2"></i> سیستم حضور و غیاب دانش‌آموزان
                    </h2>
                    <p class="text-light mb-0 fs-6">ثبت، و بررسی حضور و غیاب روزانه</p>
                </div>
                <div class="text-end mt-3 mt-md-0">
                    <button class="btn btn-gradient px-4 py-2">
                        <i class="fa-solid fa-calendar-day"></i> امروز: {{ $data['nowDate'] }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Attendance Card -->
        <div class="card glass-effect text-white mt-4">
            <div class="card-header text-center">
                <i class="fa-solid fa-clipboard-user me-2"></i> مدیریت حضور و غیاب
            </div>

            <div class="card-body">

                <!-- Filters -->
                <div class="row g-4 align-items-end mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">کلاس</label>
                        @owner
                        <select id="classSelect" class="form-select">
                            <option value="">-- انتخاب کنید --</option>
                            @foreach($data['classes'] as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @endowner

                        @deputy
                        <select id="classSelect" class="form-select">
                            <option value="">-- انتخاب کنید --</option>
                            @foreach($data['classes'] as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @enddeputy

                        @teacher
                        <select id="classSelect" class="form-select">
                            <option value="">-- انتخاب کنید --</option>
                            @foreach($data['classes'] as $class)
                                <option value="{{ $class->classRoom->id }}">{{ $class->classRoom->name }}</option>
                            @endforeach
                        </select>
                        @endteacher
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">درس</label>

                        @owner
                        <select id="lessonSelect" class="form-select">
                            <option value="">-- انتخاب کنید --</option>
                            @foreach($data['lessons'] as $lesson)
                                <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                            @endforeach
                        </select>
                        @endowner

                        @deputy
                        <select id="lessonSelect" class="form-select">
                            <option value="">-- انتخاب کنید --</option>
                            @foreach($data['lessons'] as $lesson)
                                <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                            @endforeach
                        </select>
                        @enddeputy

                        @teacher
                        <select id="lessonSelect" class="form-select">
                            <option value="">-- انتخاب کنید --</option>
                            @foreach($data['lessons'] as $lesson)
                                <option value="{{ $lesson->lesson->id }}">{{ $lesson->lesson->name }}</option>
                            @endforeach
                        </select>
                        @endteacher

                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">تاریخ</label>
                        <input type="text" disabled name="date" value="{{ $data['nowDate'] }}" class="form-control">
                    </div>
                </div>

                <div class="text-center">
                    <button id="loadStudents" class="btn btn-gradient px-5 py-2 fw-bold">
                        <i class="fa-solid fa-list"></i> نمایش دانش‌آموزان
                    </button>
                </div>

                <!-- Attendance Table -->
                <div id="attendanceTableContainer" class="d-none mt-5 fadeIn">
                    <table class="table table-bordered text-center align-middle shadow-sm">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام دانش‌آموز</th>
                            <th>وضعیت</th>
                            <th>توضیح</th>
                        </tr>
                        </thead>
                        <tbody id="attendanceTableBody"></tbody>
                    </table>

                    <div class="text-end mt-4">
                        <button id="saveAttendance" class="btn btn-success px-5 py-2 shadow-lg fw-semibold">
                            <i class="fa-solid fa-floppy-disk"></i> ذخیره حضور و غیاب
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('loadStudents').addEventListener('click', async () => {
            const classId = document.getElementById('classSelect').value;

            if (!classId) {
                Swal.fire('توجه ⚠️', 'لطفاً کلاس را انتخاب کنید.', 'warning');
                return;
            }

            try {
                const res = await fetch(`attendances/students/${classId}`);
                const data = await res.json();

                if (data.status !== 1) throw new Error('خطا در دریافت داده‌ها');

                const tbody = document.getElementById('attendanceTableBody');
                tbody.innerHTML = '';

                data.students.forEach((student, index) => {
                    tbody.innerHTML += `
                    <tr data-id="${student.student_id}">
                        <td>${index + 1}</td>
                        <td>${student.first_name} ${student.last_name}</td>
                        <td>
                            <select name="status" class="form-select status">
                                <option value="present">حاضر ✅</option>
                                <option value="absent">غایب ❌</option>
                                <option value="late">موجه ⚠️</option>
                            </select>
                        </td>
                        <td><input name="description" type="text" class="form-control note" placeholder="توضیح (اختیاری)"></td>
                    </tr>
                `;
                });

                document.getElementById('attendanceTableContainer').classList.remove('d-none');
            } catch (err) {
                Swal.fire('خطا 💥', err.message, 'error');
            }
        });
    </script>
    <script>
        document.getElementById('saveAttendance').addEventListener('click', async () => {
            const classSelect = document.getElementById('classSelect');
            const lessonSelect = document.getElementById('lessonSelect');
            const date = "{{ $data['nowDate'] }}";

            const classId = classSelect.value;
            const lessonId = lessonSelect.value;

            if (!classId || !lessonId) {
                Swal.fire('توجه ⚠️', 'لطفاً کلاس و درس را انتخاب کنید.', 'warning');
                return;
            }

            // جمع‌آوری رکوردها
            const students = [];
            document.querySelectorAll('#attendanceTableBody tr').forEach(row => {
                const studentId = row.dataset.id;
                const statusSelect = row.querySelector('select[name="status"]');
                const status = statusSelect ? statusSelect.value : "present";
                const description = row.querySelector('input[name="description"]').value || '';
                students.push({ student_id: studentId, status, description });
            });

            if (students.length === 0) {
                Swal.fire('توجه ⚠️', 'هیچ دانش‌آموزی در لیست وجود ندارد.', 'info');
                return;
            }

            // ساخت FormData برای ارسال امن
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('class_id', classId);
            formData.append('lesson_id', lessonId);
            formData.append('date', date);

            students.forEach((student, index) => {
                formData.append(`students[${index}][student_id]`, student.student_id);
                formData.append(`students[${index}][status]`, student.status);
                formData.append(`students[${index}][description]`, student.description);
            });

            try {
                const response = await fetch(`{{ route('dashboard.attendances.store') }}`, {
                    method: "POST",
                    body: formData
                });

                const result = await response.json();

                if (result.status === 1) {
                    Swal.fire('موفقیت 🎉', 'اطلاعات حضور و غیاب با موفقیت ذخیره شد.', 'success');
                } else {
                    Swal.fire('خطا 💥', result.message || 'ذخیره‌سازی انجام نشد.', 'error');
                }
            } catch (error) {
                Swal.fire('خطای سرور 💥', 'ارتباط با سرور برقرار نشد.', 'error');
            }
        });
    </script>
@endpush




