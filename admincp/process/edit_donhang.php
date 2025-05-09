<?php
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if (in_array('donhang', explode(',', $user_info['emin_group'])) == false and $user_info['emin_group'] != 1) {
        echo json_encode(array('ok' => 0, 'thongbao' => 'Bạn không có quyền thực hiện hành động này'));
        exit();
    }
    $status = intval($_REQUEST['status']);
    $id = intval($_REQUEST['id']);
    $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM donhang WHERE id='$id'");
    $r_tt = mysqli_fetch_assoc($thongtin);
    $hientai = time();
    if ($r_tt['total'] == 0) {
        $ok = 0;
        $thongbao = 'Thất bại! Đơn hàng không tồn tại';
    } else {
        if ($status == 0) {
            if ($r_tt['status'] == 0) {
                mysqli_query($conn, "UPDATE donhang SET status='$status',date_update='$hientai' WHERE id='$id'");
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = 'Thất bại! Không thể lưu trạng thái này';
            }
        } else if ($status == 1) {
            if ($r_tt['status'] == 0) {
                mysqli_query($conn, "UPDATE donhang SET status='$status',date_update='$hientai' WHERE id='$id'");
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = 'Thất bại! Không thể lưu trạng thái này';
            }
        } else if ($status == 2) {
            if ($r_tt['status'] == 0 or $r_tt['status'] == 1) {
                mysqli_query($conn, "UPDATE donhang SET status='$status',date_update='$hientai' WHERE id='$id'");
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = 'Thất bại! Không thể lưu trạng thái này';
            }
        } else if ($status == 3) {
            if ($r_tt['status'] == 0) {
                mysqli_query($conn, "UPDATE donhang SET status='$status',date_update='$hientai' WHERE id='$id'");
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = 'Thất bại! Không thể lưu thay đổi';
            }
        } else if ($status == 4) {
            if ($r_tt['status'] == 3) {
                mysqli_query($conn, "UPDATE donhang SET status='$status',date_update='$hientai' WHERE id='$id'");
                if ($r_tt['dropship'] == 1 and $r_tt['status'] != 4) {
                    $thongtin_thanhvien = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}'");
                    $r_tv = mysqli_fetch_assoc($thongtin_thanhvien);
                    $moi = $r_tt['tongtien'] + $r_tv['user_money'];
                    $truoc = $r_tv['user_money'] + $r_tv['user_money2'];
                    $sau = $truoc + $r_tt['tongtien'];
                    $noidung = 'Xác nhận hủy đơn hàng #' . $r_tt['ma_don'];
                    mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('{$r_tt['user_id']}','{$r_tt['tongtien']}','$truoc','$sau','$noidung'," . time() . ")");
                    mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='{$r_tt['user_id']}'");
                }
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = 'Thất bại! Không thể lưu trạng thái này';
            }
        } else if ($status == 5) {
            if ($r_tt['status'] != 3 and $r_tt['status'] != 4 and $r_tt['status'] != 6) {
                mysqli_query($conn, "UPDATE donhang SET status='$status',date_update='$hientai' WHERE id='$id'");
                if ($r_tt['status'] != 5) {
                    $thongtin_tichdiem = mysqli_query($conn, "SELECT *,count(*) AS total FROM tich_diem WHERE don='{$r_tt['ma_don']}' AND user_id='{$r_tt['user_id']}'");
                    $r_td = mysqli_fetch_assoc($thongtin_tichdiem);
                    if ($r_td['total'] > 0) {
                        mysqli_query($conn, "UPDATE tich_diem SET status='1' WHERE user_id='{$r_tt['user_id']}' AND don='{$r_tt['ma_don']}'");
                        $thongtin_diem = mysqli_query($conn, "SELECT *,count(*) AS total FROM diem WHERE user_id='{$r_tt['user_id']}'");
                        $r_diem = mysqli_fetch_assoc($thongtin_diem);
                        if ($r_diem['total'] > 0) {
                            $moi = $r_diem['diem'] + $r_td['diem'];
                            mysqli_query($conn, "UPDATE diem SET diem='$moi' WHERE user_id='{$r_tt['user_id']}'");
                        } else {
                            mysqli_query($conn, "INSERT INTO diem(user_id,diem)VALUES('{$r_tt['user_id']}','{$r_td['diem']}')");
                        }
                    }
                }
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = 'Thất bại! Không thể lưu trạng thái này';
            }
        } else if ($status == 6) {
            if ($r_tt['status'] == 3) {
                $ok = 0;
                $thongbao = 'Thất bại! Đơn hàng này đang yêu cầu hủy';
            } else if ($r_tt['status'] == 4) {
                $ok = 0;
                $thongbao = 'Thất bại! Đơn hàng này đã bị hủy';
            } else {
                mysqli_query($conn, "UPDATE donhang SET status='$status',date_update='$hientai' WHERE id='$id'");
                if ($r_tt['dropship'] == 1 and $r_tt['status'] != 6) {
                    $thongtin_thanhvien = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='{$r_tt['user_id']}'");
                    $r_tv = mysqli_fetch_assoc($thongtin_thanhvien);
                    $moi = $r_tt['tongtien'] + $r_tv['user_money'];
                    $truoc = $r_tv['user_money'] + $r_tv['user_money2'];
                    $sau = $truoc + $r_tt['tongtien'];
                    $noidung = 'Hoàn đơn hàng #' . $r_tt['ma_don'];
                    mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('{$r_tt['user_id']}','{$r_tt['tongtien']}','$truoc','$sau','$noidung'," . time() . ")");
                    mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='{$r_tt['user_id']}'");
                }
                $thongbao = 'Lưu thay đổi thành công';
                $ok = 1;
            }
        }
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
