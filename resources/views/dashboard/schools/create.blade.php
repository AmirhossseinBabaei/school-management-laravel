@extends('dashboard.layouts.app')

@section('title', 'ایجاد مدرسه جدید | سیستم مدیریت مدرسه')

@push('styles')
    <style>
        .btn-pill {
            border-radius: 25px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp"
         style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="mb-2 gradient-text fw-bold">
                    <i class="fa-solid fa-user-shield me-2"></i>ایجاد مدرسه جدید
                </h3>
                <p class="text-muted mb-0">افزودن مدرسه جدید به سیستم</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.schools.index') }}" class="btn bg-danger btn-pill">
                    <i class="fa-solid fa-arrow-right me-2"></i>بازگشت
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if ($errors->any())
        <div class="alert alert-danger animate__animated animate__fadeInDown">
            <i class="fa-solid fa-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Create Form -->
    <div class="card glass-effect border-0 shadow-lg animate__animated animate__fadeInUp"
         style="animation-delay: 0.2s;">
        <div class="card-header glass-effect border-0">
            <h5 class="mb-0 gradient-text fw-bold">
                <i class="fa-solid fa-plus me-2"></i>فرم ایجاد مدرسه
            </h5>
        </div>
        <div class="card-body p-4">
            <form method="post" action="{{ route('dashboard.schools.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-tag me-2 text-primary"></i>نام مدرسه
                        </label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: مدرسه ی شهید چراغچی"
                               value="{{ old('name') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-tag me-2 text-primary"></i>توضیحات
                        </label>
                        <textarea type="text" name="description" class="form-control" placeholder=" توضیحات مدرسه">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-tag me-2 text-primary"></i>تلفن
                        </label>
                        <input type="text" name="phone" class="form-control" placeholder="شماره تلفن"
                               value="{{ old('phone') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-tag me-2 text-primary"></i>ادرس مدرسه
                        </label>
                        <input type="text" name="address" class="form-control" placeholder="ادرس دقیق"
                               value="{{ old('address') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-tag me-2 text-primary"></i>ایمیل
                        </label>
                        <input type="text" name="email" class="form-control" placeholder="ادرس ایمیل"
                               value="{{ old('email') }}">
                    </div>

                    <div id="map" style="height: 400px; border-radius: 10px; margin-bottom: 20px;"></div>

                        <input type="hidden" id="latitude" name="latitude" readonly required>

                        <input type="hidden" id="longitude" name="longitude" readonly required>
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-toggle-on me-2 text-success"></i>وضعیت
                        </label>

                        <select name="status" class="form-control">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>فعال</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غیر فعال
                            <option value="request" {{ old('status') == 'request' ? 'selected' : '' }}>درخواست
                            </option>
                        </select>
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('dashboard.schools.index') }}" class="btn bg-danger btn-pill">
                                <i class="fa-solid fa-times me-2"></i>انصراف
                            </a>
                            <button type="submit" class="btn bg-success btn-pill">
                                <i class="fa-solid fa-save me-2"></i>ایجاد مدرسه
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        let map = L.map('map').setView([36.2605, 59.6168], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        let marker;

        map.on('click', function(e) {
            let lat = e.latlng.lat.toFixed(7);
            let lng = e.latlng.lng.toFixed(7);

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng]).addTo(map);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });

    </script>
@endsection
