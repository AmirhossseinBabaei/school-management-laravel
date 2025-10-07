@extends('dashboard.layouts.app')

@section('title', 'مدیریت برنامه ریزی معلم ها | سیستم مدیریت برنامه ریزی معلمه')

@push('styles')
    <style>
        .btn-pill {
            border-radius: 25px;
        }

        table thead {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
        }

        table tbody td {
            background: rgba(255, 255, 255, 0.03);
            color: #fff;
        }

        .schedule-cell {
            min-width: 200px;
        }

        <
        style >
            /* افکت شیشه‌ای برای کارت */
        .glass-effect {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* هدر جذاب با گرادیانت */
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            font-size: 1.2rem;
            letter-spacing: 0.5px;
        }

        /* جدول خوشگل‌تر */
        table.table {
            border-collapse: separate;
            border-spacing: 0;
        }

        table.table th {
            background: #2d3748 !important;
            color: #fff !important;
            font-weight: bold;
            font-size: 0.95rem;
            text-transform: uppercase;
        }

        table.table td {
            vertical-align: middle;
            transition: all 0.3s ease-in-out;
        }

        table.table td:hover {
            background: rgba(102, 126, 234, 0.08);
            transform: scale(1.02);
        }

        /* کارت‌های داخل سلول پر شده */
        .schedule-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            color: #fff;
            padding: 8px;
            font-size: 0.9rem;
            line-height: 1.4;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .schedule-card small {
            display: block;
            opacity: 0.9;
            font-size: 0.8rem;
        }

        .btn-edit {
            margin-top: 5px;
            font-size: 0.75rem;
            border-radius: 8px;
        }

        /* دکمه افزودن */
        .add-btn {
            border-radius: 12px;
            font-size: 0.8rem;
            padding: 6px;
            transition: all 0.2s;
        }

        .add-btn:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
            transform: scale(1.05);
        }
    </style>

    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="hero glass-effect p-4 mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="mb-2 gradient-text fw-bold">
                    <i class="fa-solid fa-user-shield me-2"></i>مدیریت برنامه ریزی معلم ها
                </h3>
                <p class="text-muted mb-0">مدیریت و ویرایش برنامه هفتگی معلم‌ها</p>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4 overflow-hidden glass-effect">
        <div class="card-header bg-gradient fw-bold text-white text-center">
            <i class="fa-solid fa-calendar-alt me-2"></i>
            برنامه‌ریزی هفتگی معلمان
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-hover text-center align-middle mb-0" id="scheduleTable">
                <thead class="bg-dark text-white">
                <tr>
                    <th style="width:120px;">🕒 ساعت</th>
                    @foreach(['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'] as $day)
                        <th>{{ $day }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @php
                    $slots = [
                        ['08:00:00','09:30:00'],
                        ['09:30:00','11:00:00'],
                        ['11:00:00','12:30:00'],
                        ['12:30:00','14:00:00'],
                        ['14:00:00','15:30:00'],
                        ['15:30:00','17:00:00'],
                    ];
                @endphp

                @foreach($slots as $slot)
                    <tr>
                        <td class="fw-bold bg-light">
                            {{ substr($slot[0],0,5) }} - {{ substr($slot[1],0,5) }}
                        </td>
                        @foreach(['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'] as $day)
                            @php
                                $record = $data['schedule_teachers']->first(function($item) use ($day, $slot) {
                                    return $item->date_week === $day &&
                                           $item->start_time === $slot[0] &&
                                           $item->finish_time === $slot[1];
                                });
                            @endphp

                            <td class="p-2 slot-cell"
                                data-day="{{ $day }}"
                                data-start="{{ $slot[0] }}"
                                data-finish="{{ $slot[1] }}">

                                @if($record)
                                    <div class="schedule-card p-2 rounded-3 text-white shadow-sm"
                                         style="background: linear-gradient(135deg,#667eea 0%,#764ba2 100%);">
                                        <div class="fw-semibold">{{ $record->lesson->name ?? '' }}</div>
                                        <small>👨‍🏫 {{ $record->teacher->first_name ?? '' }} {{ $record->teacher->last_name ?? '' }}</small><br>
                                        <small>🏫 {{ $record->class->name ?? '' }}</small>
                                        <div class="mt-1">
                                            <button type="button" class="btn btn-sm btn-warning btn-edit w-100">
                                                <i class="fa-solid fa-pen"></i> ویرایش
                                            </button>
                                        </div>
                                    </div>

                                    <!-- hidden select form -->
                                    <div class="edit-form d-none mt-2">
                                        <select class="form-select teacher-select mb-1">
                                            <option value="">انتخاب معلم</option>
                                            @foreach($data['teachers'] as $teacher)
                                                <option value="{{ $teacher->id }}"
                                                        @if($teacher->id==$record->teacher_id) selected @endif>
                                                    {{ $teacher->first_name }} {{ $teacher->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select class="form-select lesson-select mb-1">
                                            <option value="">انتخاب درس</option>
                                            @foreach($data['lessons'] as $lesson)
                                                <option value="{{ $lesson->id }}"
                                                        @if($lesson->id==$record->lesson_id) selected @endif>
                                                    {{ $lesson->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select class="form-select class-select mb-1">
                                            <option value="">انتخاب کلاس</option>
                                            @foreach($data['classes'] as $class)
                                                <option value="{{ $class->id }}"
                                                        @if($class->id==$record->class_id) selected @endif>
                                                    {{ $class->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-success btn-save w-100">ذخیره</button>
                                    </div>
                                @else
                                <!-- for empty cells -->
                                    <div class="edit-form">
                                        <select class="form-select teacher-select mb-1">
                                            <option value="">انتخاب معلم</option>
                                            @foreach($data['teachers'] as $teacher)
                                                <option
                                                    value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                                            @endforeach
                                        </select>
                                        <select class="form-select lesson-select mb-1">
                                            <option value="">انتخاب درس</option>
                                            @foreach($data['lessons'] as $lesson)
                                                <option value="{{ $lesson->id }}">{{ $lesson->name }}</option>
                                            @endforeach
                                        </select>
                                        <select class="form-select class-select mb-1">
                                            <option value="">انتخاب کلاس</option>
                                            @foreach($data['classes'] as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer text-center">
            <button type="button" class="btn btn-lg btn-primary" id="submitSchedule">📤 ثبت تغییرات</button>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        document.addEventListener('click', function (e) {

            // When "Edit" button is clicked
            if (e.target.closest('.btn-edit')) {
                let cell = e.target.closest('.slot-cell');
                cell.querySelector('.schedule-card').classList.add('d-none');
                cell.querySelector('.edit-form').classList.remove('d-none');
            }

            // When "Save" button is clicked
            if (e.target.closest('.btn-save')) {
                let cell = e.target.closest('.slot-cell');
                let teacher = cell.querySelector('.teacher-select').value;
                let lesson = cell.querySelector('.lesson-select').value;
                let klass  = cell.querySelector('.class-select').value;

                if (teacher && lesson && klass) {
                    // Remove old card if exists
                    cell.querySelector('.schedule-card')?.remove();

                    // Create new schedule card
                    let card = document.createElement('div');
                    card.className = "schedule-card p-2 rounded-3 text-white shadow-sm mb-2";
                    card.style.background = "linear-gradient(135deg,#667eea 0%,#764ba2 100%)";
                    card.innerHTML = `
                <div class="fw-semibold">${cell.querySelector('.lesson-select option:checked').text}</div>
                <small>👨‍🏫 ${cell.querySelector('.teacher-select option:checked').text}</small><br>
                <small>🏫 ${cell.querySelector('.class-select option:checked').text}</small>
                <div class="mt-1">
                    <button type="button" class="btn btn-sm btn-warning btn-edit w-100">
                        <i class="fa-solid fa-pen"></i> Edit
                    </button>
                </div>
            `;

                    // Hide edit form and show updated card
                    cell.querySelector('.edit-form').classList.add('d-none');
                    cell.prepend(card);
                } else {
                    alert("Please select all fields");
                }
            }
        });

        // Submit all schedule data
        document.getElementById('submitSchedule').addEventListener('click', function () {
            let data = [];

            // Loop through all schedule cells (existing + new)
            document.querySelectorAll('.slot-cell').forEach(cell => {
                let teacher = cell.querySelector('.teacher-select')?.value;
                let lesson  = cell.querySelector('.lesson-select')?.value;
                let klass   = cell.querySelector('.class-select')?.value;

                // Only push valid filled cells
                if (teacher && lesson && klass) {
                    data.push({
                        teacher_id: teacher,
                        lesson_id: lesson,
                        class_id: klass,
                        start_time: cell.dataset.start,   // precise start time
                        finish_time: cell.dataset.finish, // precise finish time
                        date_week: cell.dataset.day,
                    });
                }
            });

            console.log('Data to send:', data);

            // Send data via AJAX to backend
            fetch("{{ route('dashboard.scheduleTeachers.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ schedules: data })
            })
                .then(res => res.json())
                .then(resp => {
                    console.log(resp);
                    if (resp.status === 1) {
                        alert("✅ Changes saved successfully");
                    } else {
                        alert("❌ Failed to save changes");
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("❌ Connection to server failed");
                });
        });
    </script>

    {{--    <script>--}}
{{--        document.addEventListener('click', function(e) {--}}
{{--            if(e.target.closest('.btn-edit')){--}}
{{--                let cell = e.target.closest('.slot-cell');--}}
{{--                cell.querySelector('.schedule-card').classList.add('d-none');--}}
{{--                cell.querySelector('.edit-form').classList.remove('d-none');--}}
{{--            }--}}

{{--            if(e.target.closest('.btn-save')){--}}
{{--                let cell = e.target.closest('.slot-cell');--}}
{{--                let teacher = cell.querySelector('.teacher-select').value;--}}
{{--                let lesson = cell.querySelector('.lesson-select').value;--}}
{{--                let klass  = cell.querySelector('.class-select').value;--}}

{{--                if(teacher && lesson && klass){--}}
{{--                    cell.querySelector('.schedule-card')?.remove();--}}

{{--                    let card = document.createElement('div');--}}
{{--                    card.className = "schedule-card p-2 rounded-3 text-white shadow-sm mb-2";--}}
{{--                    card.style.background = "linear-gradient(135deg,#667eea 0%,#764ba2 100%)";--}}
{{--                    card.innerHTML = `--}}
{{--                <div class="fw-semibold">${cell.querySelector('.lesson-select option:checked').text}</div>--}}
{{--                <small>👨‍🏫 ${cell.querySelector('.teacher-select option:checked').text}</small><br>--}}
{{--                <small>🏫 ${cell.querySelector('.class-select option:checked').text}</small>--}}
{{--                <div class="mt-1">--}}
{{--                    <button type="button" class="btn btn-sm btn-warning btn-edit w-100">--}}
{{--                        <i class="fa-solid fa-pen"></i> ویرایش--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            `;--}}

{{--                    cell.querySelector('.edit-form').classList.add('d-none');--}}
{{--                    cell.prepend(card);--}}
{{--                } else {--}}
{{--                    alert("لطفا همه فیلدها را انتخاب کنید");--}}
{{--                }--}}
{{--            }--}}
{{--        });--}}

{{--        document.getElementById('submitSchedule').addEventListener('click', function(){--}}
{{--            let data = [];--}}
{{--            document.querySelectorAll('.slot-cell').forEach(cell => {--}}
{{--                let teacher = cell.querySelector('.teacher-select')?.value;--}}
{{--                let lesson  = cell.querySelector('.lesson-select')?.value;--}}
{{--                let klass   = cell.querySelector('.class-select')?.value;--}}

{{--                if(teacher && lesson && klass){--}}
{{--                    data.push({--}}
{{--                        teacher_id: teacher,--}}
{{--                        lesson_id: lesson,--}}
{{--                        class_id: klass,--}}
{{--                        start_time: cell.dataset.start,--}}
{{--                        finish_time: cell.dataset.finish,--}}
{{--                        date_week: cell.dataset.day--}}
{{--                    });--}}
{{--                }--}}
{{--            });--}}

{{--            console.log(data);--}}

{{--            fetch("{{ route('dashboard.scheduleTeachers.store') }}", {--}}
{{--                method: "POST",--}}
{{--                headers: {--}}
{{--                    "Content-Type": "application/json",--}}
{{--                    "X-CSRF-TOKEN": "{{ csrf_token() }}"--}}
{{--                },--}}
{{--                body: JSON.stringify({ schedules: data })--}}
{{--            })--}}
{{--                .then(res => res.json())--}}
{{--                .then(resp => {--}}
{{--                    console.log(resp);--}}
{{--                    if(resp.status === 1){--}}
{{--                        alert("✅ تغییرات با موفقیت ذخیره شد");--}}
{{--                    } else {--}}
{{--                        alert("❌ خطا در ذخیره‌سازی");--}}
{{--                    }--}}
{{--                })--}}
{{--                .catch(err => {--}}
{{--                    console.error(err);--}}
{{--                    alert("❌ ارتباط با سرور برقرار نشد");--}}
{{--                });--}}
{{--        });--}}
{{--    </script>--}}
@endpush
