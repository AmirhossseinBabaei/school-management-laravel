@extends('dashboard.layouts.app')

@section('title', 'ایجاد ترم جدید | سیستم مدیریت مدرسه')

@push('styles')
<style>
.btn-pill {
    border-radius: 25px;
}

/* Persian Date Picker Styles */
.persian-datepicker {
    position: relative;
    display: inline-block;
    width: 100%;
}

.persian-datepicker-input {
    width: 100%;
    padding: 12px 45px 12px 15px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    font-size: 14px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.persian-datepicker-input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
    background: rgba(255, 255, 255, 0.15);
}

.persian-datepicker-input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.persian-datepicker-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #007bff;
    font-size: 16px;
    pointer-events: none;
    z-index: 2;
}

.persian-datepicker-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: rgba(22, 24, 29, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    z-index: 1000;
    margin-top: 5px;
    overflow: hidden;
    animation: fadeInUp 0.3s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.persian-datepicker-header {
    background: linear-gradient(135deg, #007bff, #0056b3);
    padding: 15px;
    text-align: center;
    color: white;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.persian-datepicker-nav {
    background: none;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    padding: 5px 10px;
    border-radius: 5px;
    transition: background 0.3s ease;
}

.persian-datepicker-nav:hover {
    background: rgba(255, 255, 255, 0.2);
}

.persian-datepicker-title {
    font-size: 16px;
    font-weight: 600;
}

.persian-datepicker-body {
    padding: 15px;
}

.persian-datepicker-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
    margin-bottom: 10px;
}

.persian-datepicker-weekday {
    text-align: center;
    padding: 8px;
    font-size: 12px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.7);
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
}

.persian-datepicker-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
}

.persian-datepicker-day {
    text-align: center;
    padding: 10px 5px;
    font-size: 14px;
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.3s ease;
    color: #ffffff;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid transparent;
}

.persian-datepicker-day:hover {
    background: rgba(0, 123, 255, 0.3);
    border-color: #007bff;
    transform: scale(1.05);
}

.persian-datepicker-day.selected {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    font-weight: bold;
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
}

.persian-datepicker-day.other-month {
    color: rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.02);
}

.persian-datepicker-day.today {
    background: rgba(40, 167, 69, 0.3);
    border-color: #28a745;
    color: #28a745;
    font-weight: bold;
}

.persian-datepicker-footer {
    padding: 15px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.persian-datepicker-btn {
    flex: 1;
    padding: 8px 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.persian-datepicker-btn-clear {
    background: rgba(220, 53, 69, 0.2);
    color: #dc3545;
    border: 1px solid rgba(220, 53, 69, 0.3);
}

.persian-datepicker-btn-clear:hover {
    background: rgba(220, 53, 69, 0.3);
    transform: translateY(-1px);
}

.persian-datepicker-btn-today {
    background: rgba(40, 167, 69, 0.2);
    color: #28a745;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

.persian-datepicker-btn-today:hover {
    background: rgba(40, 167, 69, 0.3);
    transform: translateY(-1px);
}

.persian-datepicker-btn-close {
    background: rgba(108, 117, 125, 0.2);
    color: #6c757d;
    border: 1px solid rgba(108, 117, 125, 0.3);
}

.persian-datepicker-btn-close:hover {
    background: rgba(108, 117, 125, 0.3);
    transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 768px) {
    .persian-datepicker-dropdown {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 350px;
    }
    
    .persian-datepicker-day {
        padding: 8px 3px;
        font-size: 12px;
    }
}
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="hero glass-effect p-4 mb-4 animate__animated animate__fadeInUp"
         style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="mb-2 gradient-text fw-bold">
                    <i class="fa-solid fa-user-shield me-2"></i>ایجاد ترم جدید
                </h3>
                <p class="text-muted mb-0">افزودن ترم جدید به سیستم</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.terms.index') }}" class="btn bg-secondary btn-pill">
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
                <i class="fa-solid fa-plus me-2"></i>فرم ایجاد ترم
            </h5>
        </div>
        <div class="card-body p-4">
            <form method="post" action="{{ route('dashboard.terms.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-tag me-2 text-primary"></i>نام ترم
                        </label>
                        <input type="text" name="name" class="form-control" placeholder="مثال: نوبت اول، نوبت دوم "
                               value="{{ old('name') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-tag me-2 text-primary"></i>نام مدرسه
                        </label>
                        <select name="school_id" class="form-control" style="cursor: pointer">
                            @foreach($data['schools'] as $school)
                                <option value="{{ $school->id }}">{{ $school->name  }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-tag me-2 text-primary"></i> سال تحصیلی
                        </label>
                        <input type="text" name="study_year" class="form-control" placeholder="مثال:  1404   "
                               value="{{ old('study_year') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-calendar-alt me-2 text-success"></i>از تاریخ
                        </label>
                        <div class="persian-datepicker">
                            <input type="text" id="from-date-picker" name="from_date" class="persian-datepicker-input" 
                                   placeholder="روز/ماه/سال" value="{{ old('from_date') }}" readonly>
                            <i class="fa-solid fa-calendar persian-datepicker-icon"></i>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            <i class="fa-solid fa-calendar-alt me-2 text-warning"></i>تا تاریخ
                        </label>
                        <div class="persian-datepicker">
                            <input type="text" id="to-date-picker" name="to_date" class="persian-datepicker-input" 
                                   placeholder="روز/ماه/سال" value="{{ old('to_date') }}" readonly>
                            <i class="fa-solid fa-calendar persian-datepicker-icon"></i>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('dashboard.terms.index') }}" class="btn bg-danger btn-pill">
                                <i class="fa-solid fa-times me-2"></i>انصراف
                            </a>
                            <button type="submit" class="btn bg-success btn-pill">
                                <i class="fa-solid fa-save me-2"></i>ایجاد نقش
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
class PersianDatePicker {
    constructor(inputId) {
        this.input = document.getElementById(inputId);
        this.dropdown = null;
        this.currentDate = new Date();
        this.selectedDate = null;
        this.isOpen = false;
        
        this.init();
    }
    
    init() {
        this.createDropdown();
        this.bindEvents();
        this.updateInput();
    }
    
    createDropdown() {
        this.dropdown = document.createElement('div');
        this.dropdown.className = 'persian-datepicker-dropdown';
        this.dropdown.style.display = 'none';
        
        this.dropdown.innerHTML = `
            <div class="persian-datepicker-header">
                <button class="persian-datepicker-nav" data-action="prev-month">‹</button>
                <div class="persian-datepicker-title"></div>
                <button class="persian-datepicker-nav" data-action="next-month">›</button>
            </div>
            <div class="persian-datepicker-body">
                <div class="persian-datepicker-weekdays">
                    <div class="persian-datepicker-weekday">ش</div>
                    <div class="persian-datepicker-weekday">ی</div>
                    <div class="persian-datepicker-weekday">د</div>
                    <div class="persian-datepicker-weekday">س</div>
                    <div class="persian-datepicker-weekday">چ</div>
                    <div class="persian-datepicker-weekday">پ</div>
                    <div class="persian-datepicker-weekday">ج</div>
                </div>
                <div class="persian-datepicker-days"></div>
            </div>
            <div class="persian-datepicker-footer">
                <button class="persian-datepicker-btn persian-datepicker-btn-clear">پاک کردن</button>
                <button class="persian-datepicker-btn persian-datepicker-btn-today">امروز</button>
                <button class="persian-datepicker-btn persian-datepicker-btn-close">بستن</button>
            </div>
        `;
        
        document.body.appendChild(this.dropdown);
    }
    
    bindEvents() {
        this.input.addEventListener('click', () => this.toggle());
        
        this.dropdown.addEventListener('click', (e) => {
            if (e.target.classList.contains('persian-datepicker-day')) {
                this.selectDate(e.target.dataset.date);
            } else if (e.target.classList.contains('persian-datepicker-nav')) {
                if (e.target.dataset.action === 'prev-month') {
                    this.previousMonth();
                } else if (e.target.dataset.action === 'next-month') {
                    this.nextMonth();
                }
            } else if (e.target.classList.contains('persian-datepicker-btn-clear')) {
                this.clearDate();
            } else if (e.target.classList.contains('persian-datepicker-btn-today')) {
                this.selectToday();
            } else if (e.target.classList.contains('persian-datepicker-btn-close')) {
                this.close();
            }
        });
        
        document.addEventListener('click', (e) => {
            if (!this.input.contains(e.target) && !this.dropdown.contains(e.target)) {
                this.close();
            }
        });
    }
    
    toggle() {
        if (this.isOpen) {
            this.close();
        } else {
            this.open();
        }
    }
    
    open() {
        this.isOpen = true;
        this.updateCalendar();
        this.positionDropdown();
        this.dropdown.style.display = 'block';
    }
    
    close() {
        this.isOpen = false;
        this.dropdown.style.display = 'none';
    }
    
    positionDropdown() {
        const rect = this.input.getBoundingClientRect();
        this.dropdown.style.position = 'absolute';
        this.dropdown.style.top = (rect.bottom + window.scrollY + 5) + 'px';
        this.dropdown.style.left = rect.left + 'px';
        this.dropdown.style.width = rect.width + 'px';
    }
    
    updateCalendar() {
        const title = this.dropdown.querySelector('.persian-datepicker-title');
        const daysContainer = this.dropdown.querySelector('.persian-datepicker-days');
        
        // Persian month names
        const persianMonths = [
            'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور',
            'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'
        ];
        
        // Convert current date to Persian
        const persianCurrent = this.toPersianDate(this.currentDate);
        const persianYear = persianCurrent.year;
        const persianMonth = persianCurrent.month - 1; // 0-based index
        
        title.textContent = `${persianMonths[persianMonth]} ${persianYear}`;
        
        // Persian month days
        const persianMonthDays = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];
        if (this.isPersianLeapYear(persianYear)) {
            persianMonthDays[11] = 30; // Esfand has 30 days in leap year
        }
        
        const daysInMonth = persianMonthDays[persianMonth];
        
        // Calculate first day of month in Persian calendar
        const firstDayOfMonth = this.getPersianFirstDayOfWeek(persianYear, persianMonth);
        
        daysContainer.innerHTML = '';
        
        // Previous month days
        const prevMonth = persianMonth === 0 ? 11 : persianMonth - 1;
        const prevYear = persianMonth === 0 ? persianYear - 1 : persianYear;
        const prevMonthDays = persianMonth === 0 ? persianMonthDays[11] : persianMonthDays[prevMonth];
        
        for (let i = firstDayOfMonth - 1; i >= 0; i--) {
            const day = prevMonthDays - i;
            const dayElement = this.createDayElement(day, true);
            daysContainer.appendChild(dayElement);
        }
        
        // Current month days
        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = this.createDayElement(day, false);
            const dateStr = `${persianYear}-${String(persianMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            dayElement.dataset.date = dateStr;
            
            // Check if this is selected date
            if (this.selectedDate) {
                const selectedPersian = this.toPersianDate(this.selectedDate);
                if (selectedPersian.year === persianYear && 
                    selectedPersian.month === persianMonth + 1 && 
                    selectedPersian.day === day) {
                    dayElement.classList.add('selected');
                }
            }
            
            // Check if this is today
            const todayPersian = this.toPersianDate(new Date());
            if (todayPersian.year === persianYear && 
                todayPersian.month === persianMonth + 1 && 
                todayPersian.day === day) {
                dayElement.classList.add('today');
            }
            
            daysContainer.appendChild(dayElement);
        }
        
        // Next month days
        const remainingDays = 42 - (firstDayOfMonth + daysInMonth);
        for (let day = 1; day <= remainingDays; day++) {
            const dayElement = this.createDayElement(day, true);
            daysContainer.appendChild(dayElement);
        }
    }
    
    createDayElement(day, isOtherMonth) {
        const dayElement = document.createElement('div');
        dayElement.className = 'persian-datepicker-day';
        if (isOtherMonth) {
            dayElement.classList.add('other-month');
        }
        dayElement.textContent = day;
        return dayElement;
    }
    
    selectDate(dateStr) {
        const [year, month, day] = dateStr.split('-').map(Number);
        // Convert Persian date to Gregorian
        this.selectedDate = this.persianToGregorian(year, month, day);
        this.updateInput();
        this.close();
    }
    
    clearDate() {
        this.selectedDate = null;
        this.updateInput();
        this.close();
    }
    
    selectToday() {
        this.selectedDate = new Date();
        this.updateInput();
        this.close();
    }
    
    previousMonth() {
        const persianCurrent = this.toPersianDate(this.currentDate);
        let newYear = persianCurrent.year;
        let newMonth = persianCurrent.month - 1;
        
        if (newMonth === 0) {
            newMonth = 12;
            newYear--;
        }
        
        this.currentDate = this.persianToGregorian(newYear, newMonth, 1);
        this.updateCalendar();
    }
    
    nextMonth() {
        const persianCurrent = this.toPersianDate(this.currentDate);
        let newYear = persianCurrent.year;
        let newMonth = persianCurrent.month + 1;
        
        if (newMonth === 13) {
            newMonth = 1;
            newYear++;
        }
        
        this.currentDate = this.persianToGregorian(newYear, newMonth, 1);
        this.updateCalendar();
    }
    
    updateInput() {
        if (this.selectedDate) {
            const persianDate = this.toPersianDate(this.selectedDate);
            this.input.value = `${persianDate.day}/${persianDate.month}/${persianDate.year}`;
        } else {
            this.input.value = '';
        }
    }
    
    toPersianDate(date) {
        // Simple and accurate Persian date conversion
        const gYear = date.getFullYear();
        const gMonth = date.getMonth() + 1;
        const gDay = date.getDate();
        
        // Persian epoch: March 22, 622 AD
        const persianEpoch = new Date(622, 2, 22);
        const diffTime = date.getTime() - persianEpoch.getTime();
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
        
        // Calculate Persian year
        let pYear = Math.floor(diffDays / 365.25) + 1;
        let remainingDays = diffDays - Math.floor((pYear - 1) * 365.25);
        
        // Persian months (days in each month)
        const persianMonths = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];
        
        // Check for leap year
        if (this.isPersianLeapYear(pYear)) {
            persianMonths[11] = 30; // Esfand has 30 days in leap year
        }
        
        let pMonth = 1;
        let pDay = 1;
        
        // Find month and day
        for (let i = 0; i < 12; i++) {
            if (remainingDays >= persianMonths[i]) {
                remainingDays -= persianMonths[i];
                pMonth++;
            } else {
                pDay = remainingDays + 1;
                break;
            }
        }
        
        return { year: pYear, month: pMonth, day: pDay };
    }
    
    persianToGregorian(pYear, pMonth, pDay) {
        // Convert Persian date to Gregorian
        const persianEpoch = new Date(622, 2, 22); // March 22, 622 AD
        
        // Calculate total days from Persian epoch
        let totalDays = (pYear - 1) * 365.25;
        
        // Add days from previous months
        const persianMonths = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];
        if (this.isPersianLeapYear(pYear)) {
            persianMonths[11] = 30;
        }
        
        for (let i = 0; i < pMonth - 1; i++) {
            totalDays += persianMonths[i];
        }
        
        totalDays += pDay - 1;
        
        // Create Gregorian date
        const resultDate = new Date(persianEpoch.getTime() + totalDays * 24 * 60 * 60 * 1000);
        return resultDate;
    }
    
    isPersianLeapYear(year) {
        // Persian leap year calculation (more accurate)
        const a = (year + 2346) % 128;
        return a < 29 || (a === 29 && (year + 2346) % 128 < 29);
    }
    
    getPersianFirstDayOfWeek(year, month) {
        // Get first day of week for Persian month (0 = Saturday, 1 = Sunday, etc.)
        const firstDay = this.persianToGregorian(year, month + 1, 1);
        return (firstDay.getDay() + 1) % 7; // Convert to Persian week (Saturday = 0)
    }
}

// Initialize date pickers when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new PersianDatePicker('from-date-picker');
    new PersianDatePicker('to-date-picker');
});
</script>
@endpush
