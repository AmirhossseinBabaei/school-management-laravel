@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center no-print">
                        <h5 class="mb-0">کارنامه کلاس</h5>
                        <button class="btn btn-outline-secondary" onclick="window.print()">پرینت</button>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 align-items-end mb-4 no-print">
                            <div class="col-md-3">
                                <label class="form-label">کلاس</label>
                                <select id="class_id" class="form-select">
                                    <option value="">انتخاب کنید</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">ترم</label>
                                <select id="term_id" class="form-select">
                                    <option value="">انتخاب کنید</option>
                                    @foreach($terms as $term)
                                        <option value="{{ $term->id }}">{{ $term->name ?? ($term->title ?? ("ترم ".$term->id)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="auto_calculate_disciplinary" checked>
                                    <label class="form-check-label" for="auto_calculate_disciplinary">
                                        محاسبه خودکار نمره انضباط
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button id="fetch_report" class="btn btn-primary w-100">دریافت کارنامه‌ها</button>
                            </div>
                        </div>

                        <div id="report_cards_container" class="p-0"></div>

                        <style>
                            .sheet.a4 { background: #fff; color: #000; padding: 20mm; border-radius: 8px; margin-bottom: 20px; page-break-after: always; }
                            .sheet-inner { border: 1px solid #cfcfcf; padding: 12px; }
                            .rc-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid #d9d9d9; padding-bottom: 8px; }
                            .rc-left { display: flex; align-items: center; gap: 12px; }
                            .rc-logo { width: 48px; height: 48px; background: #eaeaea; border: 1px solid #d9d9d9; border-radius: 4px; }
                            .rc-title { font-weight: 800; font-size: 18px; }
                            .rc-sub { color: #444; font-size: 12px; }
                            .rc-grid { display: grid; grid-template-columns: 120px 1fr; gap: 4px 12px; font-size: 12px; }
                            .rc-grid > div:nth-child(odd) { color: #444; }
                            .rc-grid > div:nth-child(even) { font-weight: 700; }

                            .rc-table-wrap { width: 100%; overflow-x: auto; }
                            .rc-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; min-width: 640px; }
                            .rc-table th, .rc-table td { border: 1px solid #cfcfcf; padding: 6px 8px; text-align: center; }
                            .rc-table thead th { background: #f3f3f3; }
                            .rc-table tbody td:first-child, .rc-table thead th:first-child { width: 40px; }
                            .rc-table tbody td:nth-child(2) { text-align: right; }
                            @media (max-width: 992px) {
                                .sheet.a4 { padding: 12px; }
                                .rc-title { font-size: 16px; }
                                .rc-grid { grid-template-columns: 90px 1fr; font-size: 11px; }
                                .rc-summary { font-size: 12px; gap: 12px; }
                                .rc-summary strong { font-size: 14px; }
                                .rc-table { font-size: 11px; }
                            }

                            .rc-footer { display: grid; grid-template-columns: 1fr auto; align-items: flex-end; gap: 16px; margin-top: 12px; }
                            .rc-summary { display: flex; gap: 24px; font-size: 13px; }
                            .rc-summary strong { font-size: 16px; }
                            .rc-stamp .stamp-box { width: 200px; height: 100px; border: 2px dashed #bdbdbd; display:flex; align-items:center; justify-content:center; color:#777; }
                            .rc-signs { justify-self: end; text-align: center; }
                            .rc-signs .sign-line { width: 160px; height: 1px; background: #333; margin: 0 auto 6px; }
                            .rc-signs .sign-caption { font-size: 12px; color: #444; }

                            @media print {
                                @page { size: A4 portrait; margin: 10mm; }
                                html, body { background: #fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                                .no-print { display: none !important; }
                                /* Hide common dashboard chrome in print */
                                header, footer, nav, aside,
                                .navbar, .sidebar, .app-header, .app-navbar, .app-sidebar,
                                .page-header, .page-title, .breadcrumb, .footer, .menu, .topbar { display: none !important; }
                                .content, .content-wrapper, .main, .main-content, .container-fluid, .card { margin: 0 !important; padding: 0 !important; box-shadow: none !important; border: 0 !important; }
                                .card, .card-body, .container-fluid { border: none; box-shadow: none; padding: 0; margin: 0; }
                                .sheet.a4 { padding: 0; border-radius: 0; margin-bottom: 0; }
                                .sheet-inner { border: none; }
                                .rc-table tr, .rc-table td, .rc-table th { page-break-inside: avoid; }
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const fetchApi = "{{ route('dashboard.reportCards.class.fetch') }}";
        const defaultYearRange = "{{ $defaultYearRange ?? '' }}";
        const schoolName = "{{ $schoolName ?? '' }}";

        function renderReportCard(data, termText) {
            const first = data.student.first_name || '';
            const last = data.student.last_name || '';
            const national = data.student.national_code || '';

            // try to infer academic year from term title like "ترم 1403-1402"; fallback to current year span
            const yearMatch = termText.match(/(\d{4}[\-\/–]\d{4})/);
            const yearRange = yearMatch ? yearMatch[1] : defaultYearRange;

            const tbody = document.createElement('tbody');
            let sum = 0, cnt = 0;
            (data.grades || []).forEach((g, idx) => {
                const tr = document.createElement('tr');
                const score = typeof g.score === 'number' ? g.score : (parseFloat(g.score) || null);
                if (typeof score === 'number') { sum += score; cnt++; }
                tr.innerHTML = `
                    <td>${idx + 1}</td>
                    <td style="text-align:right">${g.lesson ?? ''}</td>
                    <td>${score ?? ''}</td>
                    <td>${g.class ?? ''}</td>
                    <td>${g.description ?? ''}</td>
                `;
                tbody.appendChild(tr);
            });
            const avg = cnt ? (sum / cnt).toFixed(2) : '-';
            const sumText = cnt ? sum.toFixed(2) : '—';

            const sheet = document.createElement('div');
            sheet.className = 'sheet a4';
            sheet.innerHTML = `
                <div class="sheet-inner">
                    <div class="rc-header">
                        <div class="rc-left">
                            <div class="rc-logo"></div>
                            <div class="rc-school">
                                <div class="rc-title">کارنامه تحصیلی دوره متوسطه</div>
                                <div class="rc-sub">مدرسه: <strong>${schoolName}</strong></div>
                                <div class="rc-sub">سال تحصیلی: <span>${yearRange}</span></div>
                            </div>
                        </div>
                        <div class="rc-right">
                            <div class="rc-grid">
                                <div>نام</div><div>${first}</div>
                                <div>نام خانوادگی</div><div>${last}</div>
                                <div>کد ملی</div><div>${national}</div>
                                <div>ترم</div><div>${termText}</div>
                            </div>
                        </div>
                    </div>

                    <div class="rc-table-wrap">
                        <table class="rc-table">
                            <thead>
                                <tr>
                                    <th style="width:40px">ردیف</th>
                                    <th style="min-width:200px">نام درس</th>
                                    <th style="width:90px">نمره</th>
                                    <th style="min-width:160px">کلاس</th>
                                    <th style="min-width:200px">توضیحات</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="rc-footer">
                        <div class="rc-summary">
                            <div>جمع نمرات: <strong>${sumText}</strong></div>
                            <div>معدل: <strong>${avg}</strong></div>
                        </div>
                        <div class="rc-stamp">
                                <div class="stamp-box">
                                     <img src="https://uploadkon.ir/uploads/0dfd20_25one.png" width="450px" height="250px">
                                  </div>
                        </div>
                        <div class="rc-signs">

                                            <div class="stamp-box">
                                                <img src="https://uploadkon.ir/uploads/83c320_25two.png" width="150px" height="200px">
                                            </div>
                            <div class="sign-line"></div>
                            <div class="sign-caption">امضاء مدیر/مسئول</div>
                        </div>
                    </div>
                </div>
            `;

            const table = sheet.querySelector('.rc-table');
            table.appendChild(tbody);

            return sheet;
        }

        document.getElementById('fetch_report').addEventListener('click', function () {
            const classId = document.getElementById('class_id').value;
            const termId = document.getElementById('term_id').value;
            if (!classId || !termId) {
                alert('کلاس و ترم را انتخاب کنید');
                return;
            }

            const btn = this;
            btn.disabled = true;
            btn.innerHTML = 'در حال دریافت...';

            const autoCalculate = document.getElementById('auto_calculate_disciplinary').checked;

            fetch(fetchApi, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    class_id: Number(classId),
                    term_id: Number(termId),
                    auto_calculate_disciplinary: autoCalculate
                })
            })
                .then(r => r.json())
                .then(res => {
                    btn.disabled = false;
                    btn.innerHTML = 'دریافت کارنامه‌ها';

                    if (res.status === 1) {
                        const container = document.getElementById('report_cards_container');
                        container.innerHTML = '';

                        const termSel = document.getElementById('term_id');
                        const termText = termSel.options[termSel.selectedIndex]?.text || '';

                        if (res.report_cards && res.report_cards.length > 0) {
                            res.report_cards.forEach((reportCard) => {
                                const card = renderReportCard(reportCard, termText);
                                container.appendChild(card);
                            });
                        } else {
                            alert('کارنامه‌ای یافت نشد');
                        }
                    }
                    else {
                        alert(res.message || 'اطلاعاتی یافت نشد');
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = 'دریافت کارنامه‌ها';
                    alert('خطا در دریافت کارنامه‌ها');
                });
        });
    </script>
@endpush

