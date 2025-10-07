@extends('dashboard.layouts.app')

@section('title', 'مدیریت حضور و غیاب دانش‌آموزان | سیستم مدیریت مدرسه')

@push('styles')
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .bg-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .status-btn.active {
            transform: scale(1.1);
        }
    </style>
@endpush

@section('content')
    <!-- Hero -->
    <div class="hero glass-effect p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3 class="fw-bold mb-1 gradient-text">
                    <i class="fa-solid fa-user-check me-2"></i>مدیریت حضور و غیاب دانش‌آموزان
                </h3>
                <p class="text-muted mb-0">ثبت، ویرایش و بررسی وضعیت حضور و غیاب روزانه</p>
            </div>
        </div>
    </div>

    <!-- Attendance Card -->
    <div class="card shadow-lg border-0 rounded-4 glass-effect">
        <div class="card-header bg-gradient fw-bold text-white text-center">
            <i class="fa-solid fa-user-check me-2"></i> حضور و غیاب دانش‌آموزان
        </div>

        <div class="card-body">

            <!-- Filters -->
            <div class="row g-3 align-items-end mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">انتخاب کلاس</label>
                    <select id="classSelect" class="form-select">
                        <option value="">-- انتخاب کنید --</option>
                        @foreach($data['classes'] as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">تاریخ</label>
                    <input type="date" id="attendanceDate" class="form-control">
                </div>

                <div class="col-md-4 text-end">
                    <button id="loadStudents" class="btn btn-primary w-100">
                        <i class="fa-solid fa-list"></i> نمایش لیست دانش‌آموزان
                    </button>
                </div>
            </div>

            <!-- Attendance Table -->
            <div id="attendanceTableContainer" class="d-none">
                <table class="table table-bordered text-center align-middle shadow-sm">
                    <thead class="bg-dark text-white">
                    <tr>
                        <th>#</th>
                        <th>نام دانش‌آموز</th>
                        <th>وضعیت</th>
                        <th>توضیح</th>
                    </tr>
                    </thead>
                    <tbody id="attendanceTableBody"></tbody>
                </table>

                <div class="text-end mt-3">
                    <button id="saveAttendance" class="btn btn-success px-4">
                        <i class="fa-solid fa-save"></i> ذخیره حضور و غیاب
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
            crossorigin="anonymous"></script>

    <script>
        const attendanceData = [];

        // Load students for selected class
        $('#loadStudents').on('click', function () {
            const classId = $('#classSelect').val();
            const date = $('#attendanceDate').val();

            if (!classId || !date) {
                alert('لطفاً کلاس و تاریخ را انتخاب کنید.');
                return;
            }

            $.ajax({
                url: "{{ route('dashboard.attendance.students') }}",
                method: "GET",
                data: {class_id: classId},
                success: function (response) {
                    const students = response.students;
                    const tbody = $('#attendanceTableBody');
                    tbody.empty();

                    students.forEach((student, index) => {
                        tbody.append(`
                        <tr data-id="${student.id}">
                            <td>${index + 1}</td>
                            <td>${student.first_name} ${student.last_name}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-outline-success status-btn" data-status="present">✅</button>
                                    <button class="btn btn-outline-danger status-btn" data-status="absent">❌</button>
                                    <button class="btn btn-outline-warning status-btn" data-status="late">⏰</button>
                                </div>
                            </td>
                            <td><input type="text" class="form-control note" placeholder="توضیح..." /></td>
                        </tr>
                    `);
                    });

                    $('#attendanceTableContainer').removeClass('d-none');
                },
                error: function () {
                    alert('خطا در دریافت لیست دانش‌آموزان');
                }
            });
        });

        // Select attendance status
        $(document).on('click', '.status-btn', function () {
            const btn = $(this);
            const row = btn.closest('tr');
            const status = btn.data('status');

            row.find('.status-btn')
                .removeClass('btn-success btn-danger btn-warning text-white')
                .addClass('btn-outline-success btn-outline-danger btn-outline-warning');

            if (status === 'present') btn.addClass('btn-success text-white');
            if (status === 'absent') btn.addClass('btn-danger text-white');
            if (status === 'late') btn.addClass('btn-warning text-white');

            row.data('status', status);
        });

        // Save attendance
        $('#saveAttendance').on('click', function () {
            const classId = $('#classSelect').val();
            const date = $('#attendanceDate').val();
            const records = [];

            $('#attendanceTableBody tr').each(function () {
                const studentId = $(this).data('id');
                const status = $(this).data('status') || null;
                const note = $(this).find('.note').val();

                if (status) {
                    records.push({
                        student_id: studentId,
                        status: status,
                        note: note
                    });
                }
            });

            if (records.length === 0) {
                alert('هیچ داده‌ای انتخاب نشده.');
                return;
            }

            $.ajax({
                url: "{{ route('dashboard.attendance.store') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    class_id: classId,
                    date: date,
                    records: records
                },
                success: function (response) {
                    if (response.status === 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'با موفقیت ذخیره شد 🎉',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطا در ذخیره‌سازی',
                            text: response.message || 'خطای ناشناخته'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطای سرور',
                        text: 'ارتباط با سرور برقرار نشد'
                    });
                }
            });
        });
    </script>
@endpush
