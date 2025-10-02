@extends('dashboard.layouts.app')

@section('title', 'داشبورد مدیریت مدرسه | سیستم هوشمند')

@push('styles')
    <style>
        .h_iframe-aparat_embed_frame {
            position: relative;
        }

        .h_iframe-aparat_embed_frame .ratio {
            display: block;
            width: 100%;
            height: auto;
        }

        .h_iframe-aparat_embed_frame iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
@endpush

@section('content')
    <!-- Hero -->
    <div class="hero glass-effect p-5 mb-4 animate__animated animate__fadeInUp"
         style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-4">
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="floating-animation">
                        <i class="fa-solid fa-sun text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <div>
                                <span class="badge-accent px-3 py-2"
                                      style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 20px;">
                                    <i class="fa-solid fa-hand-wave me-2"></i>سلام! {{ Auth::user()->first_name ?? '' }}
                                </span>
                    </div>
                </div>
                <h3 class="mb-2 gradient-text fw-bold">خوش آمدید به داشبورد مدیریت</h3>
                @owner
                <h5 class="mb-2 gradient-text fw-bold">مدیر مدرسه ی  {{ Auth::user()->school->name }}</h5>
                @endowner
                @admin
                <p class="text-muted mb-3">آخرین ثبت نام مدرسه: <span
                        class="fw-semibold text-primary">{{ $data['lastCreatedSchoolTime'] }}</span></p>

                <div class="d-flex gap-2 flex-wrap">
                    <a class="btn btn-primary btn-pill" href="{{ route('dashboard.users.index') }}">
                        <i class="fa-solid fa-users me-2"></i>مشاهده کاربران
                    </a>
                    <a class="btn btn-outline-primary btn-pill" href="{{ route('dashboard.studyFields.index') }}">
                        <i class="fa-solid fa-graduation-cap me-2"></i>رشته های تحصیلی
                    </a>
                </div>
                @endadmin
            </div>
            <div class="text-center">
                <div class="floating-animation">
                    <i class="fa-solid fa-graduation-cap text-primary" style="font-size: 4rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI cards -->
    <div class="row g-4">
        <div class="col-xl-3 col-md-6">
            <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp"
                 style="animation-delay: 0.1s;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted small mb-1">دانش آموزان</div>
                            <div class="fs-2 fw-bold text-primary">{{ $data['studentsCount'] ?? 0}}</div>
                            <div class="text-success small">
                                <i class="fa-solid fa-arrow-up me-1"></i>+12% از ماه قبل
                            </div>
                        </div>
                        <div class="card-icon pulse-animation"
                             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; width: 60px; height: 60px; border-radius: 15px;">
                            <i class="fa-solid fa-users" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp"
                 style="animation-delay: 0.2s;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            @admin
                            <div class="text-muted small mb-1">مدیران</div>
                            <div class="fs-2 fw-bold text-success">{{ $data['ownerUsersCount'] ?? 0}}</div>
                            @endadmin

                            @owner
                            <div class="text-muted small mb-1">معلمان</div>
                            <div class="fs-2 fw-bold text-success">{{ $data['teachersCount'] ?? 0  }}</div>
                            @endowner
                        </div>
                        <div class="card-icon pulse-animation"
                             style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; width: 60px; height: 60px; border-radius: 15px;">
                            <i class="fa-solid fa-user-shield" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp"
                 style="animation-delay: 0.3s;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            @admin
                            <div class="text-muted small mb-1">مدارس</div>
                            <div class="fs-2 fw-bold text-warning">{{ $data['schoolsCount'] ?? 0 }}</div>
                            @endadmin
                            @owner
                            <div class="text-muted small mb-1">کلاس ها</div>
                            <div class="fs-2 fw-bold text-warning">{{ $data['classRoomCount'] ?? 0  }}</div>
                            @endowner
                        </div>
                        <div class="card-icon pulse-animation"
                             style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; width: 60px; height: 60px; border-radius: 15px;">
                            <i class="fa-solid fa-school" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp"
                 style="animation-delay: 0.4s;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            @owner
                            <div class="text-muted small mb-1">غایبان امروز</div>
                            <div class="fs-2 fw-bold text-info">{{ $data['absentStudentsTodayCount'] ?? 0  }}</div>
                            @endowner

                        </div>
                        <div class="card-icon pulse-animation"
                             style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; width: 60px; height: 60px; border-radius: 15px;">
                            <i class="fa-solid fa-chalkboard" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        @admin
        <div class="col-lg-8">
            <div class="card glass-effect border-0 shadow-lg h-100 animate__animated animate__fadeInUp"
                 style="animation-delay: 0.5s;">
                <div class="card-header glass-effect border-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 gradient-text fw-bold">
                            <i class="fa-solid fa-chart-line me-2"></i>آمار کاربران جدید
                        </h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary">هفته</button>
                            <button class="btn btn-sm btn-primary">ماه</button>
                            <button class="btn btn-sm btn-outline-primary">سال</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <canvas id="myChart" height="120"></canvas>
                </div>
            </div>
        </div>
        @endadmin

        @owner
        <div class="col-lg-8">
            <div class="card glass-effect border-0 shadow-lg h-100 animate__animated animate__fadeInUp"
                 style="animation-delay: 0.5s;">
                <div class="card-header glass-effect border-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 gradient-text fw-bold">
                            <i class="fa-solid fa-video-camera me-2"></i>ویدیو ی آموزشی کار با سامانه
                        </h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="h_iframe-aparat_embed_frame"><span style="display: block;padding-top: 57%"></span>
                        <iframe src="https://www.aparat.com/video/video/embed/videohash/mrgd18t/vt/frame"
                                allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                    </div>
                </div>
            </div>
        </div>
        @endowner
        <div class="col-lg-4">
            <div class="card glass-effect border-0 shadow-lg h-100 animate__animated animate__fadeInUp"
                 style="animation-delay: 0.6s;">
                <div class="card-header glass-effect border-0">
                    <h5 class="mb-0 gradient-text fw-bold">
                        <i class="fa-solid fa-bolt me-2"></i>اکشن‌های سریع
                    </h5>
                </div>
                <div class="card-body p-4">
                    @admin
                    <div class="row g-3">
                        <div class="col-6">
                            <a class="quick-action d-block text-decoration-none rounded-3 p-3 text-center"
                               href="{{ route('dashboard.users.index') }}">
                                <div class="mb-2">
                                    <i class="fa-solid fa-users text-primary" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="fw-semibold">کاربران</div>
                                <small class="text-muted">مدیریت کاربران</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="quick-action d-block text-decoration-none rounded-3 p-3 text-center"
                               href="{{ route('dashboard.studyFields.index') }}">
                                <div class="mb-2">
                                    <i class="fa-solid fa-graduation-cap text-success" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="fw-semibold">رشته ها</div>
                                <small class="text-muted">رشته های تحصیلی</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="quick-action d-block text-decoration-none rounded-3 p-3 text-center"
                               href="{{ route('dashboard.roles.index') }}">
                                <div class="mb-2">
                                    <i class="fa-solid fa-user-shield text-warning" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="fw-semibold">نقش ها</div>
                                <small class="text-muted">مدیریت نقش ها</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="quick-action d-block text-decoration-none rounded-3 p-3 text-center"
                               href="{{ route('dashboard.studyBases.index') }}">
                                <div class="mb-2">
                                    <i class="fa-solid fa-layer-group text-info" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="fw-semibold">پایه ها</div>
                                <small class="text-muted">پایه های تحصیلی</small>
                            </a>
                        </div>
                    </div>
                    @endadmin

                    @owner
                    <div class="row g-3">
                        <div class="col-6">
                            <a class="quick-action d-block text-decoration-none rounded-3 p-3 text-center"
                               href="{{ route('dashboard.users.index') }}">
                                <div class="mb-2">
                                    <i class="fa-solid fa-users text-primary" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="fw-semibold">کاربران</div>
                                <small class="text-muted">مدیریت کاربران</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="quick-action d-block text-decoration-none rounded-3 p-3 text-center"
                               href="#">
                                <div class="mb-2">
                                    <i class="fa-solid fa-graduation-cap text-success" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="fw-semibold">چارت ها</div>
                                <small class="text-muted">چارت ها</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="quick-action d-block text-decoration-none rounded-3 p-3 text-center"
                               href="#">
                                <div class="mb-2">
                                    <i class="fa-solid fa-user-shield text-warning" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="fw-semibold">نمرات</div>
                                <small class="text-muted">مدیریت نمرات</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="quick-action d-block text-decoration-none rounded-3 p-3 text-center"
                               href="#">
                                <div class="mb-2">
                                    <i class="fa-solid fa-layer-group text-info" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="fw-semibold">مدیریت وبسایت</div>
                                <small class="text-muted">مدیریت وبسایت</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="quick-action d-block text-decoration-none rounded-3 p-3 text-center"
                               href="#">
                                <div class="mb-2">
                                    <i class="fa-solid fa-layer-group text-info" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="fw-semibold">مشاهده ی وبسایت</div>
                                <small class="text-muted">وبسایت</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="quick-action d-block text-decoration-none rounded-3 p-3 text-center"
                               href="#">
                                <div class="mb-2">
                                    <i class="fa-solid fa-layer-group text-info" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="fw-semibold">نوتیفیکیشن ها</div>
                                <small class="text-muted">مدیریت نوتیف ها</small>
                            </a>
                        </div>
                    </div>
                    @endowner
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-4 py-3 text-center footer">
        ساخته شده توسط <a href="">امیر حسین بابایی</a>
    </footer>
@endsection

@push('scripts')
    @admin
    <script>
        const xValues = {!! json_encode($data['dataChartOwners'][0]) !!};
        const yValues = {!! json_encode($data['dataChartOwners'][1]) !!};

        // Gradient colors for modern look
        let barColors = [
            "rgba(102, 126, 234, 0.8)",
            "rgba(16, 185, 129, 0.8)",
            "rgba(245, 158, 11, 0.8)",
            "rgba(6, 182, 212, 0.8)",
            "rgba(139, 92, 246, 0.8)",
            "rgba(239, 68, 68, 0.8)",
            "rgba(156, 163, 175, 0.8)"
        ];

        new Chart("myChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    label: 'کاربران جدید',
                    backgroundColor: barColors,
                    borderColor: barColors.map(color => color.replace('0.8', '1')),
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                    data: yValues
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)',
                            borderColor: 'rgba(255, 255, 255, 0.2)'
                        },
                        ticks: {
                            color: '#ffffff',
                            font: {
                                family: 'Vazirmatn'
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#ffffff',
                            font: {
                                family: 'Vazirmatn'
                            }
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    </script>
    @endadmin
@endpush
