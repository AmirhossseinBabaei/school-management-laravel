<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>نمونه‌کار | وب اپ مدیریت مدرسه</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#0b1220;--card:#0e1726;--text:#e6edf3;--muted:#8da2b8;--brand:#2dd4bf;--accent:#38bdf8}
        html,body{height:100%}
        body{margin:0;font-family:"Vazirmatn",system-ui,-apple-system,Segoe UI,Roboto,sans-serif;background:radial-gradient(1200px 600px at 50% -100px, rgba(45,212,191,.08), transparent),var(--bg);color:var(--text)}
        .container{width:min(1100px,92%);margin-inline:auto;padding:36px 0}
        header{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px}
        .brand{display:flex;align-items:center;gap:12px;font-weight:800;color:var(--text);text-decoration:none}
        .brand svg{filter:drop-shadow(0 6px 24px rgba(56,189,248,.25))}
        .card{background:linear-gradient(180deg, rgba(56,189,248,.08), rgba(45,212,191,.06));border:1px solid rgba(148,163,184,.18);box-shadow:0 10px 40px rgba(2,32,71,.28);border-radius:16px;overflow:hidden}
        .hero{display:grid;grid-template-columns:1.2fr 1fr;gap:32px;align-items:center;padding:18px}
        .hero h1{margin:0 0 8px;font-size:34px}
        .hero p{margin:0 0 14px;color:var(--muted)}
        .hero .actions{display:flex;gap:12px;flex-wrap:wrap}
        .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:12px;border:1px solid rgba(148,163,184,.22);text-decoration:none;font-weight:700}
        .btn.primary{background:linear-gradient(90deg,var(--brand),var(--accent));color:#001018}
        .btn.ghost{background:transparent;color:var(--text)}
        .preview{background:var(--card);border-top:1px solid rgba(148,163,184,.18);padding:14px}
        .preview iframe{width:100%;height:420px;border:0;border-radius:12px;background:#fff}
        .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:18px}
        .tile{background:var(--card);border:1px solid rgba(148,163,184,.18);border-radius:14px;padding:12px}
        .tile h3{margin:0 0 6px;font-size:16px}
        .tile p{margin:0;color:var(--muted);font-size:14px}

        /* استایل جدید برای بخش دانلود اپ */
        .download-section{background:linear-gradient(135deg, rgba(45,212,191,.1), rgba(56,189,248,.1));border:1px solid rgba(56,189,248,.3);border-radius:16px;padding:32px;margin:32px 0;text-align:center}
        .download-section h2{margin:0 0 12px;font-size:28px;background:linear-gradient(90deg,var(--brand),var(--accent));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
        .download-section p{margin:0 0 24px;color:var(--muted);font-size:16px}
        .download-buttons{display:flex;gap:16px;justify-content:center;flex-wrap:wrap}
        .download-btn{display:flex;align-items:center;gap:12px;padding:16px 24px;background:var(--card);border:2px solid rgba(56,189,248,.4);border-radius:12px;text-decoration:none;color:var(--text);font-weight:600;transition:all 0.3s ease}
        .download-btn:hover{transform:translateY(-2px);border-color:var(--accent);box-shadow:0 8px 25px rgba(56,189,248,.2)}
        .download-icon{font-size:24px}
        .android{color:#3ddc84}
        .ios{color:#007aff}
        .web{color:#ff6b35}

        footer{margin-top:24px;color:var(--muted);font-size:14px}
        @media (max-width:900px){.hero{grid-template-columns:1fr}.preview iframe{height:340px}.grid{grid-template-columns:1fr}.download-buttons{flex-direction:column}}
    </style>
</head>
<body>
<div class="container">
    <header>
        <a class="brand" href="#">
            <svg width="36" height="36" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="8" width="56" height="48" rx="12" fill="#38bdf8"/><path d="M12 48 L32 20 L52 48" stroke="#001018" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>امیر حسین بابایی دولوپر سامانه</span>
        </a>
    </header>

    <section class="card hero">
        <div>
            <h1>پروژه وب اپ مدیریت مدرسهٔ</h1>
            <p>شما با استفاده از این وب اپ میتوانید مدرسه ی خود را مدیریت کنید و برای خود وبسایتی برای مدرسه تان طراحی کنید .</p>
            <div class="actions">
                <a class="btn primary" href="darolfonoon-site/index.html">مشاهده پروژه</a>
                <a class="btn ghost" href="#features">ویژگی‌ها</a>
            </div>
        </div>
        <div class="preview"><iframe title="پیش‌نمایش" src="{{ route('login') }}"></iframe></div>
    </section>

    <section id="features" class="grid">
        <div class="tile"><h3>مدیریت مدرسه</h3><p>مدیریت و انجام تمام فعالیت های یک مدرسه با این وب اپ امکان پذیر است</p></div>
        <div class="tile"><h3>سی آر ام مدرسه</h3><p>طراحی دلخواه وبسایت مدرسه</p></div>
        <div class="tile"><h3>آرشیو مطالب</h3><p>تفکیک اخبار و پست‌ها، جزییات و نظرات.</p></div>
    </section>

    <!-- بخش جدید دانلود اپلیکیشن -->
    <section class="download-section">
        <h2>📱 اپلیکیشن مدرسه</h2>
        <p>همراه مدرسه خود باشید! اپلیکیشن موبایل را دانلود کنید</p>
        <div class="download-buttons">
            <a href="https://appsgeyser.io/19228541/سیستم مدیریت مدرسه" class="download-btn">
                <span class="download-icon android">🤖</span>
                <div>
                    <div style="font-size:12px;color:var(--muted)">دانلود برای</div>
                    <div>اندروید</div>
                </div>
            </a>
            <a href="#" class="download-btn">
                <span class="download-icon ios">🍎</span>
                <div>
                    <div style="font-size:12px;color:var(--muted)">دانلود برای</div>
                    <div>iOS</div>
                </div>
            </a>
            <a href="{{ route('login')  }}" class="download-btn">
                <span class="download-icon web">🌐</span>
                <div>
                    <div style="font-size:12px;color:var(--muted)">نسخه</div>
                    <div>وب اپلیکیشن</div>
                </div>
            </a>
        </div>
        <p style="margin-top:16px;font-size:14px;color:var(--muted)">
            ✅ مشاهده نمرات | 📅 برنامه درسی | 👥 ارتباط با معلمان | 📢 اطلاع‌رسانی
        </p>
    </section>

    <section class="grid" style="margin-top:24px;">
        <div class="tile"><h3><a href="darolfonoon-site/news.html" style="color:inherit;text-decoration:none;">صفحه اخبار</a></h3><p>لیست آخرین اخبار مدرسه.</p></div>
        <div class="tile"><h3><a href="darolfonoon-site/archive.html" style="color:inherit;text-decoration:none;">آرشیو</a></h3><p>مرتب‌سازی و مرور خبرها و پست‌ها.</p></div>
        <div class="tile"><h3><a href="darolfonoon-site/content.html" style="color:inherit;text-decoration:none;">جزییات محتوا</a></h3><p>نمایش یک خبر/پست به‌همراه نظرات.</p></div>
        <div class="tile"><h3><a href="darolfonoon-site/about.html" style="color:inherit;text-decoration:none;">دربارهٔ ما</a></h3><p>معرفی مدرسه و اهداف.</p></div>
        <div class="tile"><h3><a href="darolfonoon-site/about.html" style="color:inherit;text-decoration:none;">مدیریت نوتیف ها</a></h3><p>معرفی مدرسه و اهداف.</p></div>
        <div class="tile"><h3><a href="darolfonoon-site/admissions.html" style="color:inherit;text-decoration:none;">ثبت‌نام</a></h3><p>راهنمای ثبت‌نام و فرم‌ها.</p></div>
    </section>

    <footer>طراحی و توسعه توسط <a href="https://t.me/amirhosseinbabaei">امیر حسین بابایی</a></footer>
</div>
</body>
</html>
