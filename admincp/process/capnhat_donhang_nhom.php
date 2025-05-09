<?php
if (in_array('hoahong', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
    echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
    exit();
}
$user = intval($_REQUEST['user']);
$thongtin_nhom = mysqli_query($conn, "SELECT * FROM user_info WHERE aff='$user' AND leader='1'");
while ($r_n = mysqli_fetch_assoc($thongtin_nhom)) {
    $list_id .= $r_n['user_id'] . ',';
}
if ($list_id == '') {
} else {
    $list_id = substr($list_id, 0, -1);
    $thongtin_don_leader = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id IN ($list_id) AND status='5' AND date_post >'1680282000'");
    while ($r_d_l = mysqli_fetch_assoc($thongtin_don_leader)) {
        $thongtin_taikhoan = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_d_l['user_id']}'");
        $r_tk_l_d = mysqli_fetch_assoc($thongtin_taikhoan);
        if ($r_tk_l_d['leader_start'] > $r_d_l['date_post']) {
            $thongtin_hh_leader = mysqli_query($conn, "SELECT * FROM hoahong_nhom WHERE ma_don='{$r_d_l['ma_don']}' AND nhom='$user' AND loai_don='drop'");
            $total_hh_leader = mysqli_num_rows($thongtin_hh_leader);
            if ($total_hh_leader == 0) {
                $hientai = time();
                $hh_leader = intval(($r_d_l['tamtinh'] / 100) * 5);
                mysqli_query($conn, "INSERT INTO hoahong_nhom(user_id,nhom,ma_don,loai_don,kieu_don,total,hoa_hong,noi_dung,status,update_post,date_post)VALUES('{$r_d_l['user_id']}','$user','{$r_d_l['ma_don']}','drop','5%','{$r_d_l['tamtinh']}','$hh_leader','','0','$hientai','$hientai')");
            }
        } else {
            $thongtin_hh_leader = mysqli_query($conn, "SELECT * FROM hoahong_nhom WHERE ma_don='{$r_d_l['ma_don']}' AND nhom='$user' AND loai_don='drop'");
            $total_hh_leader = mysqli_num_rows($thongtin_hh_leader);
            if ($total_hh_leader == 0) {
                $hientai = time();
                $hh_leader = intval(($r_d_l['tamtinh'] / 100) * 1.5);
                mysqli_query($conn, "INSERT INTO hoahong_nhom(user_id,nhom,ma_don,loai_don,kieu_don,total,hoa_hong,noi_dung,status,update_post,date_post)VALUES('{$r_d_l['user_id']}','$user','{$r_d_l['ma_don']}','drop','1.5%','{$r_d_l['tamtinh']}','$hh_leader','','0','$hientai','$hientai')");
            }
        }
    }
    $thongtin_don_leader_ctv = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE user_id IN ($list_id) AND status='5' AND date_post >'1680282000'");
    while ($r_d_l_ctv = mysqli_fetch_assoc($thongtin_don_leader_ctv)) {
        $thongtin_taikhoan_ctv = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_d_l_ctv['user_id']}'");
        $r_tk_l_d_ctv = mysqli_fetch_assoc($thongtin_taikhoan_ctv);
        if ($r_tk_l_d_ctv['leader_start'] > $r_d_l_ctv['date_post']) {
            $thongtin_hh_leader_ctv = mysqli_query($conn, "SELECT * FROM hoahong_nhom WHERE ma_don='{$r_d_l_ctv['ma_don']}' AND nhom='$user' AND loai_don='ctv'");
            $total_hh_leader_ctv = mysqli_num_rows($thongtin_hh_leader_ctv);
            if ($total_hh_leader_ctv == 0) {
                $hientai = time();
                $hh_leader_ctv = intval(($r_d_l_ctv['tamtinh'] / 100) * 5);
                mysqli_query($conn, "INSERT INTO hoahong_nhom(user_id,nhom,ma_don,loai_don,kieu_don,total,hoa_hong,noi_dung,status,update_post,date_post)VALUES('{$r_d_l_ctv['user_id']}','$user','{$r_d_l_ctv['ma_don']}','ctv','5%','{$r_d_l_ctv['tamtinh']}','$hh_leader_ctv','','0','$hientai','$hientai')");
            }
        } else {
            $thongtin_hh_leader_ctv = mysqli_query($conn, "SELECT * FROM hoahong_nhom WHERE ma_don='{$r_d_l_ctv['ma_don']}' AND nhom='$user' AND loai_don='ctv'");
            $total_hh_leader_ctv = mysqli_num_rows($thongtin_hh_leader_ctv);
            if ($total_hh_leader_ctv == 0) {
                $hientai = time();
                $hh_leader_ctv = intval(($r_d_l_ctv['tamtinh'] / 100) * 1.5);
                mysqli_query($conn, "INSERT INTO hoahong_nhom(user_id,nhom,ma_don,loai_don,kieu_don,total,hoa_hong,noi_dung,status,update_post,date_post)VALUES('{$r_d_l_ctv['user_id']}','$user','{$r_d_l_ctv['ma_don']}','ctv','1.5%','{$r_d_l_ctv['tamtinh']}','$hh_leader_ctv','','0','$hientai','$hientai')");
            }
        }
    }
    $list_tv_id = '';
    $thongtin_thanhvien = mysqli_query($conn, "SELECT * FROM user_info WHERE aff IN ($list_id)");
    while ($r_tv = mysqli_fetch_assoc($thongtin_thanhvien)) {
        $list_tv_id .= $r_tv['user_id'] . ',';
    }
    if ($list_tv_id == '') {
    } else {
        $list_tv_id = substr($list_tv_id, 0, -1);
        $thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id IN ($list_tv_id) AND status='5' AND date_post >'1680282000'");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $thongtin_hh = mysqli_query($conn, "SELECT * FROM hoahong_nhom WHERE ma_don='{$r_tt['ma_don']}' AND nhom='$user' AND loai_don='drop'");
            $total_hh = mysqli_num_rows($thongtin_hh);
            if ($total_hh == 0) {
                $hientai = time();
                $hh = intval(($r_tt['tamtinh'] / 100) * 1.5);
                mysqli_query($conn, "INSERT INTO hoahong_nhom(user_id,nhom,ma_don,loai_don,kieu_don,total,hoa_hong,noi_dung,status,update_post,date_post)VALUES('{$r_tt['user_id']}','$user','{$r_tt['ma_don']}','drop','1.5%','{$r_tt['tamtinh']}','$hh','','0','$hientai','$hientai')");
            }
        }
        $thongtin_ctv = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE user_id IN ($list_tv_id) AND status='5' AND date_post >'1680282000'");
        while ($r_tt_ctv = mysqli_fetch_assoc($thongtin_ctv)) {
            $thongtin_hh_ctv = mysqli_query($conn, "SELECT * FROM hoahong_nhom WHERE ma_don='{$r_tt_ctv['ma_don']}' AND nhom='$user' AND loai_don='ctv'");
            $total_hh_ctv = mysqli_num_rows($thongtin_hh_ctv);
            if ($total_hh_ctv == 0) {
                $hientai = time();
                $hh_ctv = intval(($r_tt_ctv['tamtinh'] / 100) * 1.5);
                mysqli_query($conn, "INSERT INTO hoahong_nhom(user_id,nhom,ma_don,loai_don,kieu_don,total,hoa_hong,noi_dung,status,update_post,date_post)VALUES('{$r_tt_ctv['user_id']}','$user','{$r_tt_ctv['ma_don']}','ctv','1.5%','{$r_tt_ctv['tamtinh']}','$hh_ctv','','0','$hientai','$hientai')");
            }
        }
    }
}
$info = array(
    'thongbao' => 'Cập nhật thành công',
    'ok' => 1
);
echo json_encode($info);
