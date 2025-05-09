<?php
session_start();
include '../includes/tlca_world.php';

// Load required classes
$check = $tlca_do->load('class_check');
$class_index = $tlca_do->load('class_ncc');
$class_viettel = $tlca_do->load('class_viettel');
$skin = $tlca_do->load('class_skin_cpanel');

// Kiểm tra đăng nhập
if (!isset($_COOKIE['user_id'])) {
    error_log('Redirecting to /ncc/login.php from welcome_setup.php');
    header('Location: /ncc/login.php');
    exit;
}
$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
$user_id = $tach_token['user_id'];

// Lấy thông tin user từ user_info
$check_supplier = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id = '$user_id'");
if (!$check_supplier) {
    die('Lỗi truy vấn user_info: ' . mysqli_error($conn));
}
$supplier = mysqli_fetch_assoc($check_supplier);
if (!$supplier) {
    die('Lỗi: Không tìm thấy user với user_id = ' . $user_id);
}

// Lấy thông tin từ user_ncc (nếu đã có)
$check_ncc = mysqli_query($conn, "SELECT * FROM user_ncc WHERE user_id = '$user_id' LIMIT 1");
if (!$check_ncc) {
    die('Lỗi truy vấn user_ncc: ' . mysqli_error($conn));
}
$ncc = mysqli_num_rows($check_ncc) > 0 ? mysqli_fetch_assoc($check_ncc) : [];

// Kiểm tra xem đã có thông tin vận chuyển chưa
$check_transport = mysqli_query($conn, "SELECT id FROM transport WHERE user_id = '$user_id' LIMIT 1");
if (!$check_transport) {
    die('Lỗi truy vấn transport: ' . mysqli_error($conn));
}
$has_transport = mysqli_num_rows($check_transport) > 0;

// Kiểm tra xem đã có tài khoản ngân hàng chưa
$check_bank = mysqli_query($conn, "SELECT id FROM bank_accounts WHERE user_id = '$user_id' LIMIT 1");
if (!$check_bank) {
    die('Lỗi truy vấn bank_accounts: ' . mysqli_error($conn));
}
$has_bank = mysqli_num_rows($check_bank) > 0;

if ($supplier['ctv'] != 1) {
    error_log('Redirecting to / from welcome_setup.php');
    header('Location: /');
    exit;
}

// Nếu đã hoàn thiện tất cả thông tin, chuyển hướng đến /ncc/
if (!empty($ncc['email']) && !empty($ncc['maso_thue']) && !empty($supplier['dia_chi']) && $has_transport && $has_bank) {
    $_SESSION['setup_completed'] = true;
    error_log('Redirecting to /ncc/ from welcome_setup.php');
    if ($_SERVER['REQUEST_URI'] !== '/ncc/') {
        header('Location: /ncc/');
        exit;
    }
}

// Xác định bước hiện tại dựa trên dữ liệu đã có
$current_step = isset($_GET['step']) ? intval($_GET['step']) : 1;

// Tự động xác định bước tiếp theo nếu đã hoàn thành bước trước
if (!isset($_GET['step'])) {
    if (!empty($ncc['email']) && !empty($ncc['maso_thue'])) {
        if (!empty($supplier['dia_chi']) && !empty($supplier['tinh'])) {
            if (!$has_bank) {
                $current_step = 3; // Chuyển đến bước 3 (ngân hàng)
            } else {
                $current_step = 1; // Mặc định nếu tất cả đã hoàn thành
            }
        } else {
            $current_step = 2; // Chuyển đến bước 2 (địa chỉ giao nhận)
        }
    } else {
        $current_step = 1; // Bắt đầu từ bước 1 (thông tin cơ bản)
    }
}

// Kiểm tra giới hạn step
if ($current_step < 1 || $current_step > 3) $current_step = 1;

// Xử lý form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    switch ($action) {

        case 'save_step1':
            // Lấy dữ liệu từ form
            $name = strip_tags(addslashes($_POST['name']));
            $mobile = preg_replace('/[^0-9]/', '', $_POST['mobile']);
            $email = addslashes($_POST['email']);
            $maso_thue = addslashes($_POST['maso_thue']);
            $maso_thue_cap = addslashes($_POST['maso_thue_cap'] ?? '');
            $maso_thue_noicap = addslashes($_POST['maso_thue_noicap'] ?? '');
            $ten_daidien = strip_tags(addslashes($_POST['ten_daidien']));
            $chucvu = strip_tags(addslashes($_POST['chucvu']));
            $tinh = intval($_POST['tinh']);
            $huyen = intval($_POST['huyen']);
            $xa = intval($_POST['xa']);
            $dia_chi = addslashes($_POST['dia_chi']);
            
            // Kiểm tra dữ liệu
            if (strlen($name) < 2) {
                $error = "Vui lòng nhập tên công ty/hộ kinh doanh đầy đủ";
            } elseif (strlen($mobile) < 10) {
                $error = "Vui lòng nhập số điện thoại hợp lệ";
            } elseif (empty($email)) {
                $error = "Vui lòng nhập email";
            } elseif (empty($maso_thue)) {
                $error = "Vui lòng nhập mã số thuế hoặc CCCD";
            } elseif (empty($ten_daidien)) {
                $error = "Vui lòng nhập tên người đại diện";
            } elseif (empty($chucvu)) {
                $error = "Vui lòng nhập chức vụ";
            } elseif (empty($tinh)) {
                $error = "Vui lòng chọn tỉnh/thành phố";
            } elseif (empty($huyen)) {
                $error = "Vui lòng chọn quận/huyện";
            } elseif (empty($xa)) {
                $error = "Vui lòng chọn phường/xã";
            } elseif (empty($dia_chi)) {
                $error = "Vui lòng nhập địa chỉ chi tiết";
            } else {
                // Kiểm tra trùng email trong bảng user_info
                $check_email_sql = "SELECT user_id FROM user_info WHERE email = '$email' AND user_id != '$user_id'";
                $result = mysqli_query($conn, $check_email_sql);
                
                if (mysqli_num_rows($result) > 0) {
                    $error = "Email đã được sử dụng bởi một người dùng khác";
                } else {
                    // Lưu thông tin vào bảng user_ncc
                    $current_time = strtotime('now');
                    $sql = "INSERT INTO user_ncc (
                        user_id, name, mobile, email, maso_thue, maso_thue_cap, maso_thue_noicap,
                        ten_daidien, chucvu, tinh, huyen, xa, dia_chi, created_at, updated_at
                    ) VALUES (
                        '$user_id', '$name', '$mobile', '$email', '$maso_thue', '$maso_thue_cap', '$maso_thue_noicap',
                        '$ten_daidien', '$chucvu', '$tinh', '$huyen', '$xa', '$dia_chi', '$current_time', '$current_time'
                    ) ON DUPLICATE KEY UPDATE
                        name = '$name',
                        mobile = '$mobile',
                        email = '$email',
                        maso_thue = '$maso_thue',
                        maso_thue_cap = '$maso_thue_cap',
                        maso_thue_noicap = '$maso_thue_noicap',
                        ten_daidien = '$ten_daidien',
                        chucvu = '$chucvu',
                        tinh = '$tinh',
                        huyen = '$huyen',
                        xa = '$xa',
                        dia_chi = '$dia_chi',
                        updated_at = '$current_time'";
                    
                    // Cập nhật email và maso_thue vào bảng user_info
                    $update_user_info = "UPDATE user_info SET 
                        email = '$email',
                        maso_thue = '$maso_thue'
                        WHERE user_id = '$user_id'";
                    
                    if (mysqli_query($conn, $sql) && mysqli_query($conn, $update_user_info)) {
                        error_log('Redirecting to /ncc/welcome_setup.php?step=2 from save_step1');
                        header('Location: /ncc/welcome_setup.php?step=2');
                        exit;
                    } else {
                        $error = "Có lỗi khi lưu thông tin: " . mysqli_error($conn);
                    }
                }
            }
            break;

        case 'save_step2':
            // Lấy dữ liệu từ form
            $fullname = strip_tags(addslashes($_POST['fullname']));
            $mobile = preg_replace('/[^0-9]/', '', $_POST['mobile']);
            $tinh = intval($_POST['tinh']);
            $huyen = intval($_POST['huyen']);
            $xa = intval($_POST['xa']);
            $dia_chi = addslashes($_POST['dia_chi']);

            // Kiểm tra dữ liệu
            if (empty($fullname)) {
                $error = "Vui lòng nhập họ tên người nhận";
            } elseif (strlen($mobile) < 10) {
                $error = "Vui lòng nhập số điện thoại hợp lệ";
            } elseif (empty($tinh)) {
                $error = "Vui lòng chọn tỉnh/thành phố";
            } elseif (empty($huyen)) {
                $error = "Vui lòng chọn quận/huyện";
            } elseif (empty($xa)) {
                $error = "Vui lòng chọn phường/xã";
            } elseif (empty($dia_chi)) {
                $error = "Vui lòng nhập địa chỉ chi tiết";
            } else {
                // Cập nhật thông tin địa chỉ giao nhận trong user_info
                $sql = "UPDATE user_info SET 
                        dia_chi = '$dia_chi',
                        tinh = '$tinh',
                        huyen = '$huyen',
                        xa = '$xa'
                        WHERE user_id = '$user_id'";
                
                if (mysqli_query($conn, $sql)) {
                    $username = $supplier['username'];
                    $current_time = strtotime('now');

                    if ($has_transport) {
                        // Cập nhật bản ghi hiện có trong bảng transport
                        $transport_sql = "UPDATE transport SET
                            username = '$username',
                            fullname = '$fullname',
                            mobile = '$mobile',
                            province = '$tinh',
                            district = '$huyen',
                            ward = '$xa',
                            address_detail = '$dia_chi',
                            is_default = 1,
                            is_pickup = 1,
                            is_return = 1,
                            updated_at = '$current_time'
                            WHERE user_id = '$user_id'";
                    } else {
                        // Thêm bản ghi mới vào bảng transport
                        $transport_sql = "INSERT INTO transport (
                            user_id, username, fullname, mobile, province, district, ward, 
                            address_detail, is_default, is_pickup, is_return, 
                            created_at, updated_at
                        ) VALUES (
                            '$user_id', '$username', '$fullname', '$mobile', '$tinh', '$huyen', '$xa', 
                            '$dia_chi', 1, 1, 1, 
                            '$current_time', '$current_time'
                        )";
                    }

                    if (mysqli_query($conn, $transport_sql)) {
                        error_log('Redirecting to /ncc/welcome_setup.php?step=3 from save_step2');
                        header('Location: /ncc/welcome_setup.php?step=3');
                        exit;
                    } else {
                        $error = "Có lỗi khi lưu thông tin vận chuyển: " . mysqli_error($conn);
                    }
                } else {
                    $error = "Có lỗi khi lưu thông tin địa chỉ: " . mysqli_error($conn);
                }
            }
            break;
        case 'save_step3':
            // Lấy dữ liệu từ form
            $bank_id = intval($_POST['bank_id']);
            $account_name = strip_tags(addslashes($_POST['account_name'] ?? $ncc['name']));
            $id_number = strip_tags(addslashes($_POST['id_number'] ?? $ncc['maso_thue']));
            $account_number = strip_tags(addslashes($_POST['account_number']));
            $account_holder = strip_tags(addslashes($_POST['account_holder']));
            
            // Kiểm tra dữ liệu
            if (empty($bank_id)) {
                $error = "Vui lòng chọn ngân hàng";
            } elseif (empty($account_number)) {
                $error = "Vui lòng nhập số tài khoản";
            } elseif (empty($account_holder)) {
                $error = "Vui lòng nhập tên chủ tài khoản";
            } else {
               // $current_time = date('Y-m-d H:i:s'); // Định dạng chuỗi ngày giờ
               $current_time = strtotime('now');
                // Thêm tài khoản ngân hàng
                $sql = "INSERT INTO bank_accounts (
                    user_id, bank_id, account_name, id_number, account_number, account_holder, is_default, created_at, updated_at
                ) VALUES (
                    '$user_id', '$bank_id', '$account_name', '$id_number', '$account_number', '$account_holder', 1, '$current_time', '$current_time'
                )";
                
                if (mysqli_query($conn, $sql)) {
                    // Đánh dấu là đã hoàn thành setup
                    $_SESSION['setup_completed'] = true;
                    // Xóa session hiển thị welcome setup
                    unset($_SESSION['show_welcome_setup']);
                    error_log('Redirecting to /ncc/ from save_step3');
                    if ($_SERVER['REQUEST_URI'] !== '/ncc/') {
                        header('Location: /ncc/');
                        exit;
                    }
                } else {
                    $error = "Có lỗi khi lưu thông tin ngân hàng: " . mysqli_error($conn);
                }
            }
            break;
    }
}
// Setup variables for the template
$email = $supplier['email'] ?? '';
$name = $supplier['name'] ?? '';
$mobile = $supplier['mobile'] ?? '';
$maso_thue = $supplier['maso_thue'] ?? '';
// Setup variables for the template
$email = $ncc['email'] ?? '';
// $name = $ncc['name'] ?? '';
// $mobile = $ncc['mobile'] ?? '';
// $maso_thue = $ncc['maso_thue'] ?? '';
$maso_thue_cap = $ncc['maso_thue_cap'] ?? '';
$maso_thue_noicap = $ncc['maso_thue_noicap'] ?? '';
$ten_daidien = $ncc['ten_daidien'] ?? '';
$chucvu = $ncc['chucvu'] ?? '';
$dia_chi = $ncc['dia_chi'] ?? '';
$option_tinh = $class_index->list_option_tinh($conn, $ncc['tinh'] ?? $supplier['tinh']);
$option_huyen = $class_index->list_option_huyen($conn, $ncc['tinh'] ?? $supplier['tinh'], $ncc['huyen'] ?? $supplier['huyen']);
$option_xa = $class_index->list_option_xa($conn, $ncc['huyen'] ?? $supplier['huyen'], $ncc['xa'] ?? $supplier['xa']);
$bank_options = get_bank_options($conn);
$step1_completed = !empty($ncc['email']) && !empty($ncc['maso_thue']);
$step2_completed = !empty($supplier['dia_chi']) && !empty($supplier['tinh']);
$step3_completed = $has_bank;

// cho step 1
$option_tinh_step1 = $class_index->list_option_tinh($conn, $ncc['tinh'] ?? $supplier['tinh']);
$option_huyen_step1 = $class_index->list_option_huyen($conn, $ncc['tinh'] ?? $supplier['tinh'], $ncc['huyen'] ?? $supplier['huyen']);
$option_xa_step1 = $class_index->list_option_xa($conn, $ncc['huyen'] ?? $supplier['huyen'], $ncc['xa'] ?? $supplier['xa']);

// Include the template directly
include '../skin_ncc/welcome_setup.tpl';

function get_bank_options($conn) {
    $sql = "SELECT id, name, code FROM banks WHERE status = 1 ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die('Lỗi truy vấn banks: ' . mysqli_error($conn));
    }
    $options = '<option value="">Chọn ngân hàng</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= '<option value="' . $row['id'] . '">' . $row['name'] . ' (' . $row['code'] . ')</option>';
    }
    return $options;
}

function remove_accents($str) {
    $str = mb_strtolower($str, 'UTF-8');
    $accents = array(
        'à'=>'a', 'á'=>'a', 'ả'=>'a', 'ã'=>'a', 'ạ'=>'a',
        'ă'=>'a', 'ằ'=>'a', 'ắ'=>'a', 'ẳ'=>'a', 'ẵ'=>'a', 'ặ'=>'a',
        'â'=>'a', 'ầ'=>'a', 'ấ'=>'a', 'ẩ'=>'a', 'ẫ'=>'a', 'ậ'=>'a',
        'è'=>'e', 'é'=>'e', 'ẻ'=>'e', 'ẽ'=>'e', 'ẹ'=>'e',
        'ê'=>'e', 'ề'=>'e', 'ế'=>'e', 'ể'=>'e', 'ễ'=>'e', 'ệ'=>'e',
        'ì'=>'i', 'í'=>'i', 'ỉ'=>'i', 'ĩ'=>'i', 'ị'=>'i',
        'ò'=>'o', 'ó'=>'o', 'ỏ'=>'o', 'õ'=>'o', 'ọ'=>'o',
        'ô'=>'o', 'ồ'=>'o', 'ố'=>'o', 'ổ'=>'o', 'ỗ'=>'o', 'ộ'=>'o',
        'ơ'=>'o', 'ờ'=>'o', 'ớ'=>'o', 'ở'=>'o', 'ỡ'=>'o', 'ợ'=>'o',
        'ù'=>'u', 'ú'=>'u', 'ủ'=>'u', 'ũ'=>'u', 'ụ'=>'u',
        'ư'=>'u', 'ừ'=>'u', 'ứ'=>'u', 'ử'=>'u', 'ữ'=>'u', 'ự'=>'u',
        'ỳ'=>'y', 'ý'=>'y', 'ỷ'=>'y', 'ỹ'=>'y', 'ỵ'=>'y',
        'đ'=>'d'
    );
    return strtoupper(strtr($str, $accents));
}