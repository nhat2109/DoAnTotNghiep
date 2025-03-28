<?php
include('../includes/tlca_world.php');
$check = $tlca_do->load('class_check');

header('Content-Type: application/json');


if (isset($_COOKIE['admin_id'])) {
    echo json_encode(['ok' => 1, 'redirect' => '/admin/']);
    exit();
}


$username = addslashes(strip_tags($_POST['username'] ?? ''));
$password = addslashes(strip_tags($_POST['password'] ?? ''));
$remember = isset($_POST['remember']) ? $_POST['remember'] : 'off';


$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE username='$username' AND active='1' LIMIT 1");
$total = mysqli_num_rows($thongtin);

if ($total > 0) {
    $r_tt = mysqli_fetch_assoc($thongtin);
    if (md5($password) != $r_tt['password']) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Mật khẩu không đúng']);
    } else {
        $token = $check->token_login_decode($r_tt['user_id']);
        $expire_time = ($remember == 'on') ? time() + 2592000 : time() + 3600;
        setcookie('admin_id', $token, $expire_time, '/');
        echo json_encode(['ok' => 1, 'redirect' => '/admin/']);
    }
} else {
    echo json_encode(['ok' => 0, 'thongbao' => 'Tài khoản không tồn tại hoặc không có quyền admin']);
}
?>