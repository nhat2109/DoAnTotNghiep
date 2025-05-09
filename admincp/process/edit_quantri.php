<?php
$password = strip_tags(addslashes($_REQUEST['password']));
$name = strip_tags(addslashes($_REQUEST['name']));
$mobile = preg_replace('/[^0-9]/', '', $_REQUEST['mobile']);
$email = strip_tags(addslashes($_REQUEST['email']));
$address = strip_tags(addslashes($_REQUEST['address']));
$group = strip_tags(addslashes($_REQUEST['group']));
$bo_phan = strip_tags(addslashes($_REQUEST['bo_phan']));
$id = intval($_REQUEST['id']);
$hientai = time();
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if (in_array('quantri', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
        echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
        exit();
    }
    if (strlen($group) < 3) {
        $thongbao = "Thất bại! Chưa chọn khu vực quản trị";
        $ok = 0;
    } else {
        $thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM emin_info WHERE id='$id'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        if ($r_tt['total'] == 0) {
            $thongbao = 'Thất bại! Tài khoản không tồn tại';
            $ok = 0;
        } else {
            if (strlen($password) >= 6) {
                $pass = md5($password);
            } else {
                $pass = $r_tt['password'];
            }
            if ($r_tt['emin_group'] != 1) {
                mysqli_query($conn, "UPDATE emin_info SET password='$pass', name='$name',mobile='$mobile',email='$email',address='$address',bo_phan='$bo_phan',emin_group='$group' WHERE id='$id'");
            } else {
                if ($_COOKIE['emin_id'] == $id) {
                    mysqli_query($conn, "UPDATE emin_info SET password='$pass', name='$name',mobile='$mobile',email='$email',address='$address' WHERE id='$id'");
                } else {
                    mysqli_query($conn, "UPDATE emin_info SET name='$name',mobile='$mobile',email='$email',address='$address' WHERE id='$id'");
                }
            }
            $ok = 1;
            $thongbao = 'Sửa quản trị thành công!';
        }
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao
);
echo json_encode($info);
