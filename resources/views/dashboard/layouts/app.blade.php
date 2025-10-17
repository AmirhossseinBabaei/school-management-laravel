<!doctype html>
<html lang="fa" dir="rtl" class="theme-dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'داشبورد مدیریت مدرسه | سیستم هوشمند')</title>

    <!-- External CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">

    <!-- Persian Font -->
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    @stack('styles')
    <style>
        body {
            font-family: Vazirmatn, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, #1a1d29 0%, #0f1115 100%);
            min-height: 100vh;
            color: #ffffff;
        }

        .form-control {
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: rgba(255, 255, 255, 0.15);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-select {
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: rgba(255, 255, 255, 0.15);
        }

        .input-group-text {
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .btn {
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            color: #ffffff;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            color: #ffffff;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: #ffffff;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border: none;
            color: #000000;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            color: #000000;
        }

        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: #667eea;
            color: #ffffff;
        }

        .btn-outline-danger {
            border: 2px solid #ef4444;
            color: #ef4444;
            background: transparent;
        }

        .btn-outline-danger:hover {
            background: #ef4444;
            color: #ffffff;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .floating-animation {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .table {
            color: #ffffff;
        }

        .table thead th {
            background: rgba(255, 255, 255, 0.1);
            border-bottom-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .table tbody td {
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.1);
        }

        .modal-content {
            background: rgba(22, 24, 29, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .modal-header {
            border-bottom-color: rgba(255, 255, 255, 0.2);
        }

        .modal-footer {
            border-top-color: rgba(255, 255, 255, 0.2);
        }

        .alert {
            border: none;
            border-radius: 12px;
            backdrop-filter: blur(20px);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
            border-left: 4px solid #10b981;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border-left: 4px solid #ef4444;
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
            border-left: 4px solid #f59e0b;
        }

        .alert-info {
            background: rgba(6, 182, 212, 0.2);
            color: #06b6d4;
            border-left: 4px solid #06b6d4;
        }

        .btn-close {
            background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath d='m.5 3.5 3 3-3 3 1 1 3-3 3 3 1-1-3-3 3-3-1-1-3 3-3-3z'/%3e%3c/svg%3e") center/1em auto no-repeat;
            opacity: 0.7;
        }

        .btn-close:hover {
            opacity: 1;
        }

        /* Loading Spinner */
        .loading-overlay {
            position: fixed;
            top: 0;
            /*left: 0;*/
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a1d29 0%, #0f1115 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255, 255, 255, 0.1);
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .loading-text {
            color: #ffffff;
            margin-top: 20px;
            font-size: 1.1rem;
            font-weight: 600;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Table dark theme */
        .table {
            background: rgba(22, 24, 29, 0.8) !important;
            color: #ffffff !important;
        }

        .table thead th {
            background: rgba(0, 0, 0, 0.3) !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            font-weight: 600;
        }

        .table tbody tr {
            background: rgba(22, 24, 29, 0.6) !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }

        .table tbody td {
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.05) !important;
            background: rgba(22, 24, 29, 0.6) !important;
        }

        .table tbody td * {
            color: #ffffff !important;
        }

        .table tbody td span,
        .table tbody td div,
        .table tbody td small {
            color: #ffffff !important;
        }

        /* DataTable specific styles */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: #ffffff !important;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background: rgba(22, 24, 29, 0.8) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: rgba(22, 24, 29, 0.8) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: #ffffff !important;
        }

        /* Specific text elements in tables */
        .table tbody td .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .table tbody td .text-primary {
            color: #667eea !important;
        }

        .table tbody td .text-success {
            color: #10b981 !important;
        }

        .table tbody td .text-warning {
            color: #f59e0b !important;
        }

        .table tbody td .text-danger {
            color: #ef4444 !important;
        }

        .table tbody td .text-info {
            color: #06b6d4 !important;
        }

        .table tbody td .text-secondary {
            color: #6b7280 !important;
        }

        /* Badge colors in tables */
        .table tbody td .badge {
            color: #ffffff !important;
        }

        .table tbody td .badge.bg-primary {
            background-color: #667eea !important;
        }

        .table tbody td .badge.bg-success {
            background-color: #10b981 !important;
        }

        .table tbody td .badge.bg-warning {
            background-color: #f59e0b !important;
        }

        .table tbody td .badge.bg-danger {
            background-color: #ef4444 !important;
        }

        .table tbody td .badge.bg-info {
            background-color: #06b6d4 !important;
        }

        label {
            color: white;
        }

        /* Font Awesome Icons - Essential Only */
        .fa-solid, .fas {
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
        }

        .fa-graduation-cap:before {
            content: "\f19d";
        }

        .fa-gauge:before {
            content: "\f0e4";
        }

        .fa-users:before {
            content: "\f0c0";
        }

        .fa-user-shield:before {
            content: "\f505";
        }

        .fa-id-card:before {
            content: "\f2c2";
        }

        .fa-book:before {
            content: "\f02d";
        }

        .fa-building:before {
            content: "\f1ad";
        }

        .fa-layer-group:before {
            content: "\f5fd";
        }

        .fa-calendar-alt:before {
            content: "\f073";
        }

        .fa-message:before {
            content: "\f0e6";
        }

        .fa-right-to-bracket:before {
            content: "\f090";
        }

        .fa-sun:before {
            content: "\f185";
        }

        .fa-bars:before {
            content: "\f0c9";
        }

        .fa-chevron-down:before {
            content: "\f078";
        }

        .fa-user-circle:before {
            content: "\f2bd";
        }

        .fa-user:before {
            content: "\f007";
        }

        .fa-right-from-bracket:before {
            content: "\f2f5";
        }

        .fa-check-circle:before {
            content: "\f058";
        }

        .fa-exclamation-triangle:before {
            content: "\f071";
        }

        .fa-plus:before {
            content: "\f067";
        }

        .fa-save:before {
            content: "\f0c7";
        }

        .fa-times:before {
            content: "\f00d";
        }

        .fa-arrow-right:before {
            content: "\f061";
        }

        .fa-edit:before {
            content: "\f044";
        }

        .fa-trash:before {
            content: "\f1f8";
        }

        .fa-eye:before {
            content: "\f06e";
        }

        .fa-undo:before {
            content: "\f0e2";
        }

        .fa-search:before {
            content: "\f002";
        }

        .fa-filter:before {
            content: "\f0b0";
        }

        .fa-download:before {
            content: "\f019";
        }

        .fa-upload:before {
            content: "\f093";
        }

        .fa-cog:before {
            content: "\f013";
        }

        .fa-home:before {
            content: "\f015";
        }

        .fa-chart-bar:before {
            content: "\f080";
        }

        .fa-chart-line:before {
            content: "\f201";
        }

        .fa-chart-pie:before {
            content: "\f200";
        }

        .fa-calendar:before {
            content: "\f133";
        }

        .fa-clock:before {
            content: "\f017";
        }

        .fa-bell:before {
            content: "\f0f3";
        }

        .fa-envelope:before {
            content: "\f0e0";
        }

        .fa-phone:before {
            content: "\f095";
        }

        .fa-map-marker-alt:before {
            content: "\f3c5";
        }

        .fa-globe:before {
            content: "\f0ac";
        }

        .fa-link:before {
            content: "\f0c1";
        }

        .fa-external-link-alt:before {
            content: "\f35d";
        }

        .fa-info-circle:before {
            content: "\f05a";
        }

        .fa-question-circle:before {
            content: "\f059";
        }

        .fa-exclamation-circle:before {
            content: "\f06a";
        }

        .fa-check:before {
            content: "\f00c";
        }

        .fa-times-circle:before {
            content: "\f057";
        }

        .fa-ban:before {
            content: "\f05e";
        }

        .fa-lock:before {
            content: "\f023";
        }

        .fa-unlock:before {
            content: "\f09c";
        }

        .fa-key:before {
            content: "\f084";
        }

        .fa-shield-alt:before {
            content: "\f3ed";
        }

        .fa-user-plus:before {
            content: "\f234";
        }

        .fa-user-minus:before {
            content: "\f503";
        }

        .fa-user-edit:before {
            content: "\f4ff";
        }

        .fa-user-times:before {
            content: "\f235";
        }

        .fa-users-cog:before {
            content: "\f509";
        }

        .fa-user-friends:before {
            content: "\f500";
        }

        .fa-user-check:before {
            content: "\f4fc";
        }

        .fa-user-clock:before {
            content: "\f4fd";
        }

        .fa-user-graduate:before {
            content: "\f501";
        }

        .fa-user-tie:before {
            content: "\f508";
        }

        .fa-user-ninja:before {
            content: "\f504";
        }

        .fa-user-secret:before {
            content: "\f21b";
        }

        .fa-user-astronaut:before {
            content: "\f4fb";
        }

        .fa-user-md:before {
            content: "\f0f0";
        }

        .fa-user-nurse:before {
            content: "\f82f";
        }

        .fa-user-injured:before {
            content: "\f728";
        }

        .fa-user-cog:before {
            content: "\f4fe";
        }

        .fa-user-edit:before {
            content: "\f4ff";
        }

        .fa-user-friends:before {
            content: "\f500";
        }

        .fa-user-graduate:before {
            content: "\f501";
        }

        .fa-user-lock:before {
            content: "\f502";
        }

        .fa-user-minus:before {
            content: "\f503";
        }

        .fa-user-ninja:before {
            content: "\f504";
        }

        .fa-user-nurse:before {
            content: "\f82f";
        }

        .fa-user-plus:before {
            content: "\f234";
        }

        .fa-user-secret:before {
            content: "\f21b";
        }

        .fa-user-shield:before {
            content: "\f505";
        }

        .fa-user-slash:before {
            content: "\f506";
        }

        .fa-user-tag:before {
            content: "\f507";
        }

        .fa-user-tie:before {
            content: "\f508";
        }

        .fa-user-times:before {
            content: "\f235";
        }

        .fa-users:before {
            content: "\f0c0";
        }

        .fa-users-cog:before {
            content: "\f509";
        }

        .fa-users-slash:before {
            content: "\f73b";
        }

    </style>
</head>
<body>
<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="text-center">
        <div class="loading-spinner"></div>
        <div class="loading-text">در حال بارگذاری...</div>
    </div>
</div>

<div class="wrapper">
    <aside class="sidebar glass-effect animate__animated animate__slideInRight" id="sideBar">
        <div class="brand px-3 mb-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="floating-animation">
                    <i class="fas fa-graduation-cap text-primary" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <h6 class="mb-0 gradient-text fw-bold">سیستم مدیریت مدرسه</h6>
                    <small class="text-muted">{{ $data['nowDate'] ?? date('Y/m/d') }}</small>
                </div>
            </div>
        </div>
        <nav class="nav flex-column px-2">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} glass-effect text-white mb-2 rounded-3"
               href="{{ route('dashboard') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fa-solid fa-gauge me-2"></i> داشبورد
            </a>
            <a class="nav-link {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }} rounded-3 mb-1"
               href="{{ url('dashboard/users') }}">
                <i class="fa-solid fa-users me-2 text-primary"></i> کاربران
            </a>
            <a class="nav-link {{ request()->routeIs('dashboard.students.*') ? 'active' : '' }} rounded-3 mb-1"
               href="{{ url('/dashboard/students') }}">
                <i class="fa-solid fa-id-card me-2 text-info"></i> دانش آموزان
            </a>
            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }} rounded-3 mb-1"
               href="{{ url('/profile') }}">
                <i class="fa-solid fa-user me-2 text-info"></i> پروفایل
            </a>
            <a class="nav-link {{ request()->routeIs('dashboard.attendances.*') ? 'active' : '' }} rounded-3 mb-1" href="{{ route('dashboard.attendances.index')  }}">
                <i class="fa-solid fa-calendar-check me-2 text-primary"></i> حضور و غیاب
                <sup class="bg-success text-white">جدید</sup>
            </a>
            <a class="nav-link {{ request()->routeIs('dashboard.classRooms.*') ? 'active' : '' }} rounded-3 mb-1"
               href="{{ url('/dashboard/classRooms') }}">
                <i class="fa-solid fa-chalkboard me-2 text-info"></i> کلاس ها
            </a>
            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }} rounded-3 mb-1" href="#">
                <i class="fa-solid fa-chart-line me-2 text-success"></i> نمرات
                <sup class="bg-danger text-white">بزودی</sup>
            </a>
            <a class="nav-link {{ request()->routeIs('dashboard.teacherClasses.*') ? 'active' : '' }} rounded-3 mb-1"
               href="{{ url('/dashboard/teacher-classes') }}">
                <i class="fa-solid fa-chalkboard-teacher me-2 text-danger"></i> کلاس های معلمان
            </a>
            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }} rounded-3 mb-1" href="#">
                <i class="fa-solid fa-file-alt me-2 text-info"></i> دریافت کارنامه
                <sup class="bg-danger text-white">بزودی</sup>
            </a>

            <a class="nav-link {{ request()->routeIs('dashboard.notifications.*') ? 'active' : '' }} rounded-3 mb-1"
               href="{{ url('dashboard/users') }}">
                <i class="fa-solid fa-bell me-2 text-primary"></i>   اطلاع رسانی
                <sup class="bg-danger text-white">بزودی</sup>
            </a>

            <a class="nav-link {{ request()->routeIs('dashboard.notifications.*') ? 'active' : '' }} rounded-3 mb-1"
               href="#">
                <i class="fa-solid fa-bell me-2 text-primary"></i>   موارد انضباطی
                <sup class="bg-danger text-white">بزودی</sup>
            </a>

            <a class="nav-link {{ request()->routeIs('dashboard.attendance.reports') ? 'active' : '' }} rounded-3 mb-1"
               href="{{ url('dashboard/get-report/attendances') }}">
                <i class="fa-solid fa-message me-2 text-primary"></i>گزارش گیری
                <sup class="bg-success text-white">جدید</sup>
            </a>
            @admin
            <div class="collapse show" id="grpPersonal">
                <h6 class="text-muted small px-3 mb-2 mt-3">مدیریت کاربران</h6>
                <a class="nav-link {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }} rounded-3 mb-1"
                   href="{{ url('dashboard/users') }}">
                    <i class="fa-solid fa-users me-2 text-primary"></i> کاربران
                </a>
                <a class="nav-link {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }} rounded-3 mb-1"
                   href="{{ url('dashboard/roles') }}">
                    <i class="fa-solid fa-user-shield me-2 text-warning"></i> نقش ها
                </a>
                <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }} rounded-3 mb-1"
                   href="{{ url('/profile') }}">
                    <i class="fa-solid fa-id-card me-2 text-info"></i> پروفایل
                </a>
            </div>
            <div class="collapse show" id="grpPublic">
                <h6 class="text-muted small px-3 mb-2 mt-3">مدیریت محتوا</h6>

                <a class="nav-link {{ request()->routeIs('dashboard.lessons.*') ? 'active' : '' }} rounded-3 mb-1"
                   href="{{ url('dashboard/lessons') }}">
                    <i class="fa-solid fa-book me-2 text-danger"></i> مدیریت درس ها
                </a>
                <a class="nav-link {{ request()->routeIs('dashboard.schools.*') ? 'active' : '' }} rounded-3 mb-1"
                   href="{{ url('dashboard/schools')  }}">
                    <i class="fa-solid fa-building me-2 text-primary"></i> مدیریت مدارس
                </a>
                <a class="nav-link {{ request()->routeIs('dashboard.studyFields.*') ? 'active' : '' }} rounded-3 mb-1"
                   href="{{ url('dashboard/study-fields') }}">
                    <i class="fa-solid fa-graduation-cap me-2 text-warning"></i> رشته های تحصیلی
                </a>
                <a class="nav-link {{ request()->routeIs('dashboard.studyBases.*') ? 'active' : '' }} rounded-3 mb-1"
                   href="{{ url('dashboard/study-bases') }}">
                    <i class="fa-solid fa-layer-group me-2 text-info"></i> پایه های تحصیلی
                </a>
                <a class="nav-link {{ request()->routeIs('dashboard.terms.*') ? 'active' : '' }} rounded-3 mb-1"
                   href="{{ url('dashboard/terms') }}">
                    <i class="fa-solid fa-calendar-alt me-2 text-secondary"></i> مدیریت ترم ها
                </a>
                <a class="nav-link {{ request()->routeIs('dashboard.notifications.*') ? 'active' : '' }} rounded-3 mb-1"
                   href="{{ url('dashboard/notifications') }}">
                    <i class="fa-solid fa-message me-2 text-primary"></i> نوتیفیکیشن ها
                </a>
                <a class="nav-link {{ request()->routeIs('dashboard.notifications.*') ? 'active' : '' }} rounded-3 mb-1"
                   href="#">
                    <i class="fa-solid fa-message me-2 text-primary"></i>گزارش گیری
                </a>
            </div>
            @endadmin

            @owner
            <!-- Accordion for Owner Menu -->
            {{--            <div class="accordion" id="ownerAccordion">--}}
            {{--                <!-- مدیریت کاربران -->--}}
            {{--                <div class="accordion-item border-0 mb-2">--}}
            {{--                    <h2 class="accordion-header">--}}
            {{--                        <button class="accordion-button collapsed glass-effect" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">--}}
            {{--                            <i class="fa-solid fa-users me-2 text-primary"></i>--}}
            {{--                            <span class="fw-semibold">مدیریت کاربران</span>--}}
            {{--                        </button>--}}
            {{--                    </h2>--}}
            {{--                    <div id="collapseUsers" class="accordion-collapse collapse" data-bs-parent="#ownerAccordion">--}}
            {{--                        <div class="accordion-body p-0">--}}
            {{--                            <div class="px-3 py-2">--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}

            {{--                <!-- مدیریت محتوا -->--}}
            {{--                <div class="accordion-item border-0 mb-2">--}}
            {{--                    <h2 class="accordion-header">--}}
            {{--                        <button class="accordion-button collapsed glass-effect" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContent" aria-expanded="false" aria-controls="collapseContent">--}}
            {{--                            <i class="fa-solid fa-file-alt me-2 text-success"></i>--}}
            {{--                            <span class="fw-semibold" disabled="true">مدیریت محتوا</span>--}}
            {{--                        </button>--}}
            {{--                    </h2>--}}
            {{--                    <div id="collapseContent" class="accordion-collapse collapse" data-bs-parent="#ownerAccordion">--}}
            {{--                        <div class="accordion-body p-0">--}}
            {{--                            <div class="px-3 py-2">--}}
            {{--                                <a class="nav-link {{ request()->routeIs('dashboard.notifications.*') ? 'active' : '' }} rounded-3 mb-1" href="{{ url('dashboard/notifications') }}">--}}
            {{--                                    <i class="fa-solid fa-comments me-2 text-primary"></i> کامنت ها--}}
            {{--                                </a>--}}
            {{--                                <a class="nav-link {{ request()->routeIs('dashboard.notifications.*') ? 'active' : '' }} rounded-3 mb-1" href="{{ url('dashboard/notifications') }}">--}}
            {{--                                    <i class="fa-solid fa-file-text me-2 text-info"></i> محتوا ها--}}
            {{--                                </a>--}}
            {{--                                <a class="nav-link {{ request()->routeIs('dashboard.notifications.*') ? 'active' : '' }} rounded-3 mb-1" href="{{ url('dashboard/notifications') }}">--}}
            {{--                                    <i class="fa-solid fa-bars me-2 text-warning"></i> منو ها--}}
            {{--                                </a>--}}
            {{--                                <a class="nav-link {{ request()->routeIs('dashboard.notifications.*') ? 'active' : '' }} rounded-3 mb-1" href="{{ url('dashboard/notifications') }}">--}}
            {{--                                    <i class="fa-solid fa-images me-2 text-danger"></i> اسلایدر ها--}}
            {{--                                </a>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}

            {{--                <!-- تحصیلی -->--}}
            {{--                <div class="accordion-item border-0 mb-2">--}}
            {{--                    <h2 class="accordion-header">--}}
            {{--                        <button class="accordion-button collapsed glass-effect" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEducation" aria-expanded="false" aria-controls="collapseEducation">--}}
            {{--                            <i class="fa-solid fa-graduation-cap me-2 text-warning"></i>--}}
            {{--                            <span class="fw-semibold">تحصیلی</span>--}}
            {{--                        </button>--}}
            {{--                    </h2>--}}
            {{--                    <div id="collapseEducation" class="accordion-collapse collapse" data-bs-parent="#ownerAccordion">--}}
            {{--                        <div class="accordion-body p-0">--}}
            {{--                            <div class="px-3 py-2">--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}

            {{--                <!-- اطلاع رسانی -->--}}
            {{--                <div class="accordion-item border-0 mb-2">--}}
            {{--                    <h2 class="accordion-header">--}}
            {{--                        <button class="accordion-button collapsed glass-effect" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNotifications" aria-expanded="false" aria-controls="collapseNotifications">--}}
            {{--                            <i class="fa-solid fa-bell me-2 text-info"></i>--}}
            {{--                            <span class="fw-semibold">اطلاع رسانی</span>--}}
            {{--                        </button>--}}
            {{--                    </h2>--}}
            {{--                    <div id="collapseNotifications" class="accordion-collapse collapse" data-bs-parent="#ownerAccordion">--}}
            {{--                        <div class="accordion-body p-0">--}}
            {{--                            <div class="px-3 py-2">--}}
            {{--                                <a class="nav-link {{ request()->routeIs('dashboard.notifications.*') ? 'active' : '' }} rounded-3 mb-1" href="{{ url('dashboard/users') }}">--}}
            {{--                                    <i class="fa-solid fa-bell me-2 text-primary"></i> مدیریت نوتیفیکیشن ها--}}
            {{--                                </a>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            @endowner

            <hr class="my-3">
            <a class="nav-link rounded-3 text-danger" href="{{ url('/logout') }}">
                <i class="fa-solid fa-right-to-bracket me-2"></i>خروج
            </a>
        </nav>
    </aside>

    <div class="content w-100">
        <div class="topbar glass-effect border-0 animate__animated animate__slideInDown">
            <div class="container-fluid py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-outline-primary btn-sm pulse-animation theme-toggle" id="themeToggle"
                                title="تغییر تم">
                            <i class="fa-solid fa-moon me-1 theme-icon"></i>
                            <span class="theme-text">تم روشن</span>
                        </button>
                        <button class="btn btn-outline-primary d-lg-none" onclick="showSideBar()" data-toggle="sidebar">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="text-center">
                            <h5 class="mb-0 gradient-text fw-bold">سیستم مدیریت مدرسه</h5>
                            <small class="text-muted">پنل مدیریت هوشمند</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="dropdown">
                            <button
                                class="btn btn-outline-primary d-flex align-items-center gap-2 rounded-pill glass-effect user-dropdown-btn"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img
                                    src="{{ Auth::user()->avatar_src ? asset(Auth::user()->avatar_src) : asset('assets/img/users/Kylian_Mbappé_2018.jpg') }}"
                                    class="rounded-circle" width="40px" height="40px" alt="avatar">
                                <span
                                    class="d-none d-sm-inline text-white fw-semibold">{{ Auth::user()->first_name ?? '' }} {{ Auth::user()->last_name ?? '' }}</span>
                                <i class="fa-solid fa-chevron-down text-white"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 glass-effect"
                                style="border-radius: 15px; background: rgba(22, 24, 29, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.2);">
                                <li class="dropdown-header small text-white px-3 py-2"
                                    style="color: rgba(255, 255, 255, 0.7) !important;">
                                    <i class="fa-solid fa-user-circle me-2"></i>حساب کاربری
                                </li>
                                <li><a class="dropdown-item rounded-3 mx-2 text-white"
                                       href="{{ route('profile.edit') }}" style="color: #ffffff !important;">
                                        <i class="fa-solid fa-user ms-2 text-primary"></i> پروفایل
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider" style="border-top-color: rgba(255, 255, 255, 0.2);">
                                </li>
                                <li><a class="dropdown-item text-danger rounded-3 mx-2" href="{{ url('/logout') }}"
                                       style="color: #ef4444 !important;">
                                        <i class="fa-solid fa-right-from-bracket ms-2"></i> خروج
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main class="container-fluid py-4">
            @yield('content')
        </main>
    </div>
</div>

<div class="overlay"></div>

@stack('scripts')

<!-- External JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Custom JavaScript -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/form-handler.js') }}"></script>
<script>
    // Theme Toggle Functionality
    document.addEventListener('DOMContentLoaded', function () {
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = themeToggle.querySelector('.theme-icon');
        const themeText = themeToggle.querySelector('.theme-text');
        const html = document.documentElement;

        // Get saved theme or default to dark
        const savedTheme = localStorage.getItem('theme') || 'dark';
        html.className = `theme-${savedTheme}`;
        updateThemeButton(savedTheme);

        // Theme toggle event
        themeToggle.addEventListener('click', function () {
            const currentTheme = html.classList.contains('theme-dark') ? 'dark' : 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            html.className = `theme-${newTheme}`;
            localStorage.setItem('theme', newTheme);
            updateThemeButton(newTheme);

            // Add transition effect
            html.style.transition = 'all 0.3s ease';
            setTimeout(() => {
                html.style.transition = '';
            }, 300);
        });

        function updateThemeButton(theme) {
            if (theme === 'dark') {
                themeIcon.className = 'fa-solid fa-moon me-1 theme-icon';
                themeText.textContent = 'تم روشن';
            } else {
                themeIcon.className = 'fa-solid fa-sun me-1 theme-icon';
                themeText.textContent = 'تم تاریک';
            }
        }
    });

    // Hide loading overlay when page is fully loaded
    window.addEventListener('load', function () {
        setTimeout(function () {
            const loadingOverlay = document.getElementById('loadingOverlay');
            if (loadingOverlay) {
                loadingOverlay.style.opacity = '0';
                setTimeout(function () {
                    loadingOverlay.style.display = 'none';
                }, 500);
            }
        }, 500); // Show loading for at least 0.5 second
    });

    let sideBarStatus = true;

    function showSideBar () {
        if (sideBarStatus) {
            document.getElementById('sideBar').style.left = '0%';

            sideBarStatus = false;
        }
        else {
            document.getElementById('sideBar').style.left = '-100%';
            sideBarStatus = true;
        }
    }
</script>

</body>
</html>
