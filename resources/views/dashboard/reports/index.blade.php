@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">گزارش‌گیری غایبان</h5>
                        <p class="text-muted flex-grow-1">نمایش و تحلیل وضعیت غیبت دانش‌آموزان در بازه‌های زمانی و کلاس‌های مختلف.</p>
                        <a href="{{ route('dashboard.attendance.reports') }}" class="btn btn-primary align-self-start">ورود به گزارش غیبت</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">گزارش‌گیری موارد انضباطی</h5>
                        <p class="text-muted flex-grow-1">ثبت و مشاهده سوابق انضباطی دانش‌آموزان همراه با جمع‌بندی هوشمند.</p>
                        <a href="{{ route('dashboard.disciplinaryRecords.report') }}" class="btn btn-primary align-self-start">ورود به گزارش انضباطی</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


