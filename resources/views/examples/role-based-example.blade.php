@extends('dashboard.layouts.app')

@section('title', 'مثال استفاده از کامپوننت‌های سطح دسترسی')

@section('content')
    <!-- Page Header -->
    <x-page-header 
        title="مثال کامپوننت‌های سطح دسترسی"
        subtitle="نمایش نحوه استفاده از کامپوننت‌های مبتنی بر نقش"
        icon="fa-solid fa-shield-halved"
    >
        <x-slot name="actions">
            <x-button variant="primary" icon="fa-solid fa-plus">
                افزودن
            </x-button>
        </x-slot>
    </x-page-header>

    <!-- Admin Only Section -->
    <x-admin-only>
        <x-card title="بخش مدیران" type="danger" icon="fa-solid fa-crown">
            <p>این بخش فقط برای مدیران قابل مشاهده است.</p>
            <x-button variant="danger" icon="fa-solid fa-trash">
                حذف همه
            </x-button>
        </x-card>
    </x-admin-only>

    <!-- Teacher and Higher Section -->
    <x-teacher-only>
        <x-card title="بخش معلمان" type="warning" icon="fa-solid fa-chalkboard-teacher">
            <p>این بخش برای معلمان و بالاتر قابل مشاهده است.</p>
            <x-button variant="warning" icon="fa-solid fa-edit">
                ویرایش
            </x-button>
        </x-card>
    </x-teacher-only>

    <!-- Role Gate Example -->
    <x-role-gate :roles="['مدیر', 'معاون']">
        <x-card title="بخش مدیران و معاونان" type="info" icon="fa-solid fa-users">
            <p>این بخش فقط برای مدیران و معاونان قابل مشاهده است.</p>
        </x-card>
    </x-role-gate>

    <!-- Role Gate with Fallback -->
    <x-role-gate :roles="['مدیر']" :fallback="true">
        <x-card title="بخش ویژه مدیران" type="success" icon="fa-solid fa-star">
            <p>این بخش فقط برای مدیران قابل مشاهده است.</p>
        </x-card>
        
        <x-slot name="fallback">
            <x-alert type="warning" icon="fa-solid fa-lock">
                شما دسترسی لازم را برای مشاهده این بخش ندارید.
            </x-alert>
        </x-slot>
    </x-role-gate>

    <!-- Form Example with Role-based Fields -->
    <x-card title="فرم با فیلدهای مبتنی بر نقش" type="glass" icon="fa-solid fa-form">
        <x-form method="POST" action="#">
            <div class="row g-3">
                <div class="col-12">
                    <x-input
                        name="name"
                        label="نام"
                        placeholder="نام خود را وارد کنید"
                        icon="fa-solid fa-user"
                        required
                    />
                </div>

                <!-- Admin Only Field -->
                <x-admin-only>
                    <div class="col-12">
                        <x-input
                            name="admin_field"
                            label="فیلد ویژه مدیران"
                            placeholder="این فیلد فقط برای مدیران است"
                            icon="fa-solid fa-crown"
                        />
                    </div>
                </x-admin-only>

                <!-- Teacher Only Field -->
                <x-teacher-only>
                    <div class="col-12">
                        <x-select
                            name="teacher_field"
                            label="انتخاب ویژه معلمان"
                            icon="fa-solid fa-chalkboard-teacher"
                            :options="['1' => 'گزینه 1', '2' => 'گزینه 2']"
                        />
                    </div>
                </x-teacher-only>

                <div class="col-12">
                    <div class="d-flex gap-2">
                        <x-button variant="primary" type="submit" icon="fa-solid fa-save">
                            ذخیره
                        </x-button>
                        
                        <x-button variant="secondary" type="button" icon="fa-solid fa-times">
                            انصراف
                        </x-button>
                    </div>
                </div>
            </div>
        </x-form>
    </x-card>

    <!-- Data Table Example -->
    <x-card title="جدول داده‌ها" type="glass" icon="fa-solid fa-table">
        <x-data-table 
            :headers="['نام', 'نقش', 'وضعیت', 'عملیات']"
            :data="[
                ['احمد محمدی', 'مدیر', 'فعال', 'ویرایش'],
                ['فاطمه احمدی', 'معلم', 'فعال', 'ویرایش'],
                ['علی رضایی', 'معلم', 'غیرفعال', 'ویرایش']
            ]"
        />
    </x-card>

    <!-- Modal Example -->
    <x-button variant="primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        باز کردن مودال
    </x-button>

    <x-modal 
        id="exampleModal"
        title="مودال نمونه"
        size="lg"
    >
        <p>این یک مودال نمونه است که با کامپوننت‌های اسلوت ایجاد شده است.</p>
        
        <x-slot name="footer">
            <x-button variant="secondary" data-bs-dismiss="modal">
                بستن
            </x-button>
            <x-button variant="primary">
                تایید
            </x-button>
        </x-slot>
    </x-modal>
@endsection

