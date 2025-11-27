<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= config('app.base_url') ?>">
    <title>Đăng ký - Phone Shop</title>
    <link rel="stylesheet" href="<?= config('app.base_url') ?>/resources/css/main.css">
    <link rel="stylesheet" href="<?= config('app.base_url') ?>/resources/css/auth.css">
</head>

<body class="auth-page">
    <div class="auth-container register-container">
        <div class="auth-header">
            <div class="auth-icon">📱</div>
            <h1>Đăng ký</h1>
            <p>Tạo tài khoản mới tại Phone Shop</p>
        </div>

        <div class="auth-body">
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <?= escape($_SESSION['error_message']) ?>
                    <?php unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" id="registerForm">
                <div class="form-group">
                    <label for="name">Họ và tên *</label>
                    <input type="text" id="name" name="name" value="<?= escape($_POST['name'] ?? '') ?>"
                        placeholder="Nhập họ tên của bạn" required minlength="3">
                    <div class="field-error" id="name-error"></div>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="<?= escape($_POST['email'] ?? '') ?>"
                        placeholder="Nhập email của bạn" required>
                    <div class="field-error" id="email-error"></div>
                    <div class="field-success" id="email-success">✓ Email hợp lệ</div>
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại *</label>
                    <input type="tel" id="phone" name="phone" value="<?= escape($_POST['phone'] ?? '') ?>"
                        placeholder="0xxxxxxxxx" required pattern="[0-9]{10,11}">
                    <div class="field-error" id="phone-error"></div>
                    <div class="field-success" id="phone-success">✓ Số điện thoại hợp lệ</div>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu *</label>
                    <input type="password" id="password" name="password" placeholder="Tối thiểu 6 ký tự" required minlength="6">
                    <div class="password-strength">
                        <div class="password-strength-bar" id="strength-bar"></div>
                    </div>
                    <div class="password-strength-text" id="strength-text"></div>
                    <div class="field-error" id="password-error"></div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu *</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu"
                        required>
                    <div class="field-error" id="confirm-password-error"></div>
                    <div class="field-success" id="confirm-password-success">✓ Mật khẩu khớp</div>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">Đăng ký</button>
            </form>
        </div>

        <div class="auth-links">
            <p>Đã có tài khoản? <a href="<?= url('/login') ?>">Đăng nhập</a></p>
            <p><a href="<?= url('/') ?>">← Quay lại trang chủ</a></p>
        </div>
    </div>

    <script src="<?= config('app.base_url') ?>/resources/js/main.js"></script>
    <script>
        // Real-time validation
        const form = document.getElementById('registerForm');
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const submitBtn = document.getElementById('submitBtn');

        // Name validation
        nameInput.addEventListener('blur', function() {
            const error = document.getElementById('name-error');
            if (this.value.length < 3) {
                this.classList.add('error');
                this.classList.remove('success');
                error.textContent = 'Họ tên phải có ít nhất 3 ký tự';
                error.classList.add('show');
            } else {
                this.classList.remove('error');
                this.classList.add('success');
                error.classList.remove('show');
            }
        });

        // Email validation
        emailInput.addEventListener('blur', function() {
            const error = document.getElementById('email-error');
            const success = document.getElementById('email-success');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailRegex.test(this.value)) {
                this.classList.add('error');
                this.classList.remove('success');
                error.textContent = 'Email không hợp lệ';
                error.classList.add('show');
                success.classList.remove('show');
            } else {
                this.classList.remove('error');
                this.classList.add('success');
                error.classList.remove('show');
                success.classList.add('show');
            }
        });

        // Phone validation
        phoneInput.addEventListener('blur', function() {
            const error = document.getElementById('phone-error');
            const success = document.getElementById('phone-success');
            const phoneRegex = /^[0-9]{10,11}$/;
            
            if (!phoneRegex.test(this.value)) {
                this.classList.add('error');
                this.classList.remove('success');
                error.textContent = 'Số điện thoại phải có 10-11 chữ số';
                error.classList.add('show');
                success.classList.remove('show');
            } else {
                this.classList.remove('error');
                this.classList.add('success');
                error.classList.remove('show');
                success.classList.add('show');
            }
        });

        // Password strength
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');
            
            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            strengthBar.className = 'password-strength-bar';
            if (strength <= 2) {
                strengthBar.classList.add('weak');
                strengthText.textContent = 'Mật khẩu yếu';
                strengthText.style.color = '#f56565';
            } else if (strength <= 3) {
                strengthBar.classList.add('medium');
                strengthText.textContent = 'Mật khẩu trung bình';
                strengthText.style.color = '#ed8936';
            } else {
                strengthBar.classList.add('strong');
                strengthText.textContent = 'Mật khẩu mạnh';
                strengthText.style.color = '#48bb78';
            }
        });

        // Confirm password validation
        confirmPasswordInput.addEventListener('input', function() {
            const error = document.getElementById('confirm-password-error');
            const success = document.getElementById('confirm-password-success');
            
            if (this.value !== passwordInput.value) {
                this.classList.add('error');
                this.classList.remove('success');
                error.textContent = 'Mật khẩu không khớp';
                error.classList.add('show');
                success.classList.remove('show');
            } else if (this.value.length > 0) {
                this.classList.remove('error');
                this.classList.add('success');
                error.classList.remove('show');
                success.classList.add('show');
            }
        });

        // Form submit validation
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Check all fields
            if (nameInput.value.length < 3) isValid = false;
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) isValid = false;
            if (!/^[0-9]{10,11}$/.test(phoneInput.value)) isValid = false;
            if (passwordInput.value.length < 6) isValid = false;
            if (passwordInput.value !== confirmPasswordInput.value) isValid = false;
            
            if (!isValid) {
                e.preventDefault();
                alert('Vui lòng kiểm tra lại thông tin đã nhập!');
            } else {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Đang xử lý...';
            }
        });
    </script>
</body>

</html>