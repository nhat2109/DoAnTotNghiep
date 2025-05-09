<?php
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if (in_array('naptien', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
        echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
        exit();
    }
    $username = addslashes(strip_tags($_REQUEST['username']));
    $sotien = preg_replace('/[^0-9-]/', '', $_REQUEST['sotien']);
    $loai = intval($_REQUEST['loai']);
    $noidung = addslashes(strip_tags($_REQUEST['noidung']));
    $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE username='$username' AND shop='0'");
    $r_tt = mysqli_fetch_assoc($thongtin);
    if ($r_tt['total'] == 0) {
        $ok = 0;
        $thongbao = 'Thất bại! Thành viên không tồn tại';
    } else {
        $truoc = $r_tt['user_money'] + $r_tt['user_money2'];
        $sau = $truoc + $sotien;
        if ($loai == 1) {
            $moi = $r_tt['user_money'] + $sotien;
            mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='{$r_tt['user_id']}'");
        } else {
            $moi = $r_tt['user_money2'] + $sotien;
            mysqli_query($conn, "UPDATE user_info SET user_money2='$moi' WHERE user_id='{$r_tt['user_id']}'");
        }
        mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('{$r_tt['user_id']}','$sotien','$truoc','$sau','$noidung'," . time() . ")");
        $ok = 1;
        $thongbao = 'Thêm giao dịch thành công';
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
