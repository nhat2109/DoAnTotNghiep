<?php
if (in_array('hoahong', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
    echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
    exit();
}
$hh = intval($_REQUEST['hh']);
$thongtin = mysqli_query($conn, "SELECT hoahong_nhom.*,user_info.username FROM hoahong_nhom LEFT JOIN user_info ON hoahong_nhom.user_id=user_info.user_id WHERE hoahong_nhom.id='$hh'");
$total = mysqli_num_rows($thongtin);
$hientai = time();
if ($total == 0) {
    $thongbao = 'Thất bại! Dữ liệu không tồn tại';
    $ok = 0;
} else {
    $r_tt = mysqli_fetch_assoc($thongtin);
    if ($r_tt['status'] == 0) {
        $thongbao = 'Thành công! Đã thanh toán hoa hồng';
        $ok = 1;
        $thongtin_nhom = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['nhom']}'");
        $r_n = mysqli_fetch_assoc($thongtin_nhom);
        $truoc = $r_n['user_money'] + $r_n['user_money2'];
        $sotien = $r_tt['hoa_hong'];
        $sau = $truoc + $sotien;
        $moi = $r_n['user_money'] + $sotien;
        mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='{$r_n['user_id']}'");
        if ($r_tt['kieu_don'] == '1.5%') {
            $noidung = 'Thanh toán hoa hồng 1.5%(hoa hồng nhóm bán hàng chuyên nghiệp) từ đơn hàng #' . $r_tt['ma_don'] . ' của thành viên ' . $r_tt['username'];
        } else {
            $noidung = 'Thanh toán hoa hồng ' . $r_tt['kieu_don'] . ' từ đơn hàng #' . $r_tt['ma_don'] . ' của thành viên ' . $r_tt['username'];
        }
        mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('{$r_n['user_id']}','$sotien','$truoc','$sau','$noidung'," . time() . ")");
        mysqli_query($conn, "UPDATE hoahong_nhom SET status='1',noi_dung='$noidung',update_post='$hientai' WHERE id='$hh'");
    } else {
        $thongbao = 'Thất bại! Đã thanh toán hoa hồng';
        $ok = 0;
    }
}
$info = array(
    'thongbao' => $thongbao,
    'ok' => $ok
);
echo json_encode($info);
