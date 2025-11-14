<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تأیید کد | سامانه مدیریت مدرسه</title>
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
            background: radial-gradient(1200px 800px at 90% -200px, rgba(99, 102, 241, 0.16), transparent),
                        radial-gradient(1200px 1200px at 0% 100%, rgba(45, 212, 191, 0.12), transparent),
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
                radial-gradient(circle at 20% 15%, rgba(148, 163, 184, 0.08) 0, transparent 40%),
                radial-gradient(circle at 80% -10%, rgba(59, 130, 246, 0.18) 0, transparent 55%);
            animation: aurora 18s ease-in-out infinite alternate;
            pointer-events: none;
        }

        body::after {
            opacity: 0.32;
            filter: blur(42px);
            transform: scale(1.08);
            animation-duration: 23s;
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
            animation: slow-pan 34s linear infinite;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 1;
        }

        .brand {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.38), rgba(6, 182, 212, 0.32));
            box-shadow: 0 22px 48px rgba(49, 46, 129, 0.32);
            color: #f8fafc;
            font-size: 1.7rem;
            position: relative;
            overflow: hidden;
        }

        .brand span {
            font-size: 1.05rem;
            font-weight: 600;
            color: #cbd5f5;
            letter-spacing: 0.6px;
        }

        .auth-card {
            background: rgba(2, 6, 23, 0.68);
            border: 1px solid rgba(79, 70, 229, 0.3);
            border-radius: 28px;
            padding: 38px 34px 44px;
            position: relative;
            overflow: hidden;
            box-shadow:
                0 30px 55px rgba(2, 6, 23, 0.62),
                0 0 0 1px rgba(148, 163, 184, 0.1);
        }

        .auth-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 75% 0%, rgba(59, 130, 246, 0.16), transparent 55%),
                radial-gradient(circle at 20% 90%, rgba(56, 189, 248, 0.12), transparent 60%);
            mix-blend-mode: screen;
            opacity: 0.8;
            animation: pulse-soft 13s ease-in-out infinite alternate;
        }

        .auth-card::after {
            content: "";
            position: absolute;
            inset: 1px;
            border-radius: 26px;
            background: linear-gradient(160deg, rgba(15, 23, 42, 0.86), rgba(15, 23, 42, 0.92));
            box-shadow: inset 0 1px 0 rgba(148, 163, 184, 0.08);
        }

        .auth-content {
            position: relative;
            z-index: 1;
        }

        .auth-heading {
            text-align: center;
            margin-bottom: 26px;
        }

        .auth-heading h1 {
            font-size: 1.58rem;
            margin-bottom: 10px;
            color: #f8fafc;
            font-weight: 700;
        }

        .auth-heading p {
            font-size: 0.94rem;
            color: rgba(203, 213, 225, 0.7);
            line-height: 1.8;
        }

        .phone-display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: rgba(15, 23, 42, 0.8);
            padding: 14px 18px;
            border-radius: 16px;
            border: 1px solid rgba(56, 189, 248, 0.28);
            color: rgba(226, 232, 240, 0.92);
            font-weight: 600;
            margin-bottom: 28px;
            box-shadow: inset 0 0 0 1px rgba(59, 130, 246, 0.08);
        }

        .phone-display i {
            color: rgba(56, 189, 248, 0.85);
            font-size: 1.1rem;
        }

        form {
            display: grid;
            gap: 24px;
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
            inset-inline-start: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(96, 165, 250, 0.75);
            font-size: 1.1rem;
        }

        input[name="verficationCode"] {
            width: 100%;
            padding: 18px 20px 18px 58px;
            border-radius: 18px;
            border: 1px solid rgba(51, 65, 85, 0.65);
            background: rgba(15, 23, 42, 0.78);
            color: #f8fafc;
            font-size: 1.6rem;
            letter-spacing: 12px;
            text-align: center;
            transition: all 0.25s ease;
            box-shadow: inset 0 0 0 1px rgba(129, 140, 248, 0.18);
            font-family: "Vazirmatn", sans-serif;
        }

        input[name="verficationCode"]::placeholder {
            color: rgba(148, 163, 184, 0.35);
            letter-spacing: 8px;
        }

        input[name="verficationCode"]:focus {
            outline: none;
            border-color: rgba(62, 166, 255, 0.65);
            background: rgba(15, 23, 42, 0.9);
            box-shadow:
                0 0 0 6px rgba(79, 70, 229, 0.14),
                inset 0 0 0 1px rgba(56, 189, 248, 0.32);
        }

        button {
            border: none;
            border-radius: 16px;
            padding: 16px 20px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.92), rgba(22, 163, 74, 0.88));
            color: #022c22;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            letter-spacing: 0.4px;
            width: 100%;
        }

        button::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(226, 232, 240, 0.55), transparent 55%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow:
                0 18px 38px rgba(22, 163, 74, 0.35),
                0 4px 10px rgba(22, 101, 52, 0.36);
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
            border: 3px solid rgba(15, 23, 42, 0.18);
            border-top-color: rgba(15, 23, 42, 0.7);
            border-radius: 50%;
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 4px;
        }

        .edit-link {
            text-decoration: none;
            color: rgba(148, 163, 184, 0.86);
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .edit-link:hover {
            color: rgba(191, 219, 254, 0.95);
            transform: translateX(-3px);
        }

        .support-hint {
            margin-top: 22px;
            font-size: 0.86rem;
            color: rgba(148, 163, 184, 0.65);
            text-align: center;
        }

        @media (max-width: 520px) {
            .auth-card {
                padding: 30px 24px 36px;
                border-radius: 24px;
            }

            .auth-heading h1 {
                font-size: 1.42rem;
            }

            input[name="verficationCode"] {
                font-size: 1.4rem;
                letter-spacing: 10px;
                padding: 16px 18px 16px 54px;
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
                <i class="bi bi-shield-check"></i>
            </div>
            <span>تأیید امنیتی | سامانه مدیریت مدرسه</span>
        </div>

        <div class="auth-card">
            <div class="auth-content">
                <div class="auth-heading">
                    <h1>کد امنیتی را وارد کنید</h1>
                    <p>کد شش رقمی ارسال شده به شماره همراه شما برای تکمیل ورود الزامی است.</p>
                </div>

                <div class="phone-display">
                    <i class="bi bi-telephone-fill"></i>
                    <span>{{ session('phone') ?? 'شماره یافت نشد' }}</span>
                </div>

                @if (session('error'))
                    <div style="margin-bottom:18px;border-radius:14px;padding:12px 14px;background:rgba(248, 113, 113, 0.14);color:#fecaca;border:1px solid rgba(248, 113, 113, 0.35);text-align:center;">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="post" action="{{ route('checkAndLoginByPhone') }}" id="verifyForm">
                    @csrf
                    <input type="hidden" name="phone" value="{{ session('phone') }}">

                    <label>
                        کد تأیید
                        <div class="input-wrapper">
                            <i class="bi bi-key-fill"></i>
                            <input
                                type="text"
                                name="verficationCode"
                                placeholder="000000"
                                maxlength="6"
                                inputmode="numeric"
                                required
                            >
                        </div>
                    </label>

                    <div class="actions">
                        <button type="submit" id="verifyButton">
                            <i class="bi bi-check-circle-fill"></i>
                            ورود به سامانه
                        </button>
                        <a class="edit-link" href="{{ route('login') }}">
                            <i class="bi bi-arrow-right"></i>
                            اصلاح شماره موبایل
                        </a>
                    </div>
                </form>

                <div class="support-hint">
                    در صورت عدم دریافت کد، با پشتیبانی مدرسه تماس بگیرید.
                </div>
            </div>
        </div>
    </div>

    <script>
        const verifyForm = document.getElementById('verifyForm');
        const verifyButton = document.getElementById('verifyButton');
        const codeInput = document.querySelector('input[name="verficationCode"]');

        codeInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 6) {
                value = value.slice(0, 6);
            }
            e.target.value = value;
        });

        codeInput.addEventListener('paste', function (e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            const numbers = pasted.replace(/\D/g, '').slice(0, 6);
            this.value = numbers;
        });

        verifyForm.addEventListener('submit', function () {
            verifyButton.disabled = true;
            verifyButton.innerHTML = '<span class="spinner"></span> در حال بررسی...';
        });
    </script>
</body>
</html>
