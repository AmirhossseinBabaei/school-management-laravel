@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">ثبت نمرات</h5>
                        <small class="text-muted">تاریخ: {{ $data['nowDate'] ?? '' }}</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-3">
                                <label class="form-label">کلاس</label>
                                <select id="class_id" class="form-select">
                                    <option value="">انتخاب کنید</option>
                                    @if(isset($data['classes']))
                                        @foreach($data['classes'] as $item)
                                            @php($class = $item->classRoom ?? $item)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">درس</label>
                                <select id="lesson_id" class="form-select">
                                    <option value="">انتخاب کنید</option>
                                    @if(isset($data['lessons']))
                                        @foreach($data['lessons'] as $item)
                                            @php($lesson = $item->lesson ?? $item)
                                            <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">ترم</label>
                                <select id="term_id" class="form-select">
                                    <option value="">انتخاب کنید</option>
                                    @if(isset($data['terms']))
                                        @foreach($data['terms'] as $term)
                                            <option value="{{ $term->id }}">{{ $term->name ?? ($term->title ?? ("ترم " . $term->id)) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button id="load_students" class="btn btn-primary w-100">بارگذاری دانش‌آموزان</button>
                            </div>
                        </div>

                        <style>
                            .dataTables_wrapper { color: #ffffff; }
                            .dataTables_wrapper .dataTables_length,
                            .dataTables_wrapper .dataTables_filter,
                            .dataTables_wrapper .dataTables_info,
                            .dataTables_wrapper .dataTables_processing,
                            .dataTables_wrapper .dataTables_paginate { color: #ffffff !important; }
                            .dataTables_wrapper .dataTables_length select,
                            .dataTables_wrapper .dataTables_filter input { background: rgba(22,24,29,.8) !important; color:#fff; }
                            .dataTables_wrapper .dataTables_paginate .paginate_button { background: rgba(22,24,29,.8) !important; color:#fff !important; }
                            .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: linear-gradient(135deg,#667eea 0%,#764ba2 100%) !important; }
                        </style>

                        <div class="table-responsive">
                            <table id="gradesTable" class="table table-hover align-middle" style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نام</th>
                                    <th>نام خانوادگی</th>
                                    <th>نمره</th>
                                    <th>توضیحات</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="mt-3 d-flex justify-content-end gap-2">
                            <button id="submit_grades" class="btn btn-success">ثبت نمرات</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script>
        const studentsWithGradesApi = "{{ route('dashboard.grades.getStudentsWithGrades') }}";
        const storeApi = "{{ route('dashboard.grades.store') }}";

        let dt;
        function ensureDataTable() {
            if (!dt) {
                dt = new window.jQuery.fn.dataTable.Api(jQuery('#gradesTable').DataTable({
                    paging:false,
                    searching: true,
                    info: true,
                    language: { url: '/plugins/datatables/i18n/Persian.lang.json' }
                }));
            }
            return dt;
        }

        document.getElementById('load_students').addEventListener('click', function () {
            const classId = document.getElementById('class_id').value;
            const lessonId = document.getElementById('lesson_id').value;
            const termId = document.getElementById('term_id').value;
            if (!classId || !lessonId || !termId) { alert('کلاس، درس و ترم را انتخاب کنید'); return; }

            fetch(studentsWithGradesApi, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ class_id: Number(classId), lesson_id: Number(lessonId), term_id: Number(termId) })
            })
                .then(r => r.json())
                .then(res => {
                    const api = ensureDataTable();
                    api.clear();
                    (res.students || []).forEach((s, idx) => {
                        const row = [
                            idx + 1,
                            s.first_name,
                            s.last_name,
                            `<input type="number" min="0" max="20" step="0.25" class="form-control form-control-sm score-input" data-student="${s.student_id}" value="${s.score}" />`,
                            `<input type="text" class="form-control form-control-sm desc-input" data-student="${s.student_id}" value="${(s.description||'بدون توضیح').replaceAll('"','&quot;')}" />`
                        ];
                        api.row.add(row);
                    });
                    api.draw();
                })
                .catch(() => alert('خطا در دریافت لیست دانش‌آموزان'));
        });

        document.getElementById('submit_grades').addEventListener('click', function () {
            const classId = document.getElementById('class_id').value;
            const lessonId = document.getElementById('lesson_id').value;
            const termId = document.getElementById('term_id').value;

            const students = [];
            document.querySelectorAll('.score-input').forEach(inp => {
                const studentId = inp.getAttribute('data-student');
                const score = inp.value;
                const desc = document.querySelector(`.desc-input[data-student="${studentId}"]`).value;
                if (score !== '') {
                    students.push({ student_id: Number(studentId), score: Number(score), description: desc || null });
                }
            });

            if (!termId) { alert('ترم را انتخاب کنید'); return; }
            if (students.length === 0) { alert('حداقل یک نمره وارد کنید'); return; }

            fetch(storeApi, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ class_id: Number(classId), lesson_id: Number(lessonId), term_id: Number(termId), students })
            })
                .then(r => r.json())
                .then(res => {
                    if (res.status === 1) { alert('نمرات با موفقیت ثبت شد'); }
                    else { alert('ثبت نمرات ناموفق بود'); }
                })
                .catch(() => alert('خطا در ثبت نمرات'));
        });
    </script>
@endpush


