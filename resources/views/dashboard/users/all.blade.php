@extends('dashboard.layouts.app')

@section('title', 'مدیریت کاربران | سیستم مدیریت مدرسه')

@push('styles')
    <style>
        .btn-pill {
            border-radius: 25px;
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
                    <i class="fa-solid fa-users me-2"></i>مدیریت کاربران
                </h3>
                <p class="text-muted mb-0">مدیریت و کنترل دسترسی کاربران سیستم</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary btn-pill">
                    <i class="fa-solid fa-user-plus me-2"></i>افزودن کاربر جدید
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if (session('success'))
        <div class="alert alert-success animate__animated animate__fadeInDown">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger animate__animated animate__fadeInDown">
            <i class="fa-solid fa-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    <!-- Users Table -->
    <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp"
         style="animation-delay: 0.2s;">
        <div class="card-header glass-effect border-0">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="mb-0 gradient-text fw-bold">
                    <i class="fa-solid fa-list me-2"></i>لیست کاربران
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
                            <i class="fa-solid fa-user me-2"></i>نام کاربر
                        </th>
                        <th>
                            <i class="fa-solid fa-envelope me-2"></i>ایمیل
                        </th>
                        <th>
                            <i class="fa-solid fa-phone me-2"></i>تلفن
                        </th>
                        <th>
                            <i class="fa-solid fa-user-shield me-2"></i>نقش
                        </th>
                        <th>
                            <i class="fa-solid fa-calendar me-2"></i>تاریخ ثبت
                        </th>
                        <th class="text-center">
                            <i class="fa-solid fa-cogs me-2"></i>عملیات
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['users'] as $key=>$user)
                        @php $key+=1; @endphp
                        <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ $key * 0.1 }}s;">
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill">{{ $key }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img
                                        src="{{ $user->avatar_src ? asset($user->avatar_src) : asset('assets/img/users/Kylian_Mbappé_2018.jpg') }}"
                                        class="rounded-circle" width="35" height="35" alt="avatar">
                                    <div>
                                        <div class="fw-semibold">{{ $user->first_name . ' ' . $user->last_name }}</div>
                                        <small class="text-muted">کاربر فعال</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-primary">{{ $user->email ?? 'نامشخص' }}</span>
                            </td>
                            <td>
                                <span class="text-muted">{{ $user->phone ?? 'نامشخص' }}</span>
                            </td>
                            <td>
                                        <span class="badge bg-success rounded-pill">
                                            {{ $user->role->name ?? 'نامشخص' }}
                                        </span>
                            </td>
                            <td>
                                <span
                                    class="text-muted">{{ $user->created_at ? $user->created_at : 'نامشخص' }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('dashboard.users.show', ['user' => $user->id]) }}"
                                       class="btn btn-sm btn-primary" title="مشاهده">
                                        <i class="fa-solid fa-eye me-1"></i>مشاهده
                                    </a>
                                    <a href="{{ route('dashboard.users.edit', ['user' => $user->id]) }}"
                                       class="btn btn-sm btn-warning" title="ویرایش">
                                        <i class="fa-solid fa-edit me-1"></i>ویرایش
                                    </a>
                                    <button onclick="confirmDelete({{ $user->id }})"
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
                    {{ $data['users']->links()  }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/fa.json"
                },
                "responsive": true,
                "pageLength": 10,
                "order": [[0, "desc"]],
                "columnDefs": [
                    {"orderable": false, "targets": [6]}
                ]
            });
        });

        // Simple delete confirmation without external libraries
        document.addEventListener('click', function (e) {
            if (e.target.closest('.delete-btn')) {
                e.preventDefault();

                if (confirm('آیا مطمئن هستید که می‌خواهید این مورد را حذف کنید؟')) {
                    const userId = e.target.closest('.delete-btn').dataset.id;
                    const url = "{{ route('dashboard.users.destroy', ':id') }}".replace(':id', userId);

                    // Create form and submit
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();

            let userId = $(this).data('id');
            let url = "{{ route('dashboard.users.destroy', ':id') }}".replace(':id', userId);

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
