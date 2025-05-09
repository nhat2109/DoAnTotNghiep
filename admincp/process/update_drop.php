<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    $user_id = str_replace('drop_', '', addslashes($_REQUEST['user_id']));
    $status = intval($_REQUEST['status']);
    
    if ($status == 1) {
        $thongtin_thanhvien = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$user_id'");
        if (mysqli_num_rows($thongtin_thanhvien) == 0) {
            $ok = 0;
            $thongbao = 'User không tồn tại';
        } else {
            $r_tv = mysqli_fetch_assoc($thongtin_thanhvien);
            $domain = $r_tv['username'] . '.socdo.vn';
            mysqli_query($conn, "UPDATE user_info SET domain='$domain' WHERE user_id='$user_id'");
            
            $tien_kh = 0;
            $date_post = time();
            $insert_query = mysqli_query($conn, "INSERT INTO user_kh (user_id, tien_kh, date_post, da_cong_tien) 
                                               VALUES ('$user_id', '$tien_kh', '$date_post', 0) 
                                               ON DUPLICATE KEY UPDATE tien_kh='$tien_kh', da_cong_tien=0");
            if (!$insert_query) {
                $ok = 0;
                $thongbao = 'Lỗi khi insert vào user_kh: ' . mysqli_error($conn);
            } else {
                // Xử lý bảng nhom
                $thongtin_nhom = mysqli_query($conn, "SELECT *,count(*) AS total FROM nhom WHERE nhomtruong='{$r_tv['aff']}' AND nhomtruong!=''");
                $r_nhom = mysqli_fetch_assoc($thongtin_nhom);
                if ($r_nhom['total'] > 0) {
                    if (strpos($r_nhom['thanhvien'], ',') !== false) {
                        $tach_nhom = explode(',', $r_nhom['thanhvien']);
                        if (!in_array($user_id, $tach_nhom)) {
                            $moi = $r_nhom['thanhvien'] . ',' . $user_id;
                            mysqli_query($conn, "UPDATE nhom SET thanhvien='$moi' WHERE id='{$r_nhom['id']}'");
                        }
                    } else {
                        $moi = $r_nhom['thanhvien'] ? $r_nhom['thanhvien'] . ',' . $user_id : $user_id;
                        mysqli_query($conn, "UPDATE nhom SET thanhvien='$moi' WHERE id='{$r_nhom['id']}'");
                    }
                }
                $ok = 1;
                $thongbao = 'Cập nhật thành công';
            }
        }
    } else if ($status == 4) {
        $delete_query = mysqli_query($conn, "DELETE FROM user_kh WHERE user_id='$user_id'");
        if (!$delete_query) {
            $ok = 0;
            $thongbao = 'Lỗi khi xóa user_kh: ' . mysqli_error($conn);
        } else {
            $ok = 1;
            $thongbao = 'Cập nhật thành công';
        }
    } else {
        $ok = 1;
        $thongbao = 'Cập nhật thành công';
    }
    
    $hientai = time();
    $update_query = mysqli_query($conn, "UPDATE user_info SET dropship='$status', date_update='$hientai' WHERE user_id='$user_id'");
    if (!$update_query) {
        $ok = 0;
        $thongbao = 'Lỗi khi cập nhật user_info: ' . mysqli_error($conn);
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
?>