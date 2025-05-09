<?php

$username = strip_tags(addslashes($_REQUEST['username']));
$password = strip_tags(addslashes($_REQUEST['password']));
$name = strip_tags(addslashes($_REQUEST['name']));
$mobile = preg_replace('/[^0-9]/', '', $_REQUEST['mobile']);
$email = strip_tags(addslashes($_REQUEST['email']));
$address = strip_tags(addslashes($_REQUEST['address']));
$group = strip_tags(addslashes($_REQUEST['group']));
$bo_phan = strip_tags(addslashes($_REQUEST['bo_phan']));
$hientai = time();
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if (in_array('quantri', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
        echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này' . $user_info['emin_group']));
        exit();
    }
    if (strlen($username) < 4) {
        $thongbao = "Thất bại! Hãy nhập tài khoản dài từ 4 ký tự";
        $ok = 0;
    } else if (strlen($password) < 6) {
        $thongbao = "Thất bại! Hãy nhập mật khẩu dài từ 6 ký tự";
        $ok = 0;
    } else if (strlen($group) < 3) {
        $thongbao = "Thất bại! Chưa chọn khu vực quản trị";
        $ok = 0;
    } else {
        $thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM emin_info WHERE username='$username'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] > 0) {
            $thongbao = 'Thất bại! Tài khoản đã tồn tại';
            $ok = 0;
        } else {
            $pass = md5($password);
            mysqli_query($conn, "INSERT INTO emin_info (username,password,email,name,avatar,mobile,address,bo_phan,emin_group,logined,created)VALUES('$username','$pass','$email','$name','$avatar','$mobile','$address','$bo_phan','$group','','$hientai')");
            $ok = 1;
            $thongbao = 'Thêm quản trị viên thành công!';
        }
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao
);
echo json_encode($info);
