<?php
if (in_array('hoahong', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
    echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
    exit();
}
$user = intval($_REQUEST['user']);
$thongtin_nhom = mysqli_query($conn, "SELECT * FROM user_info WHERE aff='$user' AND leader='0'");
while ($r_n = mysqli_fetch_assoc($thongtin_nhom)) {
    $list_id .= $r_n['user_id'] . ',';
}
if ($list_id == '') {
} else {
    $list_id = substr($list_id, 0, -1);
    $thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id IN ($list_id) AND status='5' AND date_post >'1680282000'");
    while ($r_tt = mysqli_fetch_assoc($thongtin)) {
        $thongtin_hh = mysqli_query($conn, "SELECT * FROM hoahong_nhom WHERE ma_don='{$r_tt['ma_don']}' AND loai_don='drop' AND nhom='$user'");
        $total_hh = mysqli_num_rows($thongtin_hh);
        if ($total_hh == 0) {
            $hientai = time();
            $hh = intval(($r_tt['tamtinh'] / 100) * 5);
            mysqli_query($conn, "INSERT INTO hoahong_nhom(user_id,nhom,ma_don,loai_don,kieu_don,total,hoa_hong,noi_dung,status,update_post,date_post)VALUES('{$r_tt['user_id']}','$user','{$r_tt['ma_don']}','drop','5%','{$r_tt['tamtinh']}','$hh','','0','$hientai','$hientai')");
        }
    }
    $thongtin_ctv = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE user_id IN ($list_id) AND status='5' AND date_post >'1680282000'");
    while ($r_tt_ctv = mysqli_fetch_assoc($thongtin_ctv)) {
        $thongtin_hh_ctv = mysqli_query($conn, "SELECT * FROM hoahong_nhom WHERE ma_don='{$r_tt_ctv['ma_don']}' AND nhom='$user' AND loai_don='ctv'");
        $total_hh_ctv = mysqli_num_rows($thongtin_hh_ctv);
        if ($total_hh_ctv == 0) {
            $hientai = time();
            $hh_ctv = intval(($r_tt_ctv['tamtinh'] / 100) * 5);
            mysqli_query($conn, "INSERT INTO hoahong_nhom(user_id,nhom,ma_don,loai_don,kieu_don,total,hoa_hong,noi_dung,status,update_post,date_post)VALUES('{$r_tt_ctv['user_id']}','$user','{$r_tt_ctv['ma_don']}','ctv','5%','{$r_tt_ctv['tamtinh']}','$hh_ctv','','0','$hientai','$hientai')");
        }
    }
}
$info = array(
    'thongbao' => 'Cập nhật thành công',
    'ok' => 1
);
echo json_encode($info);
