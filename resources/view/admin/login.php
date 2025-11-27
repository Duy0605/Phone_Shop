<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin Login' ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideUp 0.5s ease-out;
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

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .login-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            outline: none;
        }

        .form-group input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input.error {
            border-color: #f56565;
        }

        .field-error {
            color: #f56565;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .field-error.show {
            display: block;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-success {
            background-color: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .back-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .icon {
            font-size: 50px;
            margin-bottom: 10px;
        }

        @media (max-width: 480px) {
            .login-container {
                border-radius: 0;
            }

            .login-header {
                padding: 30px 20px;
            }

            .login-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="icon">🔐</div>
            <h1>Admin Panel</h1>
            <p>Đăng nhập để quản lý hệ thống</p>
        </div>

        <div class="login-body">
            <?php
            // Hiển thị flash message nếu có
            $flash = getFlashMessage();
            if ($flash):
                $alertClass = $flash['type'] === 'error' ? 'alert-danger' : 'alert-success';
                ?>
                <div class="alert <?= $alertClass ?>">
                    <?= escape($flash['message']) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" id="loginForm">
                <?= csrfField() ?>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="admin@phoneshop.com"
                        value="<?= escape(post('email', '')) ?>" required autofocus>
                    <div class="field-error" id="email-error">Email không hợp lệ</div>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                    <div class="field-error" id="password-error">Vui lòng nhập mật khẩu</div>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    Đăng nhập
                </button>
            </form>

            <div class="back-link">
                <a href="<?= url('/') ?>">← Về trang chủ</a>
            </div>
        </div>
    </div>

    <script>
        // Form validation
        const form = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const loginBtn = document.getElementById('loginBtn');

        // Email validation
        emailInput.addEventListener('blur', function() {
            const error = document.getElementById('email-error');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailRegex.test(this.value)) {
                this.classList.add('error');
                error.classList.add('show');
            } else {
                this.classList.remove('error');
                error.classList.remove('show');
            }
        });

        emailInput.addEventListener('input', function() {
            this.classList.remove('error');
            document.getElementById('email-error').classList.remove('show');
        });

        // Password validation
        passwordInput.addEventListener('blur', function() {
            const error = document.getElementById('password-error');
            
            if (this.value.length === 0) {
                this.classList.add('error');
                error.classList.add('show');
            } else {
                this.classList.remove('error');
                error.classList.remove('show');
            }
        });

        passwordInput.addEventListener('input', function() {
            this.classList.remove('error');
            document.getElementById('password-error').classList.remove('show');
        });

        // Form submit
        form.addEventListener('submit', function(e) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let isValid = true;

            // Validate email
            if (!emailRegex.test(emailInput.value)) {
                emailInput.classList.add('error');
                document.getElementById('email-error').classList.add('show');
                isValid = false;
            }

            // Validate password
            if (passwordInput.value.length === 0) {
                passwordInput.classList.add('error');
                document.getElementById('password-error').classList.add('show');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            // Disable button
            loginBtn.disabled = true;
            loginBtn.textContent = 'Đang đăng nhập...';
        });

        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    </script>
</body>

</html>