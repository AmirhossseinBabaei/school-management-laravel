<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ثبت نام | پروژه مدیریت مدرسه</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <style>
        @font-face{font-family:sans;src:url('{{ asset('fonts/Iranian Sans.ttf') }}');}
        body{font-family:sans,system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Noto Sans;min-height:100vh;} 
        .glass{backdrop-filter:saturate(160%) blur(8px);background:rgba(255,255,255,.65);border:1px solid rgba(255,255,255,.6);box-shadow:0 10px 30px rgba(2,6,23,.08);}
        /* Dark glass to match site background */
        .glass{background:rgba(22,24,29,.65);border:1px solid rgba(36,39,48,.5)}
        .brand{font-weight:700;letter-spacing:.2px;color:#e5e7eb}
        .form-control{border-radius:12px;padding:0.75rem 0.9rem;border:1px solid rgba(255,255,255,.15);background:rgba(255,255,255,.06);color:#e5e7eb}
        .form-control::placeholder{color:#9aa3b2}
        .form-control:focus{box-shadow:0 0 0 .25rem rgba(34,197,94,.2);border-color:#22c55e;background:rgba(255,255,255,.08);color:#fff}
        .btn-success{background:#22c55e;border:0;border-radius:12px;padding:.7rem 1rem}
        .btn-success:hover{background:#16a34a}
        .muted{color:#9aa3b2}
        .link{color:#0ea5e9;text-decoration:none}
        .link:hover{text-decoration:underline}
        .error{border-color:#ef4444}
        .scene{position:relative}
        .blob{position:absolute;filter:blur(30px);opacity:.18;z-index:0}
        .blob-1{top:-40px; inset-inline-start:-20px; width:200px; height:200px; background:radial-gradient(circle,#667eea 0%, rgba(102,126,234,0.0) 60%)}
        .blob-2{bottom:-50px; inset-inline-end:-10px; width:220px; height:220px; background:radial-gradient(circle,#22c55e 0%, rgba(34,197,94,0.0) 60%)}
        .content{position:relative; z-index:1}
        /* animated dots background */
        #bg-dots{position:fixed;inset:0;z-index:0;pointer-events:none}
    </style>
</head>
<body class="d-flex align-items-center py-5">
<canvas id="bg-dots"></canvas>
<main class="container">
    <div class="row justify-content-center scene">
        <div class="col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="glass rounded-4 p-4 p-md-5 content">
                <div class="text-center mb-4">
                    <h5 class="brand mb-0">ایجاد حساب کاربری</h5>
                    <div class="small muted">چند فیلد ساده و آماده‌ای</div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger small">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form class="row g-3" method="post" action="{{ route('register') }}">
                    @csrf
                    <div class="col-12">
                        <label class="form-label">نام</label>
                        <input type="text" name="first_name" class="form-control @error('first_name') error @enderror" placeholder="مثلاً علی" value="{{ old('first_name') }}" autocomplete="given-name">
                        @error('first_name')
                            <div class="form-text text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">نام خانوادگی</label>
                        <input type="text" name="last_name" class="form-control @error('last_name') error @enderror" placeholder="مثلاً احمدی" value="{{ old('last_name') }}" autocomplete="family-name">
                        @error('last_name')
                            <div class="form-text text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">ایمیل</label>
                        <input type="email" name="email" class="form-control @error('email') error @enderror" placeholder="example@mail.com" value="{{ old('email') }}" autocomplete="username">
                        @error('email')
                            <div class="form-text text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">شماره تلفن</label>
                        <input type="tel" name="phone" class="form-control @error('phone') error @enderror" placeholder="09xxxxxxxxx" value="{{ old('phone') }}" inputmode="tel" maxlength="13" autocomplete="tel-national">
                        @error('phone')
                            <div class="form-text text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">رمز عبور</label>
                        <input type="password" name="password" class="form-control @error('password') error @enderror" placeholder="••••••••" autocomplete="new-password">
                        @error('password')
                            <div class="form-text text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">تکرار رمز عبور</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" autocomplete="new-password">
                    </div>
                    <div class="col-12 d-grid">
                        <button class="btn btn-success" type="submit">ثبت نام</button>
                    </div>
                </form>
            </div>
            <p class="text-center mt-3 muted">حساب دارید؟ <a class="link" href="{{ route('login') }}">ورود</a></p>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function(){
        var c=document.getElementById('bg-dots');var x=c.getContext('2d');
        function size(){c.width=window.innerWidth;c.height=window.innerHeight}
        size();window.addEventListener('resize',size);
        var dots=[];var N=Math.min(150, Math.floor((c.width*c.height)/17000));
        for(var i=0;i<N;i++){
            var hue=200+Math.random()*60; // blue-green to violet
            dots.push({x:Math.random()*c.width,y:Math.random()*c.height, r:Math.random()*1.6+0.8, vx:(Math.random()-.5)*0.22, vy:(Math.random()-.5)*0.22, a:Math.random()*0.25+0.15, ap:(Math.random()*0.02+0.005)*(Math.random()<.5?-1:1), hue:hue});
        }
        function step(){
            x.clearRect(0,0,c.width,c.height);
            var maxDist=Math.min(160, Math.max(100, Math.hypot(c.width,c.height)/18));
            for(var i=0;i<dots.length;i++){
                var di=dots[i];
                for(var j=i+1;j<dots.length;j++){
                    var dj=dots[j]; var dx=di.x-dj.x, dy=di.y-dj.y; var d2=dx*dx+dy*dy; if(d2<maxDist*maxDist){
                        var alpha=0.12*(1-d2/(maxDist*maxDist)); x.strokeStyle='rgba(148,163,184,'+alpha+')'; x.lineWidth=1; x.beginPath(); x.moveTo(di.x,di.y); x.lineTo(dj.x,dj.y); x.stroke();
                    }
                }
            }
            for(var k=0;k<dots.length;k++){
                var d=dots[k]; d.x+=d.vx; d.y+=d.vy; if(d.x<0||d.x>c.width) d.vx*=-1; if(d.y<0||d.y>c.height) d.vy*=-1; d.a+=d.ap; if(d.a<0.08||d.a>0.45) d.ap*=-1; x.beginPath(); x.fillStyle='hsla('+d.hue+',85%,80%,'+d.a+')'; x.arc(d.x,d.y,d.r,0,Math.PI*2); x.fill();
            }
            requestAnimationFrame(step);
        }
        step();
    })();
</script>
</body>
</html>
