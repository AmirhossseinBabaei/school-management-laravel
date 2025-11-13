<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ورود | سامانه مدیریت مدرسه</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Vazirmatn', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(1200px 800px at 80% -200px, rgba(59, 130, 246, 0.16), transparent),
                        radial-gradient(1300px 900px at 20% 120%, rgba(29, 209, 161, 0.12), transparent),
                        #020617;
            color: #e2e8f0;
            padding: 32px 12px;
            position: relative;
            overflow: hidden;
        }

        body::before,
        body::after {
            content: "";
            position: absolute;
            inset: 0;
            opacity: 0.55;
            background:
                radial-gradient(circle at 20% 20%, rgba(148, 163, 184, 0.08) 0, transparent 40%),
                radial-gradient(circle at 80% 0%, rgba(59, 130, 246, 0.18) 0, transparent 55%);
            animation: aurora 16s ease-in-out infinite alternate;
            pointer-events: none;
        }

        body::after {
            opacity: 0.35;
            filter: blur(40px);
            transform: scale(1.05);
            animation-duration: 22s;
        }

        @keyframes aurora {
            0% {
                transform: translate3d(0px, -10px, 0) scale(1.05) rotate(0deg);
            }
            50% {
                transform: translate3d(-32px, 12px, 0) scale(1.08) rotate(-1deg);
            }
            100% {
                transform: translate3d(28px, 18px, 0) scale(1.04) rotate(1deg);
            }
        }

        .grid-noise {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(15, 23, 42, 0.55) 1px, transparent 0),
                linear-gradient(90deg, rgba(15, 23, 42, 0.3) 1px, transparent 0);
            background-size: 90px 90px;
            mix-blend-mode: overlay;
            opacity: 0.18;
            pointer-events: none;
            animation: slow-pan 30s linear infinite;
        }

        @keyframes slow-pan {
            0% { transform: translate3d(0, 0, 0); }
            50% { transform: translate3d(30px, -20px, 0); }
            100% { transform: translate3d(0, 0, 0); }
        }

        .auth-wrapper {
            width: 100%;
            max-width: 460px;
            position: relative;
            z-index: 1;
        }

        .brand {
            display: flex;
            justify-content: center;
            margin-bottom: 28px;
            gap: 12px;
            align-items: center;
        }

        .brand-icon {
            width: 54px;
            height: 54px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.35), rgba(16, 185, 129, 0.3));
            box-shadow: 0 20px 45px rgba(15, 118, 110, 0.28);
            color: #f8fafc;
            font-size: 1.6rem;
            position: relative;
            overflow: hidden;
        }

        .brand-icon::after {
            content: "";
            position: absolute;
            width: 160%;
            height: 160%;
            background: radial-gradient(circle, rgba(148, 163, 184, 0.18), transparent 66%);
            animation: shimmer 18s linear infinite;
        }

        @keyframes shimmer {
            0%   { transform: translate(-40%, -40%) rotate(0deg); }
            50%  { transform: translate(20%, 10%) rotate(160deg); }
            100% { transform: translate(-40%, -40%) rotate(360deg); }
        }

        .brand span {
            font-size: 1.05rem;
            font-weight: 600;
            color: #cbd5f5;
            letter-spacing: 0.6px;
        }

        .auth-card {
            background: rgba(2, 6, 23, 0.65);
            border: 1px solid rgba(37, 99, 235, 0.26);
            border-radius: 28px;
            padding: 36px 32px 42px;
            position: relative;
            overflow: hidden;
            box-shadow:
                0 25px 45px rgba(2, 6, 23, 0.6),
                0 0 0 1px rgba(148, 163, 184, 0.08);
        }

        .auth-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 65% 0%, rgba(59, 130, 246, 0.18), transparent 55%);
            opacity: 0.75;
            mix-blend-mode: screen;
            animation: pulse-soft 11s ease-in-out infinite alternate;
        }

        @keyframes pulse-soft {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.05); opacity: 0.78; }
        }

        .auth-card::after {
            content: "";
            position: absolute;
            inset: 1px;
            border-radius: 26px;
            background: linear-gradient(160deg, rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.9));
            box-shadow: inset 0 1px 0 rgba(148, 163, 184, 0.08);
        }

        .auth-content {
            position: relative;
            z-index: 1;
        }

        .auth-heading {
            text-align: center;
            margin-bottom: 28px;
        }

        .auth-heading h1 {
            font-size: 1.6rem;
            margin-bottom: 10px;
            color: #f8fafc;
            font-weight: 700;
        }

        .auth-heading p {
            font-size: 0.95rem;
            color: rgba(203, 213, 225, 0.7);
            line-height: 1.8;
        }

        form {
            display: grid;
            gap: 22px;
        }

        label {
            display: flex;
            flex-direction: column;
            gap: 12px;
            font-size: 0.92rem;
            color: rgba(203, 213, 225, 0.78);
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            inset-inline-start: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(148, 163, 184, 0.7);
            font-size: 1.1rem;
        }

        input[type="tel"] {
            width: 100%;
            padding: 15px 18px 15px 50px;
            border-radius: 16px;
            border: 1px solid rgba(51, 65, 85, 0.65);
            background: rgba(15, 23, 42, 0.75);
            color: #f8fafc;
            font-size: 1rem;
            letter-spacing: 0.6px;
            transition: all 0.25s ease;
            box-shadow: inset 0 0 0 1px rgba(59, 130, 246, 0.08);
        }

        input[type="tel"]::placeholder {
            color: rgba(148, 163, 184, 0.45);
        }

        input[type="tel"]:focus {
            outline: none;
            border-color: rgba(56, 189, 248, 0.55);
            background: rgba(15, 23, 42, 0.92);
            box-shadow:
                0 0 0 6px rgba(37, 99, 235, 0.15),
                inset 0 0 0 1px rgba(56, 189, 248, 0.25);
        }

        button {
            border: none;
            border-radius: 16px;
            padding: 16px 20px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.95), rgba(6, 182, 212, 0.85));
            color: #0b1120;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.4px;
        }

        button::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(226, 232, 240, 0.6), transparent 55%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow:
                0 16px 35px rgba(37, 99, 235, 0.35),
                0 4px 10px rgba(15, 118, 110, 0.32);
        }

        button:hover::after {
            opacity: 1;
        }

        button:disabled {
            opacity: 0.7;
            cursor: wait;
            box-shadow: none;
        }

        .spinner {
            width: 18px;
            height: 18px;
            border: 3px solid rgba(15, 23, 42, 0.15);
            border-top-color: rgba(15, 23, 42, 0.68);
            border-radius: 50%;
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .footer-note {
            margin-top: 26px;
            text-align: center;
            font-size: 0.86rem;
            color: rgba(148, 163, 184, 0.65);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .footer-note a {
            color: rgba(96, 165, 250, 0.9);
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 520px) {
            .auth-card {
                padding: 28px 24px 34px;
                border-radius: 24px;
            }

            .auth-heading h1 {
                font-size: 1.42rem;
            }

            .brand span {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <div class="grid-noise"></div>

    <div class="auth-wrapper">
        <div class="brand">
            <div class="brand-icon">
                <i class="bi bi-phone"></i>
            </div>
            <span>سامانه مدیریت مدرسه | دسترسی امن</span>
        </div>

        <div class="auth-card">
            <div class="auth-content">
                <div class="auth-heading">
                    <h1>ورود با شماره موبایل</h1>
                    <p>برای ورود، شماره موبایل خود را با دقت وارد کنید تا کد تأیید برای شما ارسال شود.</p>
                </div>
                <form action="{{ route('auth.checkPhone') }}" method="get" id="loginForm">
                    <label>
                        شماره موبایل
                        <div class="input-wrapper">
                            <i class="bi bi-telephone-fill"></i>
                            <input
                                type="tel"
                                name="phone"
                                placeholder="09xxxxxxxxx"
                                required
                                pattern="09[0-9]{9}"
                                maxlength="11"
                                autocomplete="tel"
                            >
                        </div>
                    </label>
                    <button type="submit" id="submitButton">
                        <i class="bi bi-arrow-right-circle"></i>
                        ادامه
                    </button>
                </form>
                <div class="footer-note">
                    <span>دسترسی فقط برای کاربران مجاز مدرسه فعال است.</span>
                    <a href="https://schoolpromgs.ir" target="_blank" rel="noopener">مشاهده اطلاعات بیشتر</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const loginForm = document.getElementById('loginForm');
        const submitButton = document.getElementById('submitButton');

        loginForm.addEventListener('submit', function () {
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner"></span> در حال ارسال...';
        });

        document.querySelector('input[name="phone"]').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0 && !value.startsWith('09')) {
                value = '09' + value;
            }
            if (value.length > 11) {
                value = value.slice(0, 11);
            }
            e.target.value = value;
        });
    </script>
</body>
</html>
