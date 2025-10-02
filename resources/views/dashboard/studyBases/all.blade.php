@extends('dashboard.layouts.app')

@section('title', 'مدیریت پایه های تحصیلی | سیستم مدیریت مدرسه')

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
            <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp" style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h3 class="mb-2 gradient-text fw-bold">
                            <i class="fa-solid fa-layer-group me-2"></i>مدیریت پایه های تحصیلی
                        </h3>
                        <p class="text-muted mb-0">مدیریت و سازماندهی پایه های تحصیلی مدارس</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.studyBases.create') }}" class="btn btn-primary btn-pill">
                            <i class="fa-solid fa-plus me-2"></i>افزودن پایه جدید
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

            <!-- Study Bases Table -->
            <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                <div class="card-header glass-effect border-0">
                <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 gradient-text fw-bold">
                            <i class="fa-solid fa-list me-2"></i>لیست پایه های تحصیلی
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
                                    <i class="fa-solid fa-layer-group me-2"></i>نام پایه تحصیلی
                                </th>
                                <th>
                                    <i class="fa-solid fa-calendar me-2"></i>تاریخ ایجاد
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
                        @foreach($data['studyBases'] as $key => $studyBase)
                            @php $key+=1; @endphp
                                <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ $key * 0.1 }}s;">
                                    <td class="text-center">
                                        <span class="badge bg-info rounded-pill">{{ $key }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="card-icon" style="width: 40px; height: 40px; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
                                                <i class="fa-solid fa-layer-group text-white"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $studyBase->name ?? 'نامشخص' }}</div>
                                                <small class="text-muted">پایه تحصیلی</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $studyBase->created_at ? $studyBase->created_at : 'نامشخص' }}</small>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $studyBase->updated_at ? $studyBase->updated_at : 'نامشخص' }}</small>
                                    </td>
                                <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('dashboard.studyBases.show', $studyBase->id) }}"
                                               class="btn btn-sm btn-primary" title="مشاهده">
                                                مشاهده
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('dashboard.studyBases.edit', $studyBase->id) }}"
                                               class="btn btn-sm btn-warning" title="ویرایش">
                                                ویرایش
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger delete-btn"
                                                    data-id="{{ $studyBase->id }}" title="حذف">
                                                حذف
                                                <i class="fa-solid fa-trash"></i>
                                        </button>
                                        </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                        <div>
                            {{ $data['studyBases']->links() }}
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
            if (confirm('آیا مطمئن هستید که می‌خواهید این پایه تحصیلی را حذف کنید؟')) {
                const studyBaseId = e.target.closest('.delete-btn').dataset.id;
                const url = "{{ route('dashboard.studyBases.destroy', ':id') }}".replace(':id', studyBaseId);
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
