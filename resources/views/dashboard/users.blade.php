@extends('dashboard.layouts.app')

@section('title', 'کاربران | Bootstrap Admin')

@section('content')
<div class="row g-3">
            <div class="col-xl-3 col-md-4">
              <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                  <img src="https://i.pravatar.cc/120?img=1" class="rounded-circle mb-3" width="96" height="96" alt="avatar">
                  <div class="fw-bold">علی رضایی</div>
                  <div class="text-secondary mb-3">مدیر</div>
                  <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-sm btn-outline-primary">نمایه</button>
                    <button class="btn btn-sm btn-outline-danger">حذف</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-4">
              <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                  <img src="https://i.pravatar.cc/120?img=2" class="rounded-circle mb-3" width="96" height="96" alt="avatar">
                  <div class="fw-bold">مریم محمدی</div>
                  <div class="text-secondary mb-3">کارشناس</div>
                  <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-sm btn-outline-primary">نمایه</button>
                    <button class="btn btn-sm btn-outline-danger">حذف</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-4">
              <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                  <img src="https://i.pravatar.cc/120?img=3" class="rounded-circle mb-3" width="96" height="96" alt="avatar">
                  <div class="fw-bold">حسین احمدی</div>
                  <div class="text-secondary mb-3">پشتیبانی</div>
                  <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-sm btn-outline-primary">نمایه</button>
                    <button class="btn btn-sm btn-outline-danger">حذف</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection
