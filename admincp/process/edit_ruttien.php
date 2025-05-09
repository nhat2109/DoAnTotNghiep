<?php
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if (in_array('ruttien', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
        echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
        exit();
    }
    $status = intval($_REQUEST['status']);
    $id = intval($_REQUEST['id']);
    $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM rut_tien WHERE id='$id'");
    $r_tt = mysqli_fetch_assoc($thongtin);
    if ($r_tt['total'] == 0) {
        $ok = 0;
        $thongbao = 'Thất bại! Giao dịch không tồn tại';
    } else {
        if ($r_tt['status'] == 0) {
            mysqli_query($conn, "UPDATE rut_tien SET status='$status'WHERE id='$id'");
            $thongbao = 'Lưu thay đổi thành công';
            $ok = 1;
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
