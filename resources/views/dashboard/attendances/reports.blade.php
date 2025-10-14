@extends('dashboard.layouts.app')

@section('title', 'گزارش غایبان | سیستم مدیریت مدرسه')

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

        .btn-success {
            background: linear-gradient(135deg, #56ab2f, #a8e6cf);
            border: none;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            border: none;
        }

        .btn-info {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            border: none;
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

        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* ====== Form Controls ====== */
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            border-radius: 8px;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #66a6ff;
            box-shadow: 0 0 0 0.2rem rgba(102, 166, 255, 0.25);
            color: #fff;
        }

        .form-control::placeholder {
            color: #ddd;
        }

        .form-label {
            color: #fff;
            font-weight: 600;
        }

        /* ====== Stats Cards ====== */
        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            color: #fff;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* ====== Charts ====== */
        .chart-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        /* ====== Loading ====== */
        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #66a6ff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ====== Button Loading States ====== */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
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

        .no-data {
            text-align: center;
            padding: 3rem;
            color: #fff;
            opacity: 0.7;
        }
        .btn-pill {
            border-radius: 25px;
        }

        /* Persian Date Picker Styles */
        .persian-datepicker {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .persian-datepicker-input {
            width: 100%;
            padding: 12px 45px 12px 15px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .persian-datepicker-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
            background: rgba(255, 255, 255, 0.15);
        }

        .persian-datepicker-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .persian-datepicker-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #007bff;
            font-size: 16px;
            pointer-events: none;
            z-index: 2;
        }

        .persian-datepicker-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: rgba(22, 24, 29, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            margin-top: 5px;
            overflow: hidden;
            animation: fadeInUp 0.3s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .persian-datepicker-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            padding: 15px;
            text-align: center;
            color: white;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .persian-datepicker-nav {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .persian-datepicker-nav:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .persian-datepicker-title {
            font-size: 16px;
            font-weight: 600;
        }

        .persian-datepicker-body {
            padding: 15px;
        }

        .persian-datepicker-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-bottom: 10px;
        }

        .persian-datepicker-weekday {
            text-align: center;
            padding: 8px;
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        .persian-datepicker-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .persian-datepicker-day {
            text-align: center;
            padding: 10px 5px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid transparent;
        }

        .persian-datepicker-day:hover {
            background: rgba(0, 123, 255, 0.3);
            border-color: #007bff;
            transform: scale(1.05);
        }

        .persian-datepicker-day.selected {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
        }

        .persian-datepicker-day.other-month {
            color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.02);
        }

        .persian-datepicker-day.today {
            background: rgba(40, 167, 69, 0.3);
            border-color: #28a745;
            color: #28a745;
            font-weight: bold;
        }

        .persian-datepicker-footer {
            padding: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .persian-datepicker-btn {
            flex: 1;
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .persian-datepicker-btn-clear {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .persian-datepicker-btn-clear:hover {
            background: rgba(220, 53, 69, 0.3);
            transform: translateY(-1px);
        }

        .persian-datepicker-btn-today {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .persian-datepicker-btn-today:hover {
            background: rgba(40, 167, 69, 0.3);
            transform: translateY(-1px);
        }

        .persian-datepicker-btn-close {
            background: rgba(108, 117, 125, 0.2);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        .persian-datepicker-btn-close:hover {
            background: rgba(108, 117, 125, 0.3);
            transform: translateY(-1px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .persian-datepicker-dropdown {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 90%;
                max-width: 350px;
            }

            .persian-datepicker-day {
                padding: 8px 3px;
                font-size: 12px;
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
                        <i class="fa-solid fa-chart-line me-2"></i> گزارش‌گیری غایبان
                    </h2>
                    <p class="text-light mb-0 fs-6">بررسی و تحلیل آمار حضور و غیاب دانش‌آموزان</p>
                </div>
                <div class="text-end mt-3 mt-md-0">
                    <button class="btn btn-gradient px-4 py-2" onclick="showCharts()">
                        <i class="fa-solid fa-chart-pie"></i> نمایش چارت‌ها
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="card glass-effect text-white mb-4">
            <div class="card-header text-center">
                <i class="fa-solid fa-filter me-2"></i> فیلترهای جستجو
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="form-label">کلاس</label>
                        <select id="classFilter" class="form-select">
                            <option name="lesson" value="all">همه کلاس‌ها</option>
                            @foreach($data['classes'] as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">درس</label>
                        <select name="lesson" id="lessonFilter" class="form-select">
                            <option value="all">همه دروس</option>
                            @foreach($data['lessons'] as $lesson)
                                <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">از تاریخ</label>
                        <div class="persian-datepicker">
                            <input type="text" id="from-date-picker" name="from_date" class="persian-datepicker-input"
                                   placeholder="روز/ماه/سال" value="{{ old('from_date') }}" readonly>
                            <i class="fa-solid fa-calendar persian-datepicker-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">تا تاریخ</label>
                        <div class="persian-datepicker">
                            <input type="text" id="to-date-picker" name="to_date" class="persian-datepicker-input"
                                   placeholder="روز/ماه/سال" value="{{ old('to_date') }}" readonly>
                            <i class="fa-solid fa-calendar persian-datepicker-icon"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">وضعیت</label>
                        <select name="status" id="statusFilter" class="form-select">
                            <option value="all">همه</option>
                            <option value="present">حاضرین</option>
                            <option value="absent">غایبین</option>
                            <option value="late">تاخیری ها</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button id="searchBtn" class="btn btn-gradient w-100">
                            <i class="fa-solid fa-search"></i> جستجو
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4" id="statsContainer">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number text-success" id="totalAbsent">0</div>
                    <div class="stat-label">کل غایبان</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number text-warning" id="totalLate">0</div>
                    <div class="stat-label">کل تاخیرها</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number text-info" id="totalPresent">0</div>
                    <div class="stat-label">کل حاضرین</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-number text-primary" id="attendanceRate">0%</div>
                    <div class="stat-label">نرخ حضور</div>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="card glass-effect text-white">
            <div class="card-header text-center">
                <i class="fa-solid fa-table me-2"></i> نتایج جستجو
            </div>
            <div class="card-body">
                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    <p class="mt-3">در حال بارگذاری...</p>
                </div>

                <div id="resultsContainer" class="d-none">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام دانش‌آموز</th>
                                    <th>کلاس</th>
                                    <th>درس</th>
                                    <th>تاریخ</th>
                                    <th>وضعیت</th>
                                    <th>توضیح</th>
                                </tr>
                            </thead>
                            <tbody id="resultsTableBody">
                                <!-- نتایج از AJAX لود می‌شوند -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="noData" class="no-data d-none">
                    <i class="fa-solid fa-search fa-3x mb-3"></i>
                    <h5>هیچ داده‌ای یافت نشد</h5>
                    <p>لطفاً فیلترهای جستجو را تغییر دهید</p>
                </div>
            </div>
        </div>

        <!-- Charts Modal -->
        <div class="modal fade" id="chartsModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content glass-effect text-white">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa-solid fa-chart-pie me-2"></i> چارت‌های آماری
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h6 class="text-center mb-3">نمودار وضعیت حضور</h6>
                                    <canvas id="statusChart" width="400" height="300"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h6 class="text-center mb-3">نمودار غیبت بر اساس کلاس</h6>
                                    <canvas id="classChart" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h6 class="text-center mb-3">نمودار غیبت بر اساس درس</h6>
                                    <canvas id="lessonChart" width="400" height="300"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="chart-container">
                                    <h6 class="text-center mb-3">نمودار روند زمانی</h6>
                                    <canvas id="trendChart" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let statusChart, classChart, lessonChart, trendChart;
        let currentData = null; // ذخیره داده‌های فعلی

        document.addEventListener('DOMContentLoaded', function() {
            setupEventListeners();
        });

        function setupEventListeners() {
            document.getElementById('searchBtn').addEventListener('click', searchAttendance);
        }

        // جستجوی حضور و غیاب
        async function searchAttendance() {
            // تست ساده اول
            console.log('Search button clicked!');

            const filters = {
                class_id: document.getElementById('classFilter').value,
                lesson_id: document.getElementById('lessonFilter').value,
                from_date: document.getElementById('from-date-picker').value,
                to_date: document.getElementById('to-date-picker').value,
                status: document.querySelector('select[name="status"]').value
            };

            console.log('Filters:', filters);

            // اعتبارسنجی فیلدهای اجباری
            if (!filters.from_date || !filters.to_date) {
                Swal.fire('توجه ⚠️', 'لطفاً تاریخ از و تا را انتخاب کنید.', 'warning');
                return;
            }

            // نمایش loading با پیام مناسب
            showLoadingWithMessage('در حال بررسی داده‌ها...');

            // غیرفعال کردن دکمه جستجو
            const searchBtn = document.getElementById('searchBtn');
            searchBtn.disabled = true;
            searchBtn.classList.add('btn-loading');
            searchBtn.innerHTML = 'در حال جستجو...';

            try {
                // ایجاد FormData
                const formData = new FormData();
                formData.append('class_id', filters.class_id);
                formData.append('lesson_id', filters.lesson_id);
                formData.append('from_date', filters.from_date);
                formData.append('to_date', filters.to_date);
                formData.append('status', filters.status);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                console.log('Sending FormData...');

                // استفاده از fetch API به جای XMLHttpRequest
                const response = await fetch(`{{ url('dashboard/get-attendance-students-data') }}`, {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                console.log('Response status:', response);

                if (response.ok) {
                    const data = await response.json();
                    console.log('Received data:', data);

                    displayResults(data);
                    updateStats(data);

                    Swal.fire({
                        icon: 'success',
                        title: 'موفقیت!',
                        text: `تعداد ${data.data ? data.data.length : 0} رکورد یافت شد`,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    console.error('HTTP Error:', response.status, response.statusText);
                    const errorText = await response.text();
                    console.log('Error response:', errorText);
                    Swal.fire('خطا', `خطای HTTP: ${response.status} - ${response.statusText}`, 'error');
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                Swal.fire('خطا', 'خطا در ارسال درخواست: ' + error.message, 'error');
            } finally {
                // بازگرداندن وضعیت دکمه
                showLoading(false);
                searchBtn.disabled = false;
                searchBtn.classList.remove('btn-loading');
                searchBtn.innerHTML = '<i class="fa-solid fa-search"></i> جستجو';
            }
        }

        // نمایش نتایج واقعی
        function displayResults(data) {
            currentData = data; // ذخیره داده‌های فعلی

            const tbody = document.getElementById('resultsTableBody');
            tbody.innerHTML = '';

            if (!data || !data.data || data.data.length === 0) {
                document.getElementById('resultsContainer').classList.add('d-none');
                document.getElementById('noData').classList.remove('d-none');
                return;
            }

            data.data.forEach((item, index) => {
                // تبدیل وضعیت انگلیسی به فارسی
                let statusText = '';
                let statusClass = '';

                switch(item.status) {
                    case 'present':
                        statusText = 'حاضر';
                        statusClass = 'text-success';
                        break;
                    case 'absent':
                        statusText = 'غایب';
                        statusClass = 'text-danger';
                        break;
                    case 'late':
                        statusText = 'تاخیر';
                        statusClass = 'text-warning';
                        break;
                    default:
                        statusText = item.status;
                        statusClass = 'text-info';
                }

                // تبدیل تاریخ میلادی به شمسی برای نمایش
                const persianDate = convertToPersianDate(item.created_at);

                tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.student_id ? item.studentName : 'نامشخص'}</td>
                        <td>${item.classRoom ? item.classRoom.name : 'نامشخص'}</td>
                        <td>${item.lesson ? item.lesson.name : 'نامشخص'}</td>
                        <td>${persianDate}</td>
                        <td><span class="${statusClass}">${statusText}</span></td>
                        <td>${item.description || '-'}</td>
                    </tr>
                `;
            });

            document.getElementById('resultsContainer').classList.remove('d-none');
            document.getElementById('noData').classList.add('d-none');
        }

        // تبدیل تاریخ میلادی به شمسی
        function convertToPersianDate(gregorianDate) {
            if (!gregorianDate) return '-';

            const date = new Date(gregorianDate);

            // تبدیل ساده میلادی به شمسی
            const persianEpoch = new Date(622, 2, 22); // March 22, 622 AD
            const diffTime = date.getTime() - persianEpoch.getTime();
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

            // محاسبه سال شمسی
            let pYear = Math.floor(diffDays / 365.25) + 1;
            let remainingDays = diffDays - Math.floor((pYear - 1) * 365.25);

            // ماه‌های شمسی
            const persianMonths = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];

            // بررسی سال کبیسه
            if (isPersianLeapYear(pYear)) {
                persianMonths[11] = 30;
            }

            let pMonth = 1;
            let pDay = 1;

            // پیدا کردن ماه و روز
            for (let i = 0; i < 12; i++) {
                if (remainingDays >= persianMonths[i]) {
                    remainingDays -= persianMonths[i];
                    pMonth++;
                } else {
                    pDay = remainingDays + 1;
                    break;
                }
            }

            return `${pDay}/${pMonth}/${pYear}`;
        }

        // بررسی سال کبیسه شمسی
        function isPersianLeapYear(year) {
            const a = (year + 2346) % 128;
            return a < 29 || (a === 29 && (year + 2346) % 128 < 29);
        }

        // آپدیت آمار واقعی
        function updateStats(data) {
            if (!data || !data.data) {
                document.getElementById('totalAbsent').textContent = '0';
                document.getElementById('totalLate').textContent = '0';
                document.getElementById('totalPresent').textContent = '0';
                document.getElementById('attendanceRate').textContent = '0%';
                return;
            }

            const attendances = data.data;
            let presentCount = 0;
            let absentCount = 0;
            let lateCount = 0;

            attendances.forEach(item => {
                switch(item.status) {
                    case 'present':
                        presentCount++;
                        break;
                    case 'absent':
                        absentCount++;
                        break;
                    case 'late':
                        lateCount++;
                        break;
                }
            });

            const total = presentCount + absentCount + lateCount;
            const attendanceRate = total > 0 ? Math.round((presentCount / total) * 100) : 0;

            document.getElementById('totalAbsent').textContent = absentCount;
            document.getElementById('totalLate').textContent = lateCount;
            document.getElementById('totalPresent').textContent = presentCount;
            document.getElementById('attendanceRate').textContent = attendanceRate + '%';
        }

        // نمایش/مخفی کردن loading
        function showLoading(show) {
            const loading = document.getElementById('loading');
            const results = document.getElementById('resultsContainer');
            const noData = document.getElementById('noData');

            if (show) {
                loading.classList.remove('d-none');
                results.classList.add('d-none');
                noData.classList.add('d-none');
            } else {
                loading.classList.add('d-none');
            }
        }

        // نمایش loading با پیام سفارشی
        function showLoadingWithMessage(message) {
            const loading = document.getElementById('loading');
            const results = document.getElementById('resultsContainer');
            const noData = document.getElementById('noData');

            // تغییر متن loading
            const loadingText = loading.querySelector('p');
            if (loadingText) {
                loadingText.textContent = message;
            }

            loading.classList.remove('d-none');
            results.classList.add('d-none');
            noData.classList.add('d-none');
        }

        // نمایش چارت‌ها
        function showCharts() {
            const modal = new bootstrap.Modal(document.getElementById('chartsModal'));
            modal.show();

            // نمایش loading در modal
            const modalBody = document.querySelector('#chartsModal .modal-body');
            const originalContent = modalBody.innerHTML;

            modalBody.innerHTML = `
                <div class="text-center text-white py-5">
                    <div class="spinner mb-3"></div>
                    <h5>در حال بارگذاری چارت‌ها...</h5>
                    <p class="text-white-50">لطفاً صبر کنید</p>
                </div>
            `;

            // اگر داده‌ای موجود است، مستقیماً چارت‌ها را ایجاد کن
            if (currentData) {
                setTimeout(() => {
                    modalBody.innerHTML = originalContent;
                    createStatusChart(currentData);
                    createClassChart(currentData);
                    createLessonChart(currentData);
                    createTrendChart(currentData);
                }, 500);
            } else {
                // اگر داده‌ای نیست، پیام مناسب نمایش بده
                setTimeout(() => {
                    modalBody.innerHTML = `
                        <div class="text-center text-white py-5">
                            <i class="fa-solid fa-chart-line fa-3x mb-3 text-muted"></i>
                            <h5>هیچ داده‌ای برای نمایش وجود ندارد</h5>
                            <p class="text-white-50">ابتدا جستجو کنید تا چارت‌ها نمایش داده شوند</p>
                        </div>
                    `;
                }, 500);
            }
        }

        // چارت وضعیت حضور
        function createStatusChart(data = null) {
            const ctx = document.getElementById('statusChart').getContext('2d');
            if (statusChart) statusChart.destroy();

            let presentCount = 0;
            let absentCount = 0;
            let lateCount = 0;

            if (data && data.data) {
                data.data.forEach(item => {
                    switch(item.status) {
                        case 'present':
                            presentCount++;
                            break;
                        case 'absent':
                            absentCount++;
                            break;
                        case 'late':
                            lateCount++;
                            break;
                    }
                });
            } else {
                // داده‌های پیش‌فرض
                presentCount = 120;
                absentCount = 15;
                lateCount = 8;
            }

            statusChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['حاضر', 'غایب', 'تاخیر'],
                    datasets: [{
                        data: [presentCount, absentCount, lateCount],
                        backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#fff'
                            }
                        }
                    }
                }
            });
        }

        // چارت غیبت بر اساس کلاس
        function createClassChart() {
            const ctx = document.getElementById('classChart').getContext('2d');
            if (classChart) classChart.destroy();

            classChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['کلاس اول', 'کلاس دوم', 'کلاس سوم'],
                    datasets: [{
                        label: 'تعداد غایبان',
                        data: [5, 7, 3],
                        backgroundColor: 'rgba(220, 53, 69, 0.8)',
                        borderColor: 'rgba(220, 53, 69, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#fff'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#fff'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#fff'
                            }
                        }
                    }
                }
            });
        }

        // چارت غیبت بر اساس درس
        function createLessonChart() {
            const ctx = document.getElementById('lessonChart').getContext('2d');
            if (lessonChart) lessonChart.destroy();

            lessonChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['ریاضی', 'علوم', 'فارسی', 'انگلیسی'],
                    datasets: [{
                        data: [6, 4, 3, 2],
                        backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#fff'
                            }
                        }
                    }
                }
            });
        }

        // چارت روند زمانی
        function createTrendChart() {
            const ctx = document.getElementById('trendChart').getContext('2d');
            if (trendChart) trendChart.destroy();

            trendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['هفته 1', 'هفته 2', 'هفته 3', 'هفته 4'],
                    datasets: [{
                        label: 'غایبان',
                        data: [12, 19, 15, 8],
                        borderColor: 'rgba(220, 53, 69, 1)',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.4
                    }, {
                        label: 'تاخیرها',
                        data: [5, 8, 6, 4],
                        borderColor: 'rgba(255, 193, 7, 1)',
                        backgroundColor: 'rgba(255, 193, 7, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#fff'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#fff'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#fff'
                            }
                        }
                    }
                }
            });
        }
    </script>
    <script>
        class PersianDatePicker {
            constructor(inputId) {
                this.input = document.getElementById(inputId);
                this.dropdown = null;
                this.currentDate = new Date();
                this.selectedDate = null;
                this.isOpen = false;

                this.init();
            }

            init() {
                this.createDropdown();
                this.bindEvents();
                this.updateInput();
            }

            createDropdown() {
                this.dropdown = document.createElement('div');
                this.dropdown.className = 'persian-datepicker-dropdown';
                this.dropdown.style.display = 'none';

                this.dropdown.innerHTML = `
            <div class="persian-datepicker-header">
                <button class="persian-datepicker-nav" data-action="prev-month">‹</button>
                <div class="persian-datepicker-title"></div>
                <button class="persian-datepicker-nav" data-action="next-month">›</button>
            </div>
            <div class="persian-datepicker-body">
                <div class="persian-datepicker-weekdays">
                    <div class="persian-datepicker-weekday">ش</div>
                    <div class="persian-datepicker-weekday">ی</div>
                    <div class="persian-datepicker-weekday">د</div>
                    <div class="persian-datepicker-weekday">س</div>
                    <div class="persian-datepicker-weekday">چ</div>
                    <div class="persian-datepicker-weekday">پ</div>
                    <div class="persian-datepicker-weekday">ج</div>
                </div>
                <div class="persian-datepicker-days"></div>
            </div>
            <div class="persian-datepicker-footer">
                <button class="persian-datepicker-btn persian-datepicker-btn-clear">پاک کردن</button>
                <button class="persian-datepicker-btn persian-datepicker-btn-today">امروز</button>
                <button class="persian-datepicker-btn persian-datepicker-btn-close">بستن</button>
            </div>
        `;

                document.body.appendChild(this.dropdown);
            }

            bindEvents() {
                this.input.addEventListener('click', () => this.toggle());

                this.dropdown.addEventListener('click', (e) => {
                    if (e.target.classList.contains('persian-datepicker-day')) {
                        this.selectDate(e.target.dataset.date);
                    } else if (e.target.classList.contains('persian-datepicker-nav')) {
                        if (e.target.dataset.action === 'prev-month') {
                            this.previousMonth();
                        } else if (e.target.dataset.action === 'next-month') {
                            this.nextMonth();
                        }
                    } else if (e.target.classList.contains('persian-datepicker-btn-clear')) {
                        this.clearDate();
                    } else if (e.target.classList.contains('persian-datepicker-btn-today')) {
                        this.selectToday();
                    } else if (e.target.classList.contains('persian-datepicker-btn-close')) {
                        this.close();
                    }
                });

                document.addEventListener('click', (e) => {
                    if (!this.input.contains(e.target) && !this.dropdown.contains(e.target)) {
                        this.close();
                    }
                });
            }

            toggle() {
                if (this.isOpen) {
                    this.close();
                } else {
                    this.open();
                }
            }

            open() {
                this.isOpen = true;
                this.updateCalendar();
                this.positionDropdown();
                this.dropdown.style.display = 'block';
            }

            close() {
                this.isOpen = false;
                this.dropdown.style.display = 'none';
            }

            positionDropdown() {
                const rect = this.input.getBoundingClientRect();
                this.dropdown.style.position = 'absolute';
                this.dropdown.style.top = (rect.bottom + window.scrollY + 5) + 'px';
                this.dropdown.style.left = rect.left + 'px';
                this.dropdown.style.width = rect.width + 'px';
            }

            updateCalendar() {
                const title = this.dropdown.querySelector('.persian-datepicker-title');
                const daysContainer = this.dropdown.querySelector('.persian-datepicker-days');

                // Persian month names
                const persianMonths = [
                    'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور',
                    'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'
                ];

                // Convert current date to Persian
                const persianCurrent = this.toPersianDate(this.currentDate);
                const persianYear = persianCurrent.year;
                const persianMonth = persianCurrent.month - 1; // 0-based index

                title.textContent = `${persianMonths[persianMonth]} ${persianYear}`;

                // Persian month days
                const persianMonthDays = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];
                if (this.isPersianLeapYear(persianYear)) {
                    persianMonthDays[11] = 30; // Esfand has 30 days in leap year
                }

                const daysInMonth = persianMonthDays[persianMonth];

                // Calculate first day of month in Persian calendar
                const firstDayOfMonth = this.getPersianFirstDayOfWeek(persianYear, persianMonth);

                daysContainer.innerHTML = '';

                // Previous month days
                const prevMonth = persianMonth === 0 ? 11 : persianMonth - 1;
                const prevYear = persianMonth === 0 ? persianYear - 1 : persianYear;
                const prevMonthDays = persianMonth === 0 ? persianMonthDays[11] : persianMonthDays[prevMonth];

                for (let i = firstDayOfMonth - 1; i >= 0; i--) {
                    const day = prevMonthDays - i;
                    const dayElement = this.createDayElement(day, true);
                    daysContainer.appendChild(dayElement);
                }

                // Current month days
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayElement = this.createDayElement(day, false);
                    const dateStr = `${persianYear}-${String(persianMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    dayElement.dataset.date = dateStr;

                    // Check if this is selected date
                    if (this.selectedDate) {
                        const selectedPersian = this.toPersianDate(this.selectedDate);
                        if (selectedPersian.year === persianYear &&
                            selectedPersian.month === persianMonth + 1 &&
                            selectedPersian.day === day) {
                            dayElement.classList.add('selected');
                        }
                    }

                    // Check if this is today
                    const todayPersian = this.toPersianDate(new Date());
                    if (todayPersian.year === persianYear &&
                        todayPersian.month === persianMonth + 1 &&
                        todayPersian.day === day) {
                        dayElement.classList.add('today');
                    }

                    daysContainer.appendChild(dayElement);
                }

                // Next month days
                const remainingDays = 42 - (firstDayOfMonth + daysInMonth);
                for (let day = 1; day <= remainingDays; day++) {
                    const dayElement = this.createDayElement(day, true);
                    daysContainer.appendChild(dayElement);
                }
            }

            createDayElement(day, isOtherMonth) {
                const dayElement = document.createElement('div');
                dayElement.className = 'persian-datepicker-day';
                if (isOtherMonth) {
                    dayElement.classList.add('other-month');
                }
                dayElement.textContent = day;
                return dayElement;
            }

            selectDate(dateStr) {
                const [year, month, day] = dateStr.split('-').map(Number);
                // Convert Persian date to Gregorian
                this.selectedDate = this.persianToGregorian(year, month, day);
                this.updateInput();
                this.close();
            }

            clearDate() {
                this.selectedDate = null;
                this.updateInput();
                this.close();
            }

            selectToday() {
                this.selectedDate = new Date();
                this.updateInput();
                this.close();
            }

            previousMonth() {
                const persianCurrent = this.toPersianDate(this.currentDate);
                let newYear = persianCurrent.year;
                let newMonth = persianCurrent.month - 1;

                if (newMonth === 0) {
                    newMonth = 12;
                    newYear--;
                }

                this.currentDate = this.persianToGregorian(newYear, newMonth, 1);
                this.updateCalendar();
            }

            nextMonth() {
                const persianCurrent = this.toPersianDate(this.currentDate);
                let newYear = persianCurrent.year;
                let newMonth = persianCurrent.month + 1;

                if (newMonth === 13) {
                    newMonth = 1;
                    newYear++;
                }

                this.currentDate = this.persianToGregorian(newYear, newMonth, 1);
                this.updateCalendar();
            }

            updateInput() {
                if (this.selectedDate) {
                    const persianDate = this.toPersianDate(this.selectedDate);
                    this.input.value = `${persianDate.day}/${persianDate.month}/${persianDate.year}`;
                } else {
                    this.input.value = '';
                }
            }

            toPersianDate(date) {
                // Simple and accurate Persian date conversion
                const gYear = date.getFullYear();
                const gMonth = date.getMonth() + 1;
                const gDay = date.getDate();

                // Persian epoch: March 22, 622 AD
                const persianEpoch = new Date(622, 2, 22);
                const diffTime = date.getTime() - persianEpoch.getTime();
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

                // Calculate Persian year
                let pYear = Math.floor(diffDays / 365.25) + 1;
                let remainingDays = diffDays - Math.floor((pYear - 1) * 365.25);

                // Persian months (days in each month)
                const persianMonths = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];

                // Check for leap year
                if (this.isPersianLeapYear(pYear)) {
                    persianMonths[11] = 30; // Esfand has 30 days in leap year
                }

                let pMonth = 1;
                let pDay = 1;

                // Find month and day
                for (let i = 0; i < 12; i++) {
                    if (remainingDays >= persianMonths[i]) {
                        remainingDays -= persianMonths[i];
                        pMonth++;
                    } else {
                        pDay = remainingDays + 1;
                        break;
                    }
                }

                return { year: pYear, month: pMonth, day: pDay };
            }

            persianToGregorian(pYear, pMonth, pDay) {
                // Convert Persian date to Gregorian
                const persianEpoch = new Date(622, 2, 22); // March 22, 622 AD

                // Calculate total days from Persian epoch
                let totalDays = (pYear - 1) * 365.25;

                // Add days from previous months
                const persianMonths = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];
                if (this.isPersianLeapYear(pYear)) {
                    persianMonths[11] = 30;
                }

                for (let i = 0; i < pMonth - 1; i++) {
                    totalDays += persianMonths[i];
                }

                totalDays += pDay - 1;

                // Create Gregorian date
                const resultDate = new Date(persianEpoch.getTime() + totalDays * 24 * 60 * 60 * 1000);
                return resultDate;
            }

            isPersianLeapYear(year) {
                // Persian leap year calculation (more accurate)
                const a = (year + 2346) % 128;
                return a < 29 || (a === 29 && (year + 2346) % 128 < 29);
            }

            getPersianFirstDayOfWeek(year, month) {
                // Get first day of week for Persian month (0 = Saturday, 1 = Sunday, etc.)
                const firstDay = this.persianToGregorian(year, month + 1, 1);
                return (firstDay.getDay() + 1) % 7; // Convert to Persian week (Saturday = 0)
            }
        }

        // Initialize date pickers when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            new PersianDatePicker('from-date-picker');
            new PersianDatePicker('to-date-picker');
        });
    </script>
@endpush
