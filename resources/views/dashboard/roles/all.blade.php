@extends('dashboard.layouts.app')

@section('title', 'مدیریت نقش ها | سیستم مدیریت مدرسه')

@push('styles')
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .btn-pill {
            border-radius: 25px;
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
                    <i class="fa-solid fa-user-shield me-2"></i>مدیریت نقش ها
                </h3>
                <p class="text-muted mb-0">مدیریت نقش‌ها و دسترسی‌های کاربران سیستم</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.roles.create') }}" class="btn bg-warning btn-pill">
                    <i class="fa-solid fa-plus me-2"></i>افزودن نقش جدید
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
                    <i class="fa-solid fa-list me-2"></i>لیست نقش ها
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
                            <i class="fa-solid fa-user-shield me-2"></i>نام نقش
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
                    @foreach($data['roles'] as $key=>$role)
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
                                        <div class="fw-semibold">{{ $role->name ?? 'نامشخص' }}</div>
                                        <small class="text-muted">نقش کاربری</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="text-muted">{{ $role->updated_at ? $role->updated_at : 'نامشخص' }}</span>
                            </td>
                            <td>
                                        <span
                                            class="badge {{ $role->status == 'فعال' ? 'bg-success' : 'bg-danger' }} rounded-pill">
                                            <i class="fa-solid fa-check me-1"></i>{{ $role->status ?? 'فعال' }}
                                        </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('dashboard.roles.show', $role->id) }}"
                                       class="btn btn-sm btn-primary" title="مشاهده">
                                        <i class="fa-solid fa-eye me-1"></i>مشاهده
                                    </a>
                                    <a href="{{ route('dashboard.roles.edit', $role->id) }}"
                                       class="btn btn-sm btn-warning" title="ویرایش">
                                        <i class="fa-solid fa-edit me-1"></i>ویرایش
                                    </a>
                                    <button class="btn btn-sm btn-danger delete-btn"
                                            data-id="{{ $role->id }}" title="حذف">
                                        <i class="fa-solid fa-trash me-1"></i>حذف
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $data['roles']->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();

            let userId = $(this).data('id');
            let url = "{{ route('dashboard.roles.destroy', ':id') }}".replace(':id', userId);

            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: "این عملیات غیرقابل بازگشت است!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'بله، حذف کن!',
                cancelButtonText: 'لغو'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.status === 1) {
                                Swal.fire(
                                    'حذف شد!',
                                    response.message,
                                    'success'
                                );

                                location.reload();
                                $('#row-' + userId).fadeOut(500, function () {
                                    $(this).remove();
                                });
                            } else {
                                Swal.fire(
                                    'خطا!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function (xhr) {
                            Swal.fire(
                                'خطا!',
                                xhr.responseJSON?.message ?? 'مشکلی در ارتباط با سرور رخ داد.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>

@endpush
