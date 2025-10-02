@extends('dashboard.layouts.app')

@section('title', 'مدیریت مدرسه ها | سیستم مدیریت مدرسه')

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
                    <i class="fa-solid fa-user-shield me-2"></i>مدیریت مدرسه ها
                </h3>
                <p class="text-muted mb-0">مدیریت مدرسه‌ها </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.schools.create') }}" class="btn bg-warning btn-pill">
                    <i class="fa-solid fa-plus me-2"></i>افزودن مدرسه جدید
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
                    <i class="fa-solid fa-list me-2"></i>لیست مدرسه ها
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
                            <i class="fa-solid fa-user-shield me-2"></i>نام مدرسه
                        </th>
                        <th>
                            <i class="fa-solid fa-user-shield me-2"></i>شماره تلفن
                        </th>
                        <th>
                            <i class="fa-solid fa-user-shield me-2"></i> ایمیل
                        </th>
                        <th>
                            <i class="fa-solid fa-calendar me-2"></i>تاریخ بروزرسانی
                        </th>
                        <th>
                            <i class="fa-solid fa-chart-bar me-2"></i>وضعیت
                        </th>
                        <th class="text-center">
                            <i class="fa-solid fa-cogs me-2"></i>عملیات
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['schools'] as $key=>$school)
                        @php $key+=1; @endphp
                        <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ $key * 0.1 }}s;">
                            <td class="text-center">
                                <span class="badge bg-warning rounded-pill">{{ $key }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div>
                                        <div class="fw-semibold">{{ $school->name ?? 'نامشخص' }}</div>
                                        <small class="text-muted">نام مدرسه</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                    <div>
                                        <div class="fw-semibold">{{ $school->phone ?? 'نامشخص' }}</div>
                                        <small class="text-muted">شماره تلفن</small>
                                    </div>
                            </td>
                        <td>
                                    <div>
                                        <div class="fw-semibold">{{ $school->email ?? 'نامشخص' }}</div>
                                        <small class="text-muted">ایمیل</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="text-muted">{{ $school->updated_at ? $school->updated_at : 'نامشخص' }}</span>
                            </td>
                            <td>
                                @if ($school->status == 'فعال')
                                    <span class="badge rounded-pill bg-success">
                                            <i class="fa-solid fa-check me-1"></i>{{ $school->status ?? '' }}
                                        </span>
                                    @elseif ($school->status == 'غیر فعال')
                                    <span class="badge rounded-pill bg-danger">
                                            <i class="fa-solid fa-check me-1"></i>{{ $school->status ?? '' }}
                                        </span>
                                    @else
                                    <span class="badge rounded-pill bg-warning">
                                            <i class="fa-solid fa-check me-1"></i>{{ $school->status ?? '' }}
                                        </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('dashboard.schools.show', $school->id) }}"
                                       class="btn btn-sm btn-primary" title="مشاهده">
                                        <i class="fa-solid fa-eye me-1"></i>مشاهده
                                    </a>
                                    <a href="{{ route('dashboard.schools.edit', $school->id) }}"
                                       class="btn btn-sm btn-warning" title="ویرایش">
                                        <i class="fa-solid fa-edit me-1"></i>ویرایش
                                    </a>
                                    <button class="btn btn-sm btn-danger delete-btn"
                                            data-id="{{ $school->id }}" title="حذف">
                                        <i class="fa-solid fa-trash me-1"></i>حذف
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $data['schools']->links() }}
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
                if (confirm('آیا مطمئن هستید که می‌خواهید این مدرسه را حذف کنید؟')) {
                    const schoolId = e.target.closest('.delete-btn').dataset.id;
                    const url = "{{ route('dashboard.schools.destroy', ':id') }}".replace(':id', schoolId);
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
