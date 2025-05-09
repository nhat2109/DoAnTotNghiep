
<?php
session_start();
	
// Kiểm tra đăng nhập
if (!isset($_COOKIE['user_id'])) {
    error_log('Redirecting to /ncc/login.php from profile.php');
    header('Location: /ncc/login.php');
    exit;
}
$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
$user_id = $tach_token['user_id'];


// Lấy thông tin từ user_info (chỉ lấy username và user_money)
$check_user_info = mysqli_query($conn, "SELECT username, user_money FROM user_info WHERE user_id = '$user_id'");
if (!$check_user_info) {
    die('Lỗi truy vấn user_info: ' . mysqli_error($conn));
}
$user_info = mysqli_fetch_assoc($check_user_info);
if (!$user_info) {
    die('Lỗi: Không tìm thấy user với user_id = ' . $user_id);
}

// Lấy thông tin từ user_ncc
$check_ncc = mysqli_query($conn, "SELECT * FROM user_ncc WHERE user_id = '$user_id' LIMIT 1");
if (!$check_ncc) {
    die('Lỗi truy vấn user_ncc: ' . mysqli_error($conn));
}
$user_ncc_profile = mysqli_num_rows($check_ncc) > 0 ? mysqli_fetch_assoc($check_ncc) : [];

// Nếu không tìm thấy thông tin nhà cung cấp, chuyển hướng về trang setup
if (empty($user_ncc_profile)) {
    error_log('Redirecting to /ncc/welcome_setup.php from profile.php');
    header('Location: /ncc/welcome_setup.php');
    exit;
}

// Chuẩn bị dữ liệu cho template
$thaythe['title'] = 'Profile';
$thaythe['title_action'] = 'Profile';
$user_ncc_profile['user_money'] = number_format($user_info['user_money'], 0, ',', '.') . ' VNĐ';
$user_ncc_profile['username'] = $user_info['username'];

// Lấy danh sách tỉnh, huyện, xã
$user_ncc_profile['option_tinh'] = $class_index->list_option_tinh($conn, $user_ncc_profile['tinh'] ?? 0);
$user_ncc_profile['option_huyen'] = $class_index->list_option_huyen($conn, $user_ncc_profile['tinh'] ?? 0, $user_ncc_profile['huyen'] ?? 0);
$user_ncc_profile['option_xa'] = $class_index->list_option_xa($conn, $user_ncc_profile['huyen'] ?? 0, $user_ncc_profile['xa'] ?? 0);

// Gán dữ liệu vào thaythe
$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/profile', $user_ncc_profile);
?>