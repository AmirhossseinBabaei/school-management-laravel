<!doctype html>
<html lang="fa" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ورود | Bootstrap Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  </head>
  <body class="d-flex align-items-center py-4" style="min-height:100vh;">
    <main class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
          <div class="card shadow-sm">
            <div class="card-body p-4">
                @if ($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error  }}</div>
                    @endforeach
                @endif
              <h5 class="mb-3 text-center">ورود به سیستم</h5>
              <form class="row g-3">
                <div class="col-12">
                  <label class="form-label">ایمیل</label>
                  <input type="email" class="form-control" placeholder="example@mail.com">
                </div>
                <div class="col-12">
                  <label class="form-label">کلمه عبور</label>
                  <input type="password" class="form-control" placeholder="••••••••">
                </div>
                <div class="col-12 d-flex align-items-center justify-content-between">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember">
                    <label class="form-check-label" for="remember">مرا به خاطر بسپار</label>
                  </div>
                  <a href="#" class="small">فراموشی کلمه عبور؟</a>
                </div>
                <div class="col-12 d-grid">
                  <button class="btn btn-primary">ورود</button>
                </div>
              </form>
            </div>
          </div>
          <p class="text-center mt-3">حساب ندارید؟ <a href="#">ثبت نام</a></p>
        </div>
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
