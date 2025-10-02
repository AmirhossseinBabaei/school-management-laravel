@extends('dashboard.layouts.app')

@section('title', 'تنظیمات | Bootstrap Admin')

@section('content')
<div class="row g-3">
            <div class="col-lg-6">
              <div class="card shadow-sm">
                <div class="card-header bg-white">عمومی</div>
                <div class="card-body">
                  <form class="row g-3">
                    <div class="col-12">
                      <label class="form-label">نام سیستم</label>
                      <input type="text" class="form-control" value="Bootstrap Admin">
                    </div>
                    <div class="col-12">
                      <label class="form-label">زبان پیشفرض</label>
                      <select class="form-select">
                        <option>فارسی</option>
                        <option>English</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="notifSwitch" checked>
                        <label class="form-check-label" for="notifSwitch">اعلان‌ها فعال باشد</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary">ذخیره</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card shadow-sm">
                <div class="card-header bg-white">امنیت</div>
                <div class="card-body">
                  <form class="row g-3">
                    <div class="col-12">
                      <label class="form-label">کلمه عبور فعلی</label>
                      <input type="password" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">کلمه عبور جدید</label>
                      <input type="password" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">تکرار کلمه عبور جدید</label>
                      <input type="password" class="form-control">
                    </div>
                    <div class="col-12">
                      <button class="btn btn-warning">تغییر کلمه عبور</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
@endsection
