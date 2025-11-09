@extends('dashboard.layouts.app')

@section('title', 'جستجوی غیبت دانش‌آموز با کد ملی | سیستم مدیریت مدرسه')

@push('styles')
    <style>
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

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            border-radius: 12px;
            padding: 12px 16px;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #89f7fe;
            box-shadow: 0 0 0 0.2rem rgba(137, 247, 254, 0.25);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

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

        .badge {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
        }

        .badge-absent {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .badge-present {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .badge-late {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .student-info-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
        }

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
                        <i class="fa-solid fa-search me-2"></i> جستجوی غیبت دانش‌آموز با کد ملی
                    </h2>
                    <p class="text-light mb-0 fs-6">جستجو و مدیریت غیبت‌های دانش‌آموزان</p>
                </div>
                <div class="text-end mt-3 mt-md-0">
                    <button class="btn btn-gradient px-4 py-2">
                        <i class="fa-solid fa-calendar-day"></i> امروز: {{ $data['nowDate'] }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Search Card -->
        <div class="card glass-effect text-white mb-4">
            <div class="card-header text-center">
                <i class="fa-solid fa-id-card me-2"></i> جستجو با کد ملی
            </div>
            <div class="card-body p-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold mb-2">
                            <i class="fa-solid fa-hashtag me-2"></i> کد ملی دانش‌آموز
                        </label>
                        <input 
                            type="text" 
                            id="nationalCodeInput" 
                            class="form-control" 
                            placeholder="کد ملی ۱۰ رقمی را وارد کنید"
                            maxlength="10"
                            pattern="[0-9]{10}"
                        >
                        <small class="text-light mt-1 d-block">کد ملی باید دقیقاً ۱۰ رقم باشد</small>
                    </div>
                    <div class="col-md-4">
                        <button 
                            type="button" 
                            id="searchBtn" 
                            class="btn btn-gradient w-100 py-3"
                        >
                            <i class="fa-solid fa-search me-2"></i> جستجو
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Spinner -->
        <div class="loading-spinner" id="loadingSpinner">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">در حال بارگذاری...</span>
            </div>
            <p class="text-light mt-3">در حال جستجو...</p>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Student Info Card -->
        <div id="studentInfoCard" class="student-info-card fadeIn" style="display: none;">
            <h4 class="text-white mb-3">
                <i class="fa-solid fa-user-graduate me-2"></i> اطلاعات دانش‌آموز
            </h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong class="text-light">نام و نام خانوادگی:</strong>
                    <p class="text-white mb-0" id="studentFullName">-</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-light">کد ملی:</strong>
                    <p class="text-white mb-0" id="studentNationalCode">-</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-light">کلاس:</strong>
                    <p class="text-white mb-0" id="studentClass">-</p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong class="text-light">تعداد کل غیبت‌ها:</strong>
                    <p class="text-white mb-0">
                        <span class="badge badge-absent" id="totalAbsences">0</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Absences Table -->
        <div id="absencesTableCard" class="card glass-effect text-white" style="display: none;">
            <div class="card-header text-center">
                <i class="fa-solid fa-calendar-times me-2"></i> لیست غیبت‌ها
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>تاریخ</th>
                                <th>ساعت</th>
                                <th>کلاس</th>
                                <th>درس</th>
                                <th>وضعیت</th>
                                <th>توضیحات</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody id="absencesTableBody">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Status Modal -->
    <div class="modal fade" id="editStatusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content glass-effect text-white" style="border: 1px solid rgba(255, 255, 255, 0.25);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(255, 255, 255, 0.2);">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-edit me-2"></i> تغییر وضعیت
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editAttendanceId">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">وضعیت</label>
                        <select id="editStatusSelect" class="form-select">
                            <option value="absent">غایب</option>
                            <option value="present">حاضر</option>
                            <option value="late">تأخیر</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">توضیحات (اختیاری)</label>
                        <textarea 
                            id="editDescription" 
                            class="form-control" 
                            rows="3" 
                            placeholder="توضیحات را وارد کنید..."
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.2);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                    <button type="button" class="btn btn-gradient" id="saveStatusBtn">
                        <i class="fa-solid fa-save me-2"></i> ذخیره تغییرات
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const searchBtn = document.getElementById('searchBtn');
        const nationalCodeInput = document.getElementById('nationalCodeInput');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const alertContainer = document.getElementById('alertContainer');
        const studentInfoCard = document.getElementById('studentInfoCard');
        const absencesTableCard = document.getElementById('absencesTableCard');
        const absencesTableBody = document.getElementById('absencesTableBody');

        // فقط اعداد را بپذیر
        nationalCodeInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // جستجو با Enter
        nationalCodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchBtn.click();
            }
        });

        // تابع نمایش پیام
        function showAlert(message, type = 'danger') {
            let icon = 'exclamation-circle';
            if (type === 'success') icon = 'check-circle';
            else if (type === 'info') icon = 'info-circle';
            
            alertContainer.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show fadeIn" role="alert">
                    <i class="fa-solid fa-${icon} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            setTimeout(() => {
                const alert = alertContainer.querySelector('.alert');
                if (alert) {
                    alert.classList.remove('show');
                }
            }, 5000);
        }

        // تابع جستجو
        searchBtn.addEventListener('click', function() {
            const nationalCode = nationalCodeInput.value.trim();

            if (nationalCode.length !== 10) {
                showAlert('لطفاً کد ملی ۱۰ رقمی را وارد کنید.', 'danger');
                return;
            }

            // نمایش loading
            loadingSpinner.style.display = 'block';
            studentInfoCard.style.display = 'none';
            absencesTableCard.style.display = 'none';
            alertContainer.innerHTML = '';

            // درخواست AJAX
            fetch('{{ route("dashboard.attendances.getStudentAbsences") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    national_code: nationalCode
                })
            })
            .then(response => response.json())
            .then(data => {
                loadingSpinner.style.display = 'none';

                if (data.status === 1) {
                    // نمایش اطلاعات دانش‌آموز
                    document.getElementById('studentFullName').textContent = data.student.full_name;
                    document.getElementById('studentNationalCode').textContent = data.student.national_code;
                    document.getElementById('studentClass').textContent = data.student.class_name;
                    document.getElementById('totalAbsences').textContent = data.total_absences;
                    studentInfoCard.style.display = 'block';

                    // نمایش جدول غیبت‌ها
                    if (data.absences.length > 0) {
                        absencesTableBody.innerHTML = '';
                        data.absences.forEach((absence, index) => {
                            const statusBadge = {
                                'absent': '<span class="badge badge-absent">غایب</span>',
                                'present': '<span class="badge badge-present">حاضر</span>',
                                'late': '<span class="badge badge-late">تأخیر</span>'
                            };

                            const row = `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${absence.date}</td>
                                    <td>${absence.date_time.split(' ')[1] || '-'}</td>
                                    <td>${absence.class_name}</td>
                                    <td>${absence.lesson_name}</td>
                                    <td>${statusBadge[absence.status] || absence.status}</td>
                                    <td>${absence.description || '-'}</td>
                                    <td>
                                        <button 
                                            class="btn btn-sm btn-gradient" 
                                            onclick="editAttendance(${absence.id}, '${absence.status}', '${(absence.description || '').replace(/'/g, "\\'")}')"
                                        >
                                            <i class="fa-solid fa-edit"></i> ویرایش
                                        </button>
                                    </td>
                                </tr>
                            `;
                            absencesTableBody.innerHTML += row;
                        });
                        absencesTableCard.style.display = 'block';
                    } else {
                        showAlert('این دانش‌آموز غیبتی ندارد.', 'info');
                    }
                } else {
                    showAlert(data.message || 'خطایی رخ داد.', 'danger');
                }
            })
            .catch(error => {
                loadingSpinner.style.display = 'none';
                showAlert('خطا در ارتباط با سرور. لطفاً دوباره تلاش کنید.', 'danger');
                console.error('Error:', error);
            });
        });

        // تابع ویرایش وضعیت
        function editAttendance(id, status, description) {
            document.getElementById('editAttendanceId').value = id;
            document.getElementById('editStatusSelect').value = status;
            document.getElementById('editDescription').value = description || '';
            
            const modal = new bootstrap.Modal(document.getElementById('editStatusModal'));
            modal.show();
        }

        // ذخیره تغییرات
        document.getElementById('saveStatusBtn').addEventListener('click', function() {
            const attendanceId = document.getElementById('editAttendanceId').value;
            const status = document.getElementById('editStatusSelect').value;
            const description = document.getElementById('editDescription').value;

            fetch('{{ route("dashboard.attendances.updateStatus") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    attendance_id: attendanceId,
                    status: status,
                    description: description
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 1) {
                    bootstrap.Modal.getInstance(document.getElementById('editStatusModal')).hide();
                    showAlert(data.message, 'success');
                    // جستجوی مجدد
                    setTimeout(() => {
                        searchBtn.click();
                    }, 1000);
                } else {
                    showAlert(data.message || 'خطا در به‌روزرسانی وضعیت.', 'danger');
                }
            })
            .catch(error => {
                showAlert('خطا در ارتباط با سرور.', 'danger');
                console.error('Error:', error);
            });
        });
    </script>
@endsection

