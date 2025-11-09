@extends('dashboard.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">ثبت موارد انضباطی</h5>
                    </div>

                    @if (session('success'))
                        <div class="col-4 text-success">{{ session('success') }}</div>
                        @endif

                    @if (session('error'))
                        <div class="col-4 text-danger">{{ session('error') }}</div>
                    @endif
                    <form action="{{ route('dashboard.disciplinaryRecords.store') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">کد ملی دانش‌آموز</label>
                                    <input name="national_code" id="national_code" type="text" class="form-control"
                                           placeholder="مثال: 0012345678">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">درس (اختیاری)</label>
                                    <select name="lesson_id" id="lesson_id" class="form-select">
                                        <option value="">انتخاب کنید</option>
                                        @foreach($lessons as $lesson)
                                            <option
                                                value="{{ $lesson->id }}">{{ $lesson->name ?? $lesson->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            <div class="col-md-4">
                                <label class="form-label">نوع</label>
                                <select name="type" id="type" class="form-select">
                                    <option value="positive">مثبت</option>
                                    <option value="negative">منفی</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">شدت</label>
                                <select name="severity" id="severity" class="form-select">
                                    <option value="Complete-Homework">تکالیف را کامل انجام دهد</option>
                                    <option value="Maintain-Order">حفظ نظم</option>
                                    <option value="Respect-the-Teacher">احترام به معلم</option>
                                    <option value="Help-Classmates">کمک به همکلاسی‌ها</option>
                                    <option value="Be-Punctual">وقت‌شناسی</option>
                                    <option value="Take-Care-of-School-Property">مراقبت از اموال مدرسه</option>
                                    <option value="Take-Turns">رعایت نوبت</option>
                                    <option value="Speak-Honestly">راستگویی</option>
                                    <option value="Cooperate-in-Group-Work">همکاری در کار گروهی</option>
                                    <option value="Keep-Clean-and-Neat">رعایت نظافت و آراستگی</option>
                                    <option value="Participate-Actively-in-Class">مشارکت فعال در کلاس</option>
                                    <option value="Be-Kind-to-Others">مهربانی با دیگران</option>
                                    <option value="Follow-School-Rules">رعایت قوانین مدرسه</option>
                                    <option value="Listen-to-the-Teacher">گوش دادن به معلم</option>
                                    <option value="Keep-Silent-in-Class">سکوت در کلاس</option>
                                    <option value="Respect-Elders">احترام به بزرگترها</option>
                                    <option value="Fulfill-Assigned-Duty">انجام وظیفه محول‌شده</option>
                                    <option value="Use-Polite-Language">به‌کاربردن کلمات محترمانه</option>
                                    <option value="Encourage-Others-to-Study">ترغیب دیگران به مطالعه</option>
                                    <option value="Use-Learning-Materials-Properly">استفاده صحیح از وسایل آموزشی</option>
                                    <option value="Being-Late">دیر آمدن</option>
                                    <option value="Not-Doing-Homework">انجام ندادن تکالیف</option>
                                    <option value="Disrespecting-the-Teacher">بی‌احترامی به معلم</option>
                                    <option value="Fighting-with-Classmates">درگیری با همکلاسی‌ها</option>
                                    <option value="Being-Disorganized-in-Class">بی‌نظمی در کلاس</option>
                                    <option value="Leaving-Class-Without-Permission">خروج بدون اجازه از کلاس</option>
                                    <option value="Cheating-on-Exam">تقلب در امتحان</option>
                                    <option value="Making-Noise-in-Class">ایجاد سروصدا در کلاس</option>
                                    <option value="Damaging-Property">خرابکاری/آسیب به اموال</option>
                                    <option value="Mocking-Others">تمسخر دیگران</option>
                                    <option value="Lying">دروغ‌گویی</option>
                                    <option value="Using-Rude-Language">به‌کاربردن کلمات زشت</option>
                                    <option value="Ignoring-the-Lesson">بی‌توجهی به درس</option>
                                    <option value="Throwing-Objects-in-Class">پرتاب اشیا در کلاس</option>
                                    <option value="Leaving-Without-Coordination">ترک کلاس بدون هماهنگی</option>
                                    <option value="Bullying-Classmates">زورگویی به همکلاسی‌ها</option>
                                    <option value="Forgetting-School-Supplies">فراموشی وسایل مورد نیاز</option>
                                    <option value="Disobeying-Rules">سرپیچی از قوانین</option>
                                    <option value="Eating-in-Class">خوردن در کلاس</option>
                                    <option value="Ignoring-Teachers-Warning">بی‌توجهی به تذکر معلم</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">نمره (اختیاری)</label>
                                <input name="score" id="score" type="number" step="0.25" min="0" max="20" class="form-control" placeholder="مثلاً 5 یا 10" />
                            </div>
                            <div class="col-12">
                                <label class="form-label">توضیحات</label>
                                <textarea id="description" name="description" class="form-control" rows="4"
                                          placeholder="توضیحات مورد انضباطی..."></textarea>
                            </div>
                        </div>

                        <input type="submit" class="btn bg-success btn-pill" value="ثبت">
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

