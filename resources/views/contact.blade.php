<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تماس با ما | سامانه مدیریت مدرسه</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:#0b1220;
            --card:#0e1726;
            --text:#e6edf3;
            --muted:#8da2b8;
            --brand:#2dd4bf;
            --accent:#38bdf8;
        }
        html, body { height:100%; }
        body {
            margin:0;
            font-family:"Vazirmatn",system-ui,-apple-system,Segoe UI,Roboto,sans-serif;
            background:radial-gradient(1200px 600px at 50% -100px, rgba(56,189,248,.08), transparent),var(--bg);
            color:var(--text);
        }
        .container {
            width:min(960px,92%);
            margin-inline:auto;
            padding:48px 0 64px;
        }
        header {
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:32px;
        }
        .brand {
            display:flex;
            align-items:center;
            gap:12px;
            text-decoration:none;
            color:var(--text);
            font-weight:800;
        }
        .brand svg {
            filter:drop-shadow(0 6px 24px rgba(56,189,248,.25));
        }
        .card {
            background:linear-gradient(180deg, rgba(56,189,248,.08), rgba(45,212,191,.06));
            border:1px solid rgba(148,163,184,.18);
            box-shadow:0 10px 40px rgba(2,32,71,.28);
            border-radius:18px;
            padding:32px;
            display:grid;
            grid-template-columns:1.1fr 0.9fr;
            gap:36px;
        }
        h1 {
            margin:0 0 16px;
            font-size:34px;
        }
        p {
            margin:0 0 16px;
            color:var(--muted);
            line-height:1.9;
        }
        .contact-info, .contact-form {
            background:var(--card);
            border-radius:16px;
            padding:24px;
            border:1px solid rgba(148,163,184,.18);
        }
        .info-item {
            display:flex;
            gap:14px;
            margin-bottom:18px;
        }
        .info-item span {
            width:40px;
            height:40px;
            border-radius:12px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            background:rgba(45,212,191,.14);
            color:var(--brand);
            font-size:20px;
        }
        form {
            display:grid;
            gap:18px;
        }
        label {
            display:flex;
            flex-direction:column;
            gap:8px;
            font-size:14px;
            color:var(--muted);
        }
        input, textarea {
            border-radius:12px;
            border:1px solid rgba(148,163,184,.28);
            background:rgba(11,18,32,.78);
            color:var(--text);
            padding:12px 14px;
            font-size:15px;
        }
        textarea {
            min-height:140px;
            resize:vertical;
        }
        .actions {
            display:flex;
            justify-content:flex-end;
        }
        button {
            background:linear-gradient(90deg,var(--brand),var(--accent));
            border:none;
            border-radius:12px;
            padding:12px 28px;
            font-weight:700;
            color:#001018;
            cursor:not-allowed;
            opacity:.7;
        }
        .note {
            margin-top:12px;
            font-size:13px;
            color:var(--muted);
            text-align:center;
        }
        .map {
            margin-top:24px;
            border-radius:16px;
            overflow:hidden;
            border:1px solid rgba(148,163,184,.18);
        }
        iframe {
            width:100%;
            height:260px;
            border:0;
        }
        footer {
            margin-top:36px;
            color:var(--muted);
            font-size:14px;
            text-align:center;
        }
        @media (max-width:900px) {
            .card { grid-template-columns:1fr; padding:24px; gap:24px; }
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <a class="brand" href="{{ url('/') }}">
            <svg width="36" height="36" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="4" y="8" width="56" height="48" rx="12" fill="#38bdf8"/>
                <path d="M12 48 L32 20 L52 48" stroke="#001018" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>سامانه مدیریت مدرسه</span>
        </a>
        <a href="{{ route('login') }}" style="color:var(--text);text-decoration:none;font-size:15px;">ورود به سامانه</a>
    </header>

    <div class="card">
        <div class="contact-info">
            <h1>تماس با ما</h1>
            <p>برای ارتباط با تیم پشتیبانی سامانه، می‌توانید از اطلاعات زیر استفاده کنید یا فرم کنار صفحه را تکمیل نمایید.</p>
            <div class="info-item">
                <span>📞</span>
                <div>
                    <strong>صاحب سایت</strong>
                    <div>احمد سلیمی زو</div>
                </div>
            </div>
            <div class="info-item">
                <span>📞</span>
                <div>
                    <strong>شماره تماس</strong>
                    <div>093990008730</div>
                </div>
            </div>
            <div class="info-item">
                <span>✉️</span>
                <div>
                    <strong>ایمیل</strong>
                    <div>support@schoolpromgs.ir</div>
                </div>
            </div>
            <div class="info-item">
                <span>📍</span>
                <div>
                    <strong>آدرس</strong>
                    <div>مشهد، خیابان عبدالمطلب، پلاک ۱۲۳، مدرسه ی شهید چراغچی  </div>
                </div>
            </div>
            <div class="info-item">
                <span>📍</span>
                <div>
                    <strong>حقوق</strong>
                    <div>تمامی حقوق برای مدرسه ی شهید چراغچی محفوظ میباشد</div>
                </div>
            </div>
        </div>

        <div class="contact-form">
            <h2 style="margin:0 0 16px;font-size:26px;">فرم ارتباطی</h2>
            <p style="margin:0 0 20px;">در حال حاضر این فرم صرفاً نمایشی است و برای ارسال پیام باید با اطلاعات تماس کنار صفحه در ارتباط باشید.</p>
            <form>
                <label>
                    نام و نام خانوادگی
                    <input type="text" placeholder="مثال: امیرحسین بابایی" disabled>
                </label>
                <label>
                    ایمیل یا شماره تماس
                    <input type="email" placeholder="مثال: example@email.com" disabled>
                </label>
                <label>
                    موضوع
                    <input type="text" placeholder="در چند کلمه بنویسید..." disabled>
                </label>
                <label>
                    متن پیام
                    <textarea placeholder="پیام خود را بنویسید..." disabled></textarea>
                </label>
                <div class="actions">
                    <button type="button" disabled>ارسال پیام</button>
                </div>
            </form>
            <div class="note">⛔ این فرم برای نمایش است و فعلاً به سرور متصل نیست.</div>
        </div>
    </div>

    <div class="map">
        <iframe title="نقشه دفتر" src="https://maps.google.com/maps?q=Tehran&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
    </div>

    <footer>
        طراحی و توسعه توسط تیم سامانه مدیریت مدرسه
    </footer>
</div>
</body>
</html>

