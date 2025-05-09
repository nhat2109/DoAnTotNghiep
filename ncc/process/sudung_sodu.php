<?php
$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
$tong_duytri = $user_info['user_money'] + $user_info['user_money2'];

$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
$tong_duytri = $user_info['user_money'] + $user_info['user_money2'];

if ($tong_duytri < 2500000) {
    $ok = 1;
    $so_tien = 2500000 - $tong_duytri;
    $thongbao = 'Hệ thống đang chuyển hướng...';

    
    $result1 = mysqli_query($conn, "INSERT INTO naptien(user_id,sotien,status,date_post,update_post)
                           VALUES('$user_id','$so_tien','0'," . time() . "," . time() . ")");

    if ($result1) {
        $thongtin = mysqli_query($conn, "SELECT * FROM naptien WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
        $r_tt = mysqli_fetch_assoc($thongtin);
        $_SESSION['naptien'] = $r_tt['id'];
        $r_tt['username'] = $user_info['username'];
        $so_tien = number_format($r_tt['sotien']);
        $r_tt['so_tien'] = $so_tien;
        $step2 = $skin->skin_replace('skin_ncc/box_action/step_kh_2', $r_tt);

        $info = array(
            'ok' => 0,
            'thongbao' => $thongbao,
            'step2' => $step2,
            'show_step2' => true
        );
    } else {
        $ok = 2; 
        $thongbao = 'Có lỗi khi tạo yêu cầu nạp tiền';
        $step2 = '';

        $info = array(
            'ok' => 0,
            'thongbao' => $thongbao,
            'step2' => ''
        );
    }
} else {
    if ($user_info['user_money'] >= 2500000) {
        $new_user_money = $user_info['user_money'] - 2500000;
        $new_user_money2 = $user_info['user_money2'];
    } else {
        $new_user_money = 0;
        $new_user_money2 = $user_info['user_money2'] - (2500000 - $user_info['user_money']);
    }

    $result2 = mysqli_query($conn, "UPDATE user_info SET user_money = '$new_user_money', 
                              user_money2 = '$new_user_money2' WHERE user_id = '$user_id'");

    if ($result2) {
        $tien_kh = 2500000;
        $da_cong_tien = 0;
        $date_active = time();
        $date_expired = $date_active + (365 * 86400);
        $date_post = time();

        $truoc = $user_info['user_money'] + $user_info['user_money2'];
        $sau = $new_user_money + $new_user_money2;

        $result3 = false;
        $result4 = false;

        $check = mysqli_query($conn, "SELECT * FROM user_gh WHERE user_id = '$user_id'");
        if (mysqli_num_rows($check) == 0) {
            $result3 = mysqli_query($conn, "INSERT INTO user_gh (
            user_id, tien_kh, da_cong_tien, date_active, date_expired
        ) VALUES (
            '$user_id', '$tien_kh', '0', '$date_active', '$date_expired'
        )");
        } else {
            $result3 = mysqli_query($conn, "UPDATE user_gh SET 
            tien_kh = '$tien_kh',
            date_active = '$date_active',
            date_expired = '$date_expired'
            WHERE user_id = '$user_id'
        ");
        }

        $result4 = mysqli_query($conn, "INSERT INTO lichsu_chitieu (
        user_id, sotien, truoc, sau, noidung, date_post
    ) VALUES (
        '$user_id', '$tien_kh', '$truoc', '$sau', 'Kích hoạt tài khoản NCC', '$date_post'
    )");

        if ($result3 && $result4) {
            $ok = 1;
            $thongbao = '<span style="color: red">Gia hạn thành công! Số tiền đã được trừ vào tài khoản của bạn.</span>';

            mysqli_query($conn, "UPDATE user_info SET ctv='1' WHERE user_id='$user_id'");

            $info = array(
                'ok' => $ok,
                'thongbao' => $thongbao,
                'step2' => '',
                'expire_time' => $date_expired,
                'reload' => true
            );
        } else {
            $info = array(
                'ok' => 2,
                'thongbao' => 'Lỗi khi lưu thông tin kích hoạt: ' . mysqli_error($conn),
                'step2' => '',
                'expire_time' => 0
            );
        }
    }
}
echo json_encode($info);
