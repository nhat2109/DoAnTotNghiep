<?php
$username = addslashes(strip_tags($_REQUEST['username']));
$password = addslashes($_REQUEST['password']);
$remember = strip_tags(addslashes($_REQUEST['remember']));
$ketqua = $class_e_member->login($conn, $username, $password, $remember);
if ($ketqua == 200) {
    $ok = 1;
    $thongbao = "Đăng nhập thành công";
} else if ($ketqua == 0) {
    $ok = 0;
    $thongbao = "Vui lòng nhập username";
} else if ($ketqua == 1) {
    $ok = 0;
    $thongbao = "Tài khoản không tồn tại";
} else if ($ketqua == 2) {
    $ok = 0;
    $thongbao = "Mật khẩu không chính xác";
} else {
    $ok = 0;
    $thongbao = "Gặp lỗi khi xử lý";
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
