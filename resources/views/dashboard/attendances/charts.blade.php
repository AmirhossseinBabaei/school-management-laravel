@extends('dashboard.layouts.app')

@section('title', 'چارت‌های آماری | سیستم مدیریت مدرسه')

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

        .chart-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
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

        .chart-title {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            color: #fff;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
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

        .filter-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

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

        .form-label {
            color: #fff;
            font-weight: 600;
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

        .loading {
            text-align: center;
            padding: 3rem;
            color: #fff;
        }

        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #66a6ff;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-3 px-md-5 py-4">
        
        <!-- Hero -->
        <div class="hero glass-effect p-4 mb-4 shadow-lg">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="fw-bold mb-1 gradient-text">
                        <i class="fa-solid fa-chart-pie me-2"></i> چارت‌های آماری حضور و غیاب
                    </h2>
                    <p class="text-light mb-0 fs-6">تحلیل و بررسی آمارهای مختلف حضور و غیاب</p>
                </div>
                <div class="text-end mt-3 mt-md-0">
                    <a href="{{ route('dashboard.attendances.reports') }}" class="btn btn-gradient px-4 py-2">
                        <i class="fa-solid fa-arrow-right"></i> بازگشت به گزارش‌ها
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-section">
            <div class="row g-4">
                <div class="col-md-3">
                    <label class="form-label">کلاس</label>
                    <select id="classFilter" class="form-select">
                        <option value="">همه کلاس‌ها</option>
                        <!-- TODO: لود کلاس‌ها از AJAX -->
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">درس</label>
                    <select id="lessonFilter" class="form-select">
                        <option value="">همه دروس</option>
                        <!-- TODO: لود دروس از AJAX -->
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">از تاریخ</label>
                    <input type="date" id="fromDate" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">تا تاریخ</label>
                    <input type="date" id="toDate" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button id="updateCharts" class="btn btn-gradient w-100">
                        <i class="fa-solid fa-sync"></i> بروزرسانی
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number text-success" id="totalPresent">0</div>
                <div class="stat-label">کل حاضرین</div>
            </div>
            <div class="stat-item">
                <div class="stat-number text-danger" id="totalAbsent">0</div>
                <div class="stat-label">کل غایبان</div>
            </div>
            <div class="stat-item">
                <div class="stat-number text-warning" id="totalLate">0</div>
                <div class="stat-label">کل تاخیرها</div>
            </div>
            <div class="stat-item">
                <div class="stat-number text-info" id="attendanceRate">0%</div>
                <div class="stat-label">نرخ حضور</div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <!-- Status Chart -->
            <div class="col-lg-6">
                <div class="chart-card">
                    <h3 class="chart-title">
                        <i class="fa-solid fa-chart-donut me-2"></i>
                        توزیع وضعیت حضور
                    </h3>
                    <canvas id="statusChart" width="400" height="300"></canvas>
                </div>
            </div>

            <!-- Class Chart -->
            <div class="col-lg-6">
                <div class="chart-card">
                    <h3 class="chart-title">
                        <i class="fa-solid fa-chart-bar me-2"></i>
                        غیبت بر اساس کلاس
                    </h3>
                    <canvas id="classChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Lesson Chart -->
            <div class="col-lg-6">
                <div class="chart-card">
                    <h3 class="chart-title">
                        <i class="fa-solid fa-chart-pie me-2"></i>
                        غیبت بر اساس درس
                    </h3>
                    <canvas id="lessonChart" width="400" height="300"></canvas>
                </div>
            </div>

            <!-- Trend Chart -->
            <div class="col-lg-6">
                <div class="chart-card">
                    <h3 class="chart-title">
                        <i class="fa-solid fa-chart-line me-2"></i>
                        روند زمانی غیبت
                    </h3>
                    <canvas id="trendChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Monthly Chart -->
            <div class="col-lg-8">
                <div class="chart-card">
                    <h3 class="chart-title">
                        <i class="fa-solid fa-calendar me-2"></i>
                        آمار ماهانه حضور و غیاب
                    </h3>
                    <canvas id="monthlyChart" width="600" height="300"></canvas>
                </div>
            </div>

            <!-- Top Absent Students -->
            <div class="col-lg-4">
                <div class="chart-card">
                    <h3 class="chart-title">
                        <i class="fa-solid fa-users me-2"></i>
                        بیشترین غیبت‌ها
                    </h3>
                    <div id="topAbsentStudents">
                        <!-- TODO: لود داده‌ها از AJAX -->
                        <div class="text-center text-white-50">
                            <i class="fa-solid fa-spinner fa-spin fa-2x mb-3"></i>
                            <p>در حال بارگذاری...</p>
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
        // متغیرهای global
        let statusChart, classChart, lessonChart, trendChart, monthlyChart;

        // بارگذاری اولیه
        document.addEventListener('DOMContentLoaded', function() {
            loadInitialData();
            setupEventListeners();
            createAllCharts();
        });

        // بارگذاری داده‌های اولیه
        function loadInitialData() {
            // TODO: اضافه کردن AJAX برای لود کلاس‌ها و دروس
            updateMockStats();
        }

        // تنظیم event listeners
        function setupEventListeners() {
            document.getElementById('updateCharts').addEventListener('click', updateCharts);
        }

        // بروزرسانی چارت‌ها
        function updateCharts() {
            const filters = {
                class_id: document.getElementById('classFilter').value,
                lesson_id: document.getElementById('lessonFilter').value,
                from_date: document.getElementById('fromDate').value,
                to_date: document.getElementById('toDate').value
            };

            // TODO: اضافه کردن AJAX call
            // fetch('/api/attendances/charts', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            //     },
            //     body: JSON.stringify(filters)
            // })
            // .then(response => response.json())
            // .then(data => {
            //     updateAllCharts(data);
            //     updateStats(data.stats);
            // })
            // .catch(error => {
            //     console.error('Error:', error);
            // });

            // شبیه‌سازی بروزرسانی
            updateAllCharts();
        }

        // ایجاد همه چارت‌ها
        function createAllCharts() {
            createStatusChart();
            createClassChart();
            createLessonChart();
            createTrendChart();
            createMonthlyChart();
            loadTopAbsentStudents();
        }

        // بروزرسانی همه چارت‌ها
        function updateAllCharts() {
            if (statusChart) statusChart.destroy();
            if (classChart) classChart.destroy();
            if (lessonChart) lessonChart.destroy();
            if (trendChart) trendChart.destroy();
            if (monthlyChart) monthlyChart.destroy();
            
            createAllCharts();
        }

        // آپدیت آمار شبیه‌سازی شده
        function updateMockStats() {
            document.getElementById('totalPresent').textContent = '120';
            document.getElementById('totalAbsent').textContent = '15';
            document.getElementById('totalLate').textContent = '8';
            document.getElementById('attendanceRate').textContent = '89%';
        }

        // چارت وضعیت حضور
        function createStatusChart() {
            const ctx = document.getElementById('statusChart').getContext('2d');
            statusChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['حاضر', 'غایب', 'تاخیر'],
                    datasets: [{
                        data: [120, 15, 8],
                        backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                        borderWidth: 3,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#fff',
                                font: {
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });
        }

        // چارت غیبت بر اساس کلاس
        function createClassChart() {
            const ctx = document.getElementById('classChart').getContext('2d');
            classChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['کلاس اول', 'کلاس دوم', 'کلاس سوم', 'کلاس چهارم'],
                    datasets: [{
                        label: 'تعداد غایبان',
                        data: [5, 7, 3, 2],
                        backgroundColor: 'rgba(220, 53, 69, 0.8)',
                        borderColor: 'rgba(220, 53, 69, 1)',
                        borderWidth: 2
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
            lessonChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['ریاضی', 'علوم', 'فارسی', 'انگلیسی', 'تاریخ'],
                    datasets: [{
                        data: [6, 4, 3, 2, 1],
                        backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff'],
                        borderWidth: 3,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#fff',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        }

        // چارت روند زمانی
        function createTrendChart() {
            const ctx = document.getElementById('trendChart').getContext('2d');
            trendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['هفته 1', 'هفته 2', 'هفته 3', 'هفته 4', 'هفته 5'],
                    datasets: [{
                        label: 'غایبان',
                        data: [12, 19, 15, 8, 10],
                        borderColor: 'rgba(220, 53, 69, 1)',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'تاخیرها',
                        data: [5, 8, 6, 4, 7],
                        borderColor: 'rgba(255, 193, 7, 1)',
                        backgroundColor: 'rgba(255, 193, 7, 0.1)',
                        tension: 0.4,
                        fill: true
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

        // چارت ماهانه
        function createMonthlyChart() {
            const ctx = document.getElementById('monthlyChart').getContext('2d');
            monthlyChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور'],
                    datasets: [{
                        label: 'حاضر',
                        data: [95, 88, 92, 85, 90, 87],
                        backgroundColor: 'rgba(40, 167, 69, 0.8)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 2
                    }, {
                        label: 'غایب',
                        data: [5, 12, 8, 15, 10, 13],
                        backgroundColor: 'rgba(220, 53, 69, 0.8)',
                        borderColor: 'rgba(220, 53, 69, 1)',
                        borderWidth: 2
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

        // لود بیشترین غیبت‌ها
        function loadTopAbsentStudents() {
            const container = document.getElementById('topAbsentStudents');
            
            // شبیه‌سازی داده
            const mockData = [
                { name: 'احمد محمدی', count: 8 },
                { name: 'فاطمه احمدی', count: 6 },
                { name: 'علی رضایی', count: 5 },
                { name: 'مریم حسینی', count: 4 },
                { name: 'حسن کریمی', count: 3 }
            ];

            let html = '';
            mockData.forEach((student, index) => {
                const medal = index === 0 ? '🥇' : index === 1 ? '🥈' : index === 2 ? '🥉' : '👤';
                html += `
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2" 
                         style="background: rgba(255, 255, 255, 0.1); border-radius: 8px;">
                        <div>
                            <span class="me-2">${medal}</span>
                            <span class="text-white">${student.name}</span>
                        </div>
                        <span class="badge bg-danger">${student.count}</span>
                    </div>
                `;
            });

            container.innerHTML = html;
        }
    </script>
@endpush
