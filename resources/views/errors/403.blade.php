<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>شما اجازه ی دسترسی به این صفحه را ندارید   | سیستم مدیریت مدرسه</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/vazirmatn@33.0.2/Vazirmatn-font-face.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            font-family: Vazirmatn, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, #1a1d29 0%, #0f1115 100%);
            min-height: 100vh;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .floating-animation {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .btn {
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="glass-effect p-5 text-center animate__animated animate__fadeInUp">
                <!-- 404 Icon -->
                <div class="floating-animation mb-4">
                    <i class="fa-solid fa-exclamation-triangle text-warning" style="font-size: 6rem;"></i>
                </div>

                <!-- Error Code -->
                <h1 class="display-1 gradient-text fw-bold mb-3 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                    403
                </h1>

                <!-- Error Message -->
                <h2 class="h3 mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                    دسترسی محدود شد!
                </h2>

                <p class="text-muted mb-5 animate__animated animate__fadeInUp" style="animation-delay: 0.6s; color: white !important;">
                    متاسفانه شما اجازه ی دسترسی به این صفحه را ندارید!
                </p>

                <!-- Action Buttons -->
                <div class="d-flex gap-3 justify-content-center flex-wrap animate__animated animate__fadeInUp" style="animation-delay: 0.8s;">
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg">
                        <i class="fa-solid fa-home me-2"></i>بازگشت به داشبورد
                    </a>
                    <a href="javascript:history.back()" class="btn btn-outline-primary btn-lg">
                        <i class="fa-solid fa-arrow-right me-2"></i>صفحه قبل
                    </a>
                </div>

                <!-- Additional Info -->
                <div class="mt-5 pt-4 border-top border-secondary">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="pulse-animation">
                                <i class="fa-solid fa-graduation-cap text-primary mb-2" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="mb-1">سیستم مدیریت مدرسه</h6>
                            <small class="text-muted" style="color: white !important;">پنل مدیریت هوشمند</small>
                        </div>
                        <div class="col-md-4">
                            <div class="pulse-animation">
                                <i class="fa-solid fa-shield-halved text-success mb-2" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="mb-1">امنیت بالا</h6>
                            <small class="text-muted" style="color: white !important;">محافظت از اطلاعات</small>
                        </div>
                        <div class="col-md-4">
                            <div class="pulse-animation">
                                <i class="fa-solid fa-rocket text-warning mb-2" style="font-size: 2rem;"></i>
                            </div>
                            <h6 class="mb-1">سرعت بالا</h6>
                            <small class="text-muted" style="color: white !important;">عملکرد بهینه</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
