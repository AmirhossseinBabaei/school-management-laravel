@extends('dashboard.layouts.app')

@section('title', 'مدیریت دانش آموز ها | سیستم مدیریت مدانش آموزه')

@push('styles')
    <style>
        .btn-pill {
            border-radius: 25px;
        }

        /* DataTable Styles */
        .dataTables_wrapper {
            color: #ffffff;
        }

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
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp"
         style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="mb-2 gradient-text fw-bold">
                    <i class="fa-solid fa-user-shield me-2"></i>مدیریت دانش آموز ها
                </h3>
                <p class="text-muted mb-0">مدیریت دانش آموز‌ها </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.students.create') }}" class="btn bg-warning btn-pill">
                    <i class="fa-solid fa-plus me-2"></i>افزودن دانش آموز جدید
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if (session('success'))
        <div class="alert alert-success animate__animated animate__fadeInDown">
            <i class="fa-solid fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger animate__animated animate__fadeInDown">
            <i class="fa-solid fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Roles Table -->
    <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp"
         style="animation-delay: 0.2s;">
        <div class="card-header glass-effect border-0">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="mb-0 gradient-text fw-bold">
                    <i class="fa-solid fa-list me-2"></i>لیست دانش آموز ها
                </h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fa-solid fa-download me-1"></i>خروجی
                    </button>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fa-solid fa-filter me-1"></i>فیلتر
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="dataTable" class="table table-hover align-middle" style="width:100%">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>
                            <i class="fa-solid fa-user-shield me-2"></i>نام
                        </th>
                        <th>
                            <i class="fa-solid fa-user-shield me-2"></i>نام خانوادگی
                        </th>
                        <th>
                            <i class="fa-solid fa-user-shield me-2"></i>شماره تلفن
                        </th>
                        <th>
                            <i class="fa-solid fa-user-shield me-2"></i> رشته ی تحصیلی
                        </th>
                        <th>
                            <i class="fa-solid fa-user-shield me-2"></i> پایه ی تحصیلی
                        </th>
                        <th>
                            <i class="fa-solid fa-calendar me-2"></i>تاریخ بروزرسانی
                        </th>
                        <th class="text-center">
                            <i class="fa-solid fa-cogs me-2"></i>عملیات
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['students'] as $key=>$student)
                        @php $key+=1; @endphp
                        <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ $key * 0.1 }}s;">
                            <td class="text-center">
                                <span class="badge bg-warning rounded-pill">{{ $key }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="card-icon"
                                         style="width: 40px; height: 40px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-user-shield text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $student->user->first_name ?? 'نامشخص' }}</div>
                                        <small class="text-muted">نام دانش آموز</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="card-icon"
                                         style="width: 40px; height: 40px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-user-shield text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $student->user->last_name ?? 'نامشخص' }}</div>
                                        <small class="text-muted">نام خانوادگی دانش آموز</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div>
                                        <div class="fw-semibold">{{ $student->studyField->name ?? 'نامشخص' }}</div>
                                        <small class="text-muted">رشته تحصیلی</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div>
                                        <div class="fw-semibold">{{ $student->user->phone ?? 'نامشخص' }}</div>
                                        <small class="text-muted">شماره تلفن</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div>
                                        <div class="fw-semibold">{{ $student->studyBase->name ?? 'نامشخص' }}</div>
                                        <small class="text-muted">پایه تحصیلی</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="text-muted">{{ $student->updated_at ? $student->updated_at : 'نامشخص' }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('dashboard.students.show', $student->id) }}"
                                       class="btn btn-sm btn-primary" title="مشاهده">
                                        <i class="fa-solid fa-eye me-1"></i>مشاهده
                                    </a>
                                    <a href="{{ route('dashboard.students.edit', $student->id) }}"
                                       class="btn btn-sm btn-warning btn-sm" title="ویرایش">
                                        <i class="fa-solid fa-edit me-1"></i>ویرایش
                                    </a>
                                    <button onclick="confirmDelete({{ $student->id }})"
                                            class="bg-red-500 text-white px-3 py-1 bg-danger btn-sm">
                                        حذف
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $data['students']->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    function confirmDelete(studentId) {
    Swal.fire({
    title: 'آیا مطمئن هستی؟',
    text: "بعد از حذف، امکان بازگشت وجود نداره!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'بله، حذف کن',
    cancelButtonText: 'لغو',
    reverseButtons: true,
    }).then((result) => {
    if (result.isConfirmed) {
    $.ajax({
    url: `/dashboard/students/${studentId}`,
    type: 'DELETE',
    data: {
    _token: $('meta[name="csrf-token"]').attr('content')
    },
    success: function(response) {
    Swal.fire({
    icon: response.status ? 'success' : 'error',
    title: response.message,
    showConfirmButton: false,
    timer: 2000
    });

    if (response.status) {
    setTimeout(() => {
    location.reload();
    }, 2000); // بعد از ۲ ثانیه ریفرش بشه
    }
    },
    error: function() {
    Swal.fire('خطا!', 'یه مشکلی پیش اومد، دوباره تلاش کن.', 'error');
    }
    });
    }
    });
    }
    </script>

@endpush
