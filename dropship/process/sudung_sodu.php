<?php
    // xử lý sô tiền để nạp tiền
    $user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
    $tong_duytri = $user_info['user_money'] + $user_info['user_money2'];
    
    if($tong_duytri < 500000){
        $ok = 1;
        $so_tien = 500000 - $tong_duytri; // Số tiền cần nạp
        $thongbao = 'Hệ thống đang chuyển hướng...';
        
        // Sửa biến $sotien thành $so_tien
        $result1 = mysqli_query($conn, "INSERT INTO naptien(user_id,sotien,status,date_post,update_post)
                           VALUES('$user_id','$so_tien','0'," . time() . "," . time() . ")");
        
        if($result1) {
            $thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
            $r_tt = mysqli_fetch_assoc($thongtin);
            $_SESSION['naptien'] = $r_tt['id'];
            $r_tt['username'] = $user_info['username'];
            $so_tien = number_format($r_tt['sotien']);
            $r_tt['so_tien'] = $so_tien;
            $step2 = $skin->skin_replace('skin_dropship/box_action/step_kh_2', $r_tt);
        } else {
            $ok = 2; // Mã lỗi
            $thongbao = 'Có lỗi khi tạo yêu cầu nạp tiền';
            $step2 = '';
        }
    } 
    else {
        // Trừ tiền từ user_money hoặc user_money2
        if ($user_info['user_money'] >= 500000) {
            $new_user_money = $user_info['user_money'] - 500000;
            $new_user_money2 = $user_info['user_money2'];
        } else {
            $new_user_money = 0;
            $new_user_money2 = $user_info['user_money2'] - (500000 - $user_info['user_money']);
        }
    
        // Cập nhật lại số dư trong bảng user_info
        $result2 = mysqli_query($conn, "UPDATE user_info SET user_money = '$new_user_money', 
                              user_money2 = '$new_user_money2' WHERE user_id = '$user_id'");
    
        if($result2) {
            // Ghi thông tin vào bảng user_kh
            $tien_kh = 500000;
            $date_post = time();
            $result3 = mysqli_query($conn, "INSERT INTO user_kh (user_id, tien_kh, date_post) 
                                 VALUES ('$user_id', '$tien_kh', '$date_post')");
            $truoc = 0;
            $sau = 0;
            $noidung = "Kích hoạt tài khoản bán hàng";
            $result4 = mysqli_query($conn, "INSERT INTO lichsu_chitieu (user_id,sotien,truoc,sau,noidung,date_post) 
                                 VALUES ('$user_id', '$tien_kh', '$truoc', '$sau', '$noidung', '$date_post')");
            if($result3 && $result4) {
                $ok = 0;
                $thongbao = '<span style="color: red">Kích hoạt thành công! Số tiền đã được trừ từ tài khoản của bạn.</span>';
            } else {
                $ok = 2;
                $thongbao = 'Lỗi khi lưu thông tin kích hoạt';
            }
        } else {
            $ok = 2;
            $thongbao = 'Lỗi khi cập nhật số dư';
        }
        $step2 = '';
    }
    
    $info = array(
        'ok' => $ok,
        'step2' => $step2,
        'thongbao' => $thongbao,
    );
    echo json_encode($info);
?>