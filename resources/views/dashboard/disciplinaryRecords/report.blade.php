@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">گزارش موارد انضباطی</h5>
                        <button class="btn btn-outline-secondary" onclick="window.print()">پرینت</button>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 align-items-end mb-4 no-print">
                            <div class="col-md-4">
                                <label class="form-label">کد ملی دانش‌آموز</label>
                                <input id="national_code" type="text" class="form-control" placeholder="مثال: 0012345678">
                            </div>
                            <div class="col-md-3">
                                <button id="fetch_report" class="btn btn-primary w-100">دریافت گزارش</button>
                            </div>
                        </div>

                        <div id="report_wrapper" class="d-none">
                            <div class="report-card p-4 border rounded-3">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <div class="text-muted small">نام دانش‌آموز:</div>
                                        <div class="fw-bold" id="rc_fullName">-</div>
                                    </div>
                                    <div>
                                        <div class="text-muted small">کلاس:</div>
                                        <div class="fw-bold" id="rc_class">-</div>
                                    </div>
                                </div>

                                <div class="alert alert-info" id="rc_summary">-</div>

                                <h6 class="mt-4">موارد مثبت</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle" id="rc_table_positive">
                                        <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px">ردیف</th>
                                            <th>تاریخ</th>
                                            <th>درس</th>
                                            <th>شدت</th>
                                            <th>نمره</th>
                                            <th>توضیحات</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                                <h6 class="mt-4">موارد منفی</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle" id="rc_table_negative">
                                        <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px">ردیف</th>
                                            <th>تاریخ</th>
                                            <th>درس</th>
                                            <th>شدت</th>
                                            <th>نمره</th>
                                            <th>توضیحات</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const fetchApi = "{{ route('dashboard.disciplinaryRecords.fetch') }}";

        const severityMap = {
            'Complete-Homework': 'تکالیف را کامل انجام دهد',
            'Maintain-Order': 'حفظ نظم',
            'Respect-the-Teacher': 'احترام به معلم',
            'Help-Classmates': 'کمک به همکلاسی‌ها',
            'Be-Punctual': 'وقت‌شناسی',
            'Take-Care-of-School-Property': 'مراقبت از اموال مدرسه',
            'Take-Turns': 'رعایت نوبت',
            'Speak-Honestly': 'راستگویی',
            'Cooperate-in-Group-Work': 'همکاری در کار گروهی',
            'Keep-Clean-and-Neat': 'رعایت نظافت و آراستگی',
            'Participate-Actively-in-Class': 'مشارکت فعال در کلاس',
            'Be-Kind-to-Others': 'مهربانی با دیگران',
            'Follow-School-Rules': 'رعایت قوانین مدرسه',
            'Listen-to-the-Teacher': 'گوش دادن به معلم',
            'Keep-Silent-in-Class': 'سکوت در کلاس',
            'Respect-Elders': 'احترام به بزرگترها',
            'Fulfill-Assigned-Duty': 'انجام وظیفه محول‌شده',
            'Use-Polite-Language': 'به‌کاربردن کلمات محترمانه',
            'Encourage-Others-to-Study': 'ترغیب دیگران به مطالعه',
            'Use-Learning-Materials-Properly': 'استفاده صحیح از وسایل آموزشی',
            'Being-Late': 'دیر آمدن',
            'Not-Doing-Homework': 'انجام ندادن تکالیف',
            'Disrespecting-the-Teacher': 'بی‌احترامی به معلم',
            'Fighting-with-Classmates': 'درگیری با همکلاسی‌ها',
            'Being-Disorganized-in-Class': 'بی‌نظمی در کلاس',
            'Leaving-Class-Without-Permission': 'خروج بدون اجازه از کلاس',
            'Cheating-on-Exam': 'تقلب در امتحان',
            'Making-Noise-in-Class': 'ایجاد سروصدا در کلاس',
            'Damaging-Property': 'خرابکاری/آسیب به اموال',
            'Mocking-Others': 'تمسخر دیگران',
            'Lying': 'دروغ‌گویی',
            'Using-Rude-Language': 'به‌کاربردن کلمات زشت',
            'Ignoring-the-Lesson': 'بی‌توجهی به درس',
            'Throwing-Objects-in-Class': 'پرتاب اشیا در کلاس',
            'Leaving-Without-Coordination': 'ترک کلاس بدون هماهنگی',
            'Bullying-Classmates': 'زورگویی به همکلاسی‌ها',
            'Forgetting-School-Supplies': 'فراموشی وسایل مورد نیاز',
            'Disobeying-Rules': 'سرپیچی از قوانین',
            'Eating-in-Class': 'خوردن در کلاس',
            'Ignoring-Teachers-Warning': 'بی‌توجهی به تذکر معلم'
        };

        document.getElementById('fetch_report').addEventListener('click', function () {
            const national = document.getElementById('national_code').value.trim();
            if (!national) { alert('کد ملی را وارد کنید'); return; }

            fetch(fetchApi, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ national_code: national })
            })
                .then(r => r.json())
                .then(res => {
                    if (res.status !== 1) {
                        alert(res.message || 'اطلاعاتی یافت نشد');
                        return;
                    }

                    const wrapper = document.getElementById('report_wrapper');
                    wrapper.classList.remove('d-none');

                    document.getElementById('rc_fullName').innerText = `${res.student.first_name ?? ''} ${res.student.last_name ?? ''}`.trim();
                    document.getElementById('rc_class').innerText = res.student.class ?? '-';
                    document.getElementById('rc_summary').innerText = res.summary ?? '-';

                    const tbodyPos = document.querySelector('#rc_table_positive tbody');
                    const tbodyNeg = document.querySelector('#rc_table_negative tbody');
                    tbodyPos.innerHTML = '';
                    tbodyNeg.innerHTML = '';

                    (res.positive || []).forEach((item, idx) => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${idx + 1}</td>
                            <td>${item.record_date ?? ''}</td>
                            <td>${item.lesson ?? '-'}</td>
                            <td>${severityMap[item.severity] ?? item.severity ?? ''}</td>
                            <td>${item.score ?? ''}</td>
                            <td>${item.description ?? ''}</td>
                        `;
                        tbodyPos.appendChild(tr);
                    });

                    (res.negative || []).forEach((item, idx) => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${idx + 1}</td>
                            <td>${item.record_date ?? ''}</td>
                            <td>${item.lesson ?? '-'}</td>
                            <td>${severityMap[item.severity] ?? item.severity ?? ''}</td>
                            <td>${item.score ?? ''}</td>
                            <td>${item.description ?? ''}</td>
                        `;
                        tbodyNeg.appendChild(tr);
                    });
                })
                .catch(() => alert('خطا در دریافت گزارش'));
        });
    </script>
@endpush

@push('styles')
    <style>
        @media print {
            @page { size: A4 portrait; margin: 12mm; }
            html, body { background: #fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print,
            header, footer, nav, aside,
            .navbar, .sidebar, .app-header, .app-navbar, .app-sidebar,
            .page-header, .page-title, .breadcrumb, .footer, .menu, .topbar { display: none !important; }

            .container-fluid, .card, .card-body { margin: 0 !important; padding: 0 !important; border: none !important; box-shadow: none !important; }
            .report-card { border: none !important; }
        }
    </style>
@endpush



