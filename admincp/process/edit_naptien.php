<?php
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if (in_array('naptien', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
        echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
        exit();
    }
    $status = intval($_REQUEST['status']);
    $id = intval($_REQUEST['id']);
    $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM naptien WHERE id='$id'");
    $r_tt = mysqli_fetch_assoc($thongtin);
    $hientai = time();
    if ($r_tt['total'] == 0) {
        $ok = 0;
        $thongbao = 'Thất bại! Giao dịch không tồn tại';
    } else {
        if ($r_tt['status'] == 0 or $r_tt['status'] == 3) {
            mysqli_query($conn, "UPDATE naptien SET status='$status',update_post='$hientai' WHERE id='$id'");
            $thongbao = 'Lưu thay đổi thành công';
            $ok = 1;
            if ($status == 1) {
                $thongtin_thanhvien = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}'");
                $r_tv = mysqli_fetch_assoc($thongtin_thanhvien);
                $moi = $r_tt['sotien'] + $r_tv['user_money'];
                $truoc = $r_tv['user_money'] + $r_tv['user_money2'];
                $sau = $truoc + $r_tt['sotien'];
                $noidung = 'Hoàn thành giao dịch nạp tiền "naptien ' . $r_tv['username'] . ' ' . $r_tt['id'] . '"';
                mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('{$r_tt['user_id']}','{$r_tt['sotien']}','$truoc','$sau','$noidung'," . time() . ")");
                mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='{$r_tt['user_id']}'");
            }
        } else {
            if ($r_tt['status'] == 1) {
                $ok = 0;
                $thongbao = 'Thất bại! Giao dịch này đã hoàn thành';
            } else if ($r_tt['status'] == 2) {
                $ok = 0;
                $thongbao = 'Thất bại! Giao dịch này đã hủy';
            }
        }
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
