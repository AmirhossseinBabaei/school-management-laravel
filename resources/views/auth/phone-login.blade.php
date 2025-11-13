<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ورود با شماره موبایل</title>
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

        .form-control {
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            padding: 15px 20px;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1),
                        0 8px 25px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .btn-primary {
            border-radius: 15px;
            background: linear-gradient(135deg, #ff6b9d 0%, #c44569 100%);
            border: none;
            font-weight: 600;
            font-size: 1.05rem;
            padding: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(196, 69, 105, 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
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

        .btn-primary:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(196, 69, 105, 0.5);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .btn-primary span {
            position: relative;
            z-index: 1;
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
                    <i class="bi bi-phone"></i>
                </div>
                <h1 class="auth-title">ورود با شماره موبایل</h1>
                <p class="auth-subtitle">لطفاً شماره موبایل خود را وارد کنید</p>
            </div>
            <div class="auth-body">
                <form action="{{ route('auth.checkPhone') }}" method="get" id="loginForm">
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-telephone-fill"></i>
                            شماره موبایل
                        </label>
                        <input
                            type="tel"
                            name="phone"
                            class="form-control"
                            placeholder="09123456789"
                            required
                            pattern="09[0-9]{9}"
                            maxlength="11"
                            autocomplete="tel"
                        >
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit">
                            <span>
                                <i class="bi bi-arrow-left loading" id="loadingIcon"></i>
                                ادامه
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('button');
            const icon = document.getElementById('loadingIcon');
            btn.disabled = true;
            icon.classList.add('active');
            btn.querySelector('span').innerHTML = '<i class="bi bi-arrow-left loading active"></i> در حال ارسال...';
        });

        // Auto format phone number
        document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
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
