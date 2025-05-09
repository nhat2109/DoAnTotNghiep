<?php

// Lấy dữ liệu từ request
$name = strip_tags(addslashes($_REQUEST['name']));
$mobile = preg_replace('/[^0-9]/', '', $_REQUEST['mobile']);
$tinh = intval($_REQUEST['tinh']);
$huyen = intval($_REQUEST['huyen']);
$xa = intval($_REQUEST['xa']);
$dia_chi = addslashes($_REQUEST['dia_chi']);
$email = addslashes($_REQUEST['email']);
$maso_thue = addslashes($_REQUEST['maso_thue']);
$maso_thue_cap = addslashes($_REQUEST['maso_thue_cap'] ?? '');
$maso_thue_noicap = addslashes($_REQUEST['maso_thue_noicap'] ?? '');
$ten_daidien = strip_tags(addslashes($_REQUEST['ten_daidien']));
$chucvu = strip_tags(addslashes($_REQUEST['chucvu']));

// Kiểm tra dữ liệu
if (strlen($name) < 2) {
    $thongbao = "Vui lòng nhập tên công ty/hộ kinh doanh đầy đủ (ít nhất 2 ký tự)";
    $ok = 0;
} elseif (strlen($mobile) < 10 || !preg_match('/^0[0-9]{9}$/', $mobile)) {
    $thongbao = "Vui lòng nhập số điện thoại hợp lệ (10 chữ số, bắt đầu bằng 0)";
    $ok = 0;
} elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $thongbao = "Vui lòng nhập email hợp lệ";
    $ok = 0;
} elseif (empty($maso_thue)) {
    $thongbao = "Vui lòng nhập mã số thuế hoặc CCCD";
    $ok = 0;
} elseif (empty($ten_daidien)) {
    $thongbao = "Vui lòng nhập tên người đại diện";
    $ok = 0;
} elseif (empty($chucvu)) {
    $thongbao = "Vui lòng nhập chức vụ";
    $ok = 0;
} elseif (empty($tinh)) {
    $thongbao = "Vui lòng chọn tỉnh/thành phố";
    $ok = 0;
} elseif (empty($huyen)) {
    $thongbao = "Vui lòng chọn quận/huyện";
    $ok = 0;
} elseif (empty($xa)) {
    $thongbao = "Vui lòng chọn phường/xã";
    $ok = 0;
} elseif (empty($dia_chi)) {
    $thongbao = "Vui lòng nhập địa chỉ chi tiết";
    $ok = 0;
} else {
    // Kiểm tra xem user_id đã tồn tại trong user_ncc chưa
    $check_ncc = mysqli_query($conn, "SELECT id FROM user_ncc WHERE user_id = '$user_id' LIMIT 1");
    if (!$check_ncc) {
        error_log('Lỗi truy vấn user_ncc: ' . mysqli_error($conn));
        $thongbao = "Có lỗi khi kiểm tra thông tin nhà cung cấp: " . mysqli_error($conn);
        $ok = 0;
    } elseif (mysqli_num_rows($check_ncc) == 0) {
        $thongbao = "Không tìm thấy thông tin nhà cung cấp. Vui lòng hoàn thành thiết lập trước!";
        $ok = 0;
    } else {
        // Cập nhật thông tin vào bảng user_ncc
        $current_time = date('Y-m-d H:i:s');
        $sql = "UPDATE user_ncc SET 
            name = '$name',
            mobile = '$mobile',
            email = '$email',
            maso_thue = '$maso_thue',
            maso_thue_cap = '$maso_thue_cap',
            maso_thue_noicap = '$maso_thue_noicap',
            ten_daidien = '$ten_daidien',
            chucvu = '$chucvu',
            tinh = '$tinh',
            huyen = '$huyen',
            xa = '$xa',
            dia_chi = '$dia_chi',
            updated_at = '$current_time'
            WHERE user_id = '$user_id'";

        if (mysqli_query($conn, $sql)) {
            // Đồng bộ email và maso_thue với bảng user_info
            $update_user_info = "UPDATE user_info SET 
                email = '$email',
                maso_thue = '$maso_thue',
                mobile = '$mobile',
                name = '$ten_daidien',
                tinh = '$tinh',
                huyen = '$huyen',
                xa = '$xa',
                dia_chi = '$dia_chi',
                maso_thue_cap = '$maso_thue_cap',
                maso_thue_noicap = '$maso_thue_noicap'
                WHERE user_id = '$user_id'";

            if (mysqli_query($conn, $update_user_info)) {
                $thongbao = 'Sửa thông tin thành công!';
                $ok = 1;
            } else {
                error_log('Lỗi đồng bộ user_info: ' . mysqli_error($conn));
                $thongbao = 'Có lỗi khi đồng bộ thông tin với user_info: ' . mysqli_error($conn);
                $ok = 0;
            }
        } else {
            error_log('Lỗi cập nhật user_ncc: ' . mysqli_error($conn));
            $thongbao = 'Có lỗi khi cập nhật thông tin: ' . mysqli_error($conn);
            $ok = 0;
        }
    }
}

$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
?>