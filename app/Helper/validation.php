<?php
/**
 * Validation Helper Functions
 * Các hàm hỗ trợ validate dữ liệu đầu vào
 */

/**
 * Validate email
 * @param string $email
 * @return bool
 */
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate số điện thoại Việt Nam
 * @param string $phone
 * @return bool
 */
function validatePhone($phone)
{
    // Format: 09xxxxxxxx, 08xxxxxxxx, 07xxxxxxxx, 03xxxxxxxx, 05xxxxxxxx
    // Đầu số hợp lệ tại VN: 03, 05, 07, 08, 09
    $pattern = '/^0[35789][0-9]{8}$/';
    return preg_match($pattern, $phone) === 1;
}

/**
 * Validate required field
 * @param mixed $value
 * @return bool
 */
function validateRequired($value)
{
    if (is_string($value)) {
        return trim($value) !== '';
    }

    return !empty($value);
}

/**
 * Validate độ dài tối thiểu
 * @param string $value
 * @param int $min
 * @return bool
 */
function validateMinLength($value, $min)
{
    return mb_strlen($value) >= $min;
}

/**
 * Validate độ dài tối đa
 * @param string $value
 * @param int $max
 * @return bool
 */
function validateMaxLength($value, $max)
{
    return mb_strlen($value) <= $max;
}

/**
 * Validate số nguyên
 * @param mixed $value
 * @return bool
 */
function validateInteger($value)
{
    return filter_var($value, FILTER_VALIDATE_INT) !== false;
}

/**
 * Validate số thực
 * @param mixed $value
 * @return bool
 */
function validateFloat($value)
{
    return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
}

/**
 * Validate giá trị trong khoảng
 * @param numeric $value
 * @param numeric $min
 * @param numeric $max
 * @return bool
 */
function validateRange($value, $min, $max)
{
    return $value >= $min && $value <= $max;
}

/**
 * Validate password
 * @param string $password
 * @param int $minLength
 * @return array ['valid' => bool, 'message' => string]
 */
function validatePassword($password, $minLength = null)
{
    if ($minLength === null) {
        $minLength = config('app.security.password_min_length', 6);
    }

    if (!validateRequired($password)) {
        return ['valid' => false, 'message' => 'Mật khẩu không được để trống'];
    }

    if (!validateMinLength($password, $minLength)) {
        return ['valid' => false, 'message' => "Mật khẩu phải có ít nhất {$minLength} ký tự"];
    }

    return ['valid' => true, 'message' => ''];
}

/**
 * Validate URL
 * @param string $url
 * @return bool
 */
function validateUrl($url)
{
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

/**
 * Validate định dạng ngày
 * @param string $date
 * @param string $format
 * @return bool
 */
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Validate file upload
 * @param array $file $_FILES['field_name']
 * @param int $maxSize Kích thước tối đa (bytes)
 * @param array $allowedExtensions Các extension được phép
 * @return array ['valid' => bool, 'message' => string]
 */
function validateFileUpload($file, $maxSize = null, $allowedExtensions = null)
{
    if ($maxSize === null) {
        $maxSize = config('app.upload.max_size', 5242880); // 5MB
    }

    if ($allowedExtensions === null) {
        $allowedExtensions = config('app.upload.allowed_extensions', ['jpg', 'jpeg', 'png', 'gif']);
    }

    // Kiểm tra có lỗi không
    if (!isset($file['error']) || is_array($file['error'])) {
        return ['valid' => false, 'message' => 'Lỗi upload file'];
    }

    // Kiểm tra các loại lỗi
    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            return ['valid' => false, 'message' => 'Chưa chọn file'];
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            return ['valid' => false, 'message' => 'File quá lớn'];
        default:
            return ['valid' => false, 'message' => 'Lỗi không xác định'];
    }

    // Kiểm tra kích thước
    if ($file['size'] > $maxSize) {
        $maxMB = round($maxSize / 1048576, 2);
        return ['valid' => false, 'message' => "File không được vượt quá {$maxMB}MB"];
    }

    // Kiểm tra extension
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions)) {
        return ['valid' => false, 'message' => 'Định dạng file không được hỗ trợ'];
    }

    return ['valid' => true, 'message' => ''];
}

/**
 * Validate giá tiền
 * @param mixed $price
 * @return bool
 */
function validatePrice($price)
{
    return is_numeric($price) && $price >= 0;
}

/**
 * Validate số lượng
 * @param mixed $quantity
 * @return bool
 */
function validateQuantity($quantity)
{
    return validateInteger($quantity) && $quantity > 0;
}

/**
 * Sanitize string
 * @param string $value
 * @return string
 */
function sanitizeString($value)
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate và sanitize dữ liệu
 * @param array $data Dữ liệu cần validate
 * @param array $rules Quy tắc validate ['field' => ['rule1', 'rule2']]
 * @return array ['valid' => bool, 'errors' => array]
 */
function validate($data, $rules)
{
    $errors = [];

    foreach ($rules as $field => $fieldRules) {
        $value = $data[$field] ?? null;

        foreach ($fieldRules as $rule) {
            // Parse rule (ví dụ: 'min:6', 'max:100')
            $parts = explode(':', $rule);
            $ruleName = $parts[0];
            $ruleParam = $parts[1] ?? null;

            switch ($ruleName) {
                case 'required':
                    if (!validateRequired($value)) {
                        $errors[$field][] = ucfirst($field) . ' không được để trống';
                    }
                    break;

                case 'email':
                    if ($value && !validateEmail($value)) {
                        $errors[$field][] = ucfirst($field) . ' không hợp lệ';
                    }
                    break;

                case 'phone':
                    if ($value && !validatePhone($value)) {
                        $errors[$field][] = 'Số điện thoại không hợp lệ';
                    }
                    break;

                case 'min':
                    if ($value && !validateMinLength($value, (int) $ruleParam)) {
                        $errors[$field][] = ucfirst($field) . " phải có ít nhất {$ruleParam} ký tự";
                    }
                    break;

                case 'max':
                    if ($value && !validateMaxLength($value, (int) $ruleParam)) {
                        $errors[$field][] = ucfirst($field) . " không được vượt quá {$ruleParam} ký tự";
                    }
                    break;
            }
        }
    }

    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}
