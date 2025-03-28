<?php
include('../includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_admin');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$skin=$tlca_do->load('class_skin_cpanel');

if (!isset($_COOKIE['admin_id'])) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Bạn chưa đăng nhập!']);
    exit();
}

$tach_token = json_decode($check->token_login_decode($_COOKIE['admin_id']), true);
$user_id = $tach_token['user_id'];
$user_info = $class_member->user_info($conn, $_COOKIE['admin_id']);
$action = $_GET['action'];

switch ($action) {
    case 'change_profile':
        $ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
        $email = addslashes(strip_tags($_REQUEST['email']));
        $dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));

        if (strlen($ho_ten) < 4) {
            $ok = 0;
            $thongbao = 'Họ và tên quá ngắn!';
        } elseif (!$check->check_email($email)) {
            $ok = 0;
            $thongbao = 'Email không đúng định dạng!';
        } elseif (strlen($dien_thoai) < 8) {
            $ok = 0;
            $thongbao = 'Số điện thoại không hợp lệ!';
        } else {
            mysqli_query($conn, "UPDATE user_info SET name='$ho_ten', email='$email', mobile='$dien_thoai' WHERE user_id='$user_id'");
            $ok = 1;
            $thongbao = 'Cập nhật thông tin thành công!';
        }
        break;

    case 'change_password':
        $password = md5(addslashes(strip_tags($_REQUEST['password'])));
        $new_password = addslashes(strip_tags($_REQUEST['new_password']));
        $confirm_password = addslashes(strip_tags($_REQUEST['confirm_password']));

        if ($password != $user_info['password']) {
            $ok = 0;
            $thongbao = 'Mật khẩu cũ không đúng!';
        } elseif (strlen($new_password) < 6) {
            $ok = 0;
            $thongbao = 'Mật khẩu mới phải từ 6 ký tự trở lên!';
        } elseif ($new_password != $confirm_password) {
            $ok = 0;
            $thongbao = 'Mật khẩu nhập lại không khớp!';
        } else {
            $new_pass_md5 = md5($new_password);
            mysqli_query($conn, "UPDATE user_info SET password='$new_pass_md5' WHERE user_id='$user_id'");
            setcookie('admin_id', '', time() - 3600, '/');
            $ok = 1;
            $thongbao = 'Đổi mật khẩu thành công! Vui lòng đăng nhập lại.';
        }
        break;
    case 'update_settings':
        $title = addslashes(strip_tags($_REQUEST['title']));
        $description = addslashes(strip_tags($_REQUEST['description']));
        $logo = addslashes(strip_tags($_REQUEST['logo']));
        $hotline = addslashes(strip_tags($_REQUEST['hotline']));
    
        $settings = [
            'title' => $title,
            'description' => $description,
            'logo' => $logo,
            'hotline' => $hotline,
        ];
    
        foreach ($settings as $name => $value) {
            $thongtin = mysqli_query($conn, "SELECT * FROM shop_setting WHERE shop='$user_id' AND name='$name'");
            if (mysqli_num_rows($thongtin) > 0) {
                mysqli_query($conn, "UPDATE shop_setting SET value='$value' WHERE shop='$user_id' AND name='$name'");
            } else {
                mysqli_query($conn, "INSERT INTO shop_setting (shop, name, value) VALUES ('$user_id', '$name', '$value')");
            }
        }
        $ok = 1;
        $thongbao = 'Cập nhật cài đặt thành công!';
        break;
    default:
        $ok = 0;
        $thongbao = 'Hành động không hợp lệ!';
}

$info = [
    'ok' => $ok,
    'thongbao' => $thongbao,
];
echo json_encode($info);
?>