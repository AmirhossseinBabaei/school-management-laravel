@extends('dashboard.layouts.app')

@section('title', 'مشاهده مدرسه  | سیستم مدیریت مدرسه')

@push('styles')
    <style>
        .btn-pill {
            border-radius: 25px;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
            min-width: 120px;
        }

        .info-value {
            color: #ffffff;
            font-weight: 500;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp"
         style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="mb-2 gradient-text fw-bold">
                    <i class="fa-solid fa-eye me-2"></i>مشاهده مدرسه
                </h3>
                <p class="text-muted mb-0">جزئیات مدرسه : <span
                        class="fw-semibold text-primary">{{ $data['school']->name }}</span></p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.schools.edit', $data['school']->id) }}" class="btn bg-warning btn-pill">
                    <i class="fa-solid fa-edit me-2"></i>ویرایش
                </a>
                <a href="{{ route('dashboard.schools.index') }}" class="btn bg-danger btn-pill">
                    <i class="fa-solid fa-arrow-right me-2"></i>بازگشت
                </a>
            </div>
        </div>
    </div>

    <!-- Role Information -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp"
                 style="animation-delay: 0.2s;">
                <div class="card-header glass-effect border-0">
                    <h5 class="mb-0 gradient-text fw-bold">
                        <i class="fa-solid fa-info-circle me-2"></i>اطلاعات مدرسه
                    </h5>
                </div>
                <div class="card-body p-4">

                    <div class="info-card">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa-solid fa-tag me-2 text-primary"></i>نام مدرسه :
                            </div>
                            <div class="info-value">{{ $data['school']->name }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa-solid fa-tag me-2 text-primary"></i>توضیحات مدرسه :
                            </div>
                            <div class="info-value">{{ $data['school']->description }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa-solid fa-tag me-2 text-primary"></i>شماره تلفن مدرسه :
                            </div>
                            <div class="info-value">{{ $data['school']->phone }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa-solid fa-tag me-2 text-primary"></i>ایمیل مدرسه :
                            </div>
                            <div class="info-value">{{ $data['school']->email }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa-solid fa-tag me-2 text-primary"></i>ادرس مدرسه :
                            </div>
                            <div class="info-value">{{ $data['school']->address }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa-solid fa-toggle-on me-2 text-success"></i>وضعیت:
                            </div>
                            <div class="info-value">
                                @if ($data['school']->status == 'فعال')
                                    <span class="badge rounded-pill bg-success">
                                            <i class="fa-solid fa-check me-1"></i>{{ $data['school']->status ?? '' }}
                                        </span>
                                @elseif ($data['school']->status == 'غیر فعال')
                                    <span class="badge rounded-pill bg-danger">
                                            <i class="fa-solid fa-check me-1"></i>{{ $data['school']->status ?? '' }}
                                        </span>
                                @else
                                    <span class="badge rounded-pill bg-warning">
                                            <i class="fa-solid fa-check me-1"></i>{{ $data['school']->status ?? '' }}
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <div id="map"
                                     style="width: 600px;height: 200px; border-radius: 10px; margin-bottom: 20px;"></div>

                                <input type="hidden" id="latitude" name="latitude" readonly required
                                       value="{{ $data['school']->latitude }}">

                                <input type="hidden" id="longitude" name="longitude" readonly required
                                       value="{{ $data['school']->longitude }}">
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa-solid fa-calendar me-2 text-info"></i>تاریخ ایجاد:
                            </div>
                            <div
                                class="info-value">{{ $data['school']->created_at ? $data['school']->created_at : 'نامشخص' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa-solid fa-clock me-2 text-warning"></i>آخرین بروزرسانی:
                            </div>
                            <div
                                class="info-value">{{ $data['school']->updated_at ? $data['school']->updated_at : 'نامشخص' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp"
                 style="animation-delay: 0.3s;">
                <div class="card-header glass-effect border-0">
                    <h5 class="mb-0 gradient-text fw-bold">
                        <i class="fa-solid fa-bolt me-2"></i>اکشن‌های سریع
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        <a href="{{ route('dashboard.schools.edit', $data['school']->id) }}"
                           class="btn bg-warning btn-pill">
                            <i class="fa-solid fa-edit me-2"></i>ویرایش مدرسه
                        </a>
                        <a href="{{ route('dashboard.schools.create') }}" class="btn bg-success btn-pill">
                            <i class="fa-solid fa-plus me-2"></i>ایجاد مدرسه جدید
                        </a>
                        <a href="{{ route('dashboard.schools.index') }}" class="btn bg-primary btn-pill">
                            <i class="fa-solid fa-list me-2"></i>لیست مدرسه ‌ها
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let lat = {{ $data['school']->latitude }};
        let lng = {{ $data['school']->longitude }};

        let map = L.map('map').setView([lat, lng], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        let marker = L.marker([lat, lng], {draggable: true}).addTo(map);

        marker.on('dragend', function (e) {
            let position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat.toFixed(7);
            document.getElementById('longitude').value = position.lng.toFixed(7);
        });

        map.on('click', function (e) {
            let clickLat = e.latlng.lat.toFixed(7);
            let clickLng = e.latlng.lng.toFixed(7);

            marker.setLatLng([clickLat, clickLng]);

            document.getElementById('latitude').value = clickLat;
            document.getElementById('longitude').value = clickLng;
        });

    </script>
@endsection
