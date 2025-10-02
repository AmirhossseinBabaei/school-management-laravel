@extends('dashboard.layouts.app')

@section('title', 'مدیریت  نوتیفیکیشن ها | سیستم مدیریت مدرسه')

@push('styles')
    <style>
        .btn-pill {
            border-radius: 25px;
        }
        /* DataTable Styles */
        .dataTables_wrapper { color: #ffffff; }
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
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp"
         style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="mb-2 gradient-text fw-bold">
                    <i class="fa-solid fa-user-shield me-2"></i>مدیریت نوتیفیکیشن ها
                </h3>
                <p class="text-muted mb-0">مدیریت نوتیفیکیشن‌ها و دسترسی‌های کاربران سیستم</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.notifications.create') }}" class="btn bg-warning btn-pill">
                    <i class="fa-solid fa-plus me-2"></i>افزودن نوتیفیکیشن جدید
                </a>
                <a href="{{ route('dashboard.notifications.allFailed') }}" class="btn bg-danger btn-pill">
                   نوتیفیکیشن های ارسال نشده
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
                    <i class="fa-solid fa-list me-2"></i>لیست نوتیفیکیشن ها
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
                            <i class="fa-solid fa-user-shield me-2"></i>عنوان
                        </th>
                        <th>
                            <i class="fa-solid fa-user-shield me-2"></i>متن پیام
                        </th>
                        <th>
                            <i class="fa-solid fa-calendar me-2"></i>تاریخ ارسال
                        </th>
                        <th>
                            <i class="fa-solid fa-chart-bar me-2"></i>وضعیت
                        </th>
                        <th>
                            <i class="fa-solid fa-users me-2"></i>گیرنده ها
                        </th>
                        <th>
                            <i class="fa-solid fa-bars me-2"></i>کانال ها
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['notifications'] as $key=>$notification)
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
                                        <div class="fw-semibold">{{ $notification->title ?? 'نامشخص' }}</div>
                                        <small class="text-muted"> نوتیفیکیشن کاربری</small>
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
                                        <div class="fw-semibold"><small>{{ $notification->message ?? 'نامشخص' }}</small>
                                        </div>
                                        <small class="text-muted"> نوتیفیکیشن کاربری</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="text-muted">{{ $notification->updated_at ? $notification->updated_at : 'نامشخص' }}</span>
                            </td>
                            <td>
                                        <span
                                            class="badge {{ $notification->status == 'ارسال شده' ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                            <i class="fa-solid fa-check me-1"></i>{{ $notification->status ?? 'فعال' }}
                                        </span>
                            </td>
                            <td>
                                <p>{{ $notification->audience_data }}</p>
                            </td>
                            <td>
                                <p>{{ $notification->channels  }}</p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $data['notifications']->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Simple delete confirmation without external libraries
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-btn')) {
                e.preventDefault();
                if (confirm('آیا مطمئن هستید که می‌خواهید این نوتیفیکیشن را حذف کنید؟')) {
                    const notificationId = e.target.closest('.delete-btn').dataset.id;
                    const url = "{{ route('dashboard.notifications.destroy', ':id') }}".replace(':id', notificationId);
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    const tokenField = document.createElement('input');
                    tokenField.type = 'hidden';
                    tokenField.name = '_token';
                    tokenField.value = '{{ csrf_token() }}';
                    form.appendChild(methodField);
                    form.appendChild(tokenField);
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        });
    </script>
@endpush
