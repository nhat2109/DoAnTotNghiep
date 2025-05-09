<?php 
$name = strip_tags(addslashes($_REQUEST['name']));
$mobile = preg_replace('/[^0-9]/', '', $_REQUEST['mobile']);
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if (strlen($name) < 2) {
        $thongbao = "Vui lòng nhập họ và tên";
        $ok = 0;
    } else {
        $user_id = $user_info['id'];
        mysqli_query($conn, "UPDATE emin_info SET name='$name',mobile='$mobile' WHERE id='$user_id'");
        $ok = 1;
        $thongbao = 'Sửa thông tin thành công!';
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>