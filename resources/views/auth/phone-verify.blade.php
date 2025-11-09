<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تایید کد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap');

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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* دایره‌های شناور در پس‌زمینه */
        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 20s infinite;
        }

        body::before {
            width: 300px;
            height: 300px;
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }

        body::after {
            width: 200px;
            height: 200px;
            bottom: -50px;
            left: -50px;
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }

        .auth-container {
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 1;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3),
                        0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-header {
            padding: 40px 30px 30px;
            text-align: center;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.05) 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
        }

        .auth-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, transparent, #fff, transparent);
            border-radius: 2px;
        }

        .auth-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.1) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .auth-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .auth-subtitle {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 400;
        }

        .phone-display {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 20px;
            margin-bottom: 25px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .phone-display i {
            margin-left: 8px;
            color: rgba(255, 255, 255, 0.8);
        }

        .phone-display span {
            color: rgba(255, 255, 255, 0.95);
            font-weight: 600;
            font-size: 0.95rem;
        }

        .auth-body {
            padding: 40px 30px;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.95);
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            font-size: 1.1rem;
        }

        .code-input-container {
            position: relative;
            margin-bottom: 30px;
        }

        .code-input {
            width: 100%;
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            padding: 18px 20px;
            font-size: 1.8rem;
            font-weight: 700;
            text-align: center;
            letter-spacing: 12px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            font-family: 'Courier New', monospace;
        }

        .code-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 8px;
            font-size: 1.5rem;
        }

        .code-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1),
                        0 8px 25px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .btn-success {
            border-radius: 15px;
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            border: none;
            font-weight: 600;
            font-size: 1.05rem;
            padding: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .btn-success::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-success:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(34, 197, 94, 0.5);
        }

        .btn-success:active {
            transform: translateY(-1px);
        }

        .btn-success span {
            position: relative;
            z-index: 1;
        }

        .btn-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 15px;
        }

        .btn-link:hover {
            color: #fff;
            transform: translateX(-3px);
        }

        .btn-link i {
            font-size: 0.85rem;
        }

        .resend-code {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .resend-code-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .resend-btn {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .resend-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            color: #fff;
        }

        .resend-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .auth-card {
                border-radius: 25px;
            }

            .auth-header {
                padding: 30px 20px 25px;
            }

            .auth-body {
                padding: 30px 20px;
            }

            .auth-title {
                font-size: 1.5rem;
            }

            .auth-icon {
                width: 70px;
                height: 70px;
                font-size: 2rem;
            }

            .code-input {
                font-size: 1.5rem;
                letter-spacing: 8px;
                padding: 15px;
            }
        }

        /* Loading animation */
        .loading {
            display: none;
        }

        .loading.active {
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h1 class="auth-title">تایید کد</h1>
                <p class="auth-subtitle">کد ارسال شده به شماره شما را وارد کنید</p>
            </div>
            <div class="auth-body">
                <div class="phone-display">
                    <i class="bi bi-telephone-fill"></i>
                    <span>{{ request('phone') ?? '09123456789' }}</span>
                </div>
                <form id="verifyForm">
                    <div class="code-input-container">
                        <label class="form-label">
                            <i class="bi bi-key-fill"></i>
                            کد تایید
                        </label>
                        <input 
                            type="text" 
                            name="code" 
                            class="code-input" 
                            placeholder="000000" 
                            maxlength="6" 
                            required
                            pattern="[0-9]{6}"
                            autocomplete="one-time-code"
                            inputmode="numeric"
                        >
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-success" type="submit">
                            <span>
                                <i class="bi bi-check-circle loading" id="loadingIcon"></i>
                                ورود
                            </span>
                        </button>
                        <a class="btn-link text-center" href="{{ route('auth.phone.login') }}">
                            <i class="bi bi-arrow-right"></i>
                            ویرایش شماره
                        </a>
                    </div>
                </form>
                <div class="resend-code">
                    <div class="resend-code-text">کد را دریافت نکردید؟</div>
                    <button type="button" class="resend-btn" id="resendBtn">
                        <i class="bi bi-arrow-clockwise"></i>
                        ارسال مجدد کد
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto focus and move to next digit
        const codeInput = document.querySelector('.code-input');
        
        codeInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 6) {
                value = value.slice(0, 6);
            }
            e.target.value = value;
        });

        codeInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            const numbers = pasted.replace(/\D/g, '').slice(0, 6);
            this.value = numbers;
        });

        // Form submission
        document.getElementById('verifyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button');
            const icon = document.getElementById('loadingIcon');
            btn.disabled = true;
            icon.classList.add('active');
            btn.querySelector('span').innerHTML = '<i class="bi bi-check-circle loading active"></i> در حال بررسی...';
            
            // Here you would normally submit to your backend
            // For now, just simulate a delay
            setTimeout(() => {
                alert('کد تایید با موفقیت بررسی شد!');
                btn.disabled = false;
                icon.classList.remove('active');
                btn.querySelector('span').innerHTML = '<i class="bi bi-check-circle loading"></i> ورود';
            }, 2000);
        });

        // Resend code functionality
        let resendTimer = 60;
        const resendBtn = document.getElementById('resendBtn');
        
        function updateResendButton() {
            if (resendTimer > 0) {
                resendBtn.disabled = true;
                resendBtn.innerHTML = `<i class="bi bi-clock"></i> ارسال مجدد (${resendTimer} ثانیه)`;
                resendTimer--;
                setTimeout(updateResendButton, 1000);
            } else {
                resendBtn.disabled = false;
                resendBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> ارسال مجدد کد';
            }
        }

        resendBtn.addEventListener('click', function() {
            if (this.disabled) return;
            
            resendTimer = 60;
            updateResendButton();
            
            // Here you would normally call your backend to resend the code
            alert('کد تایید مجدداً ارسال شد!');
        });

        // Start the timer on page load
        updateResendButton();
    </script>
</body>
</html>
