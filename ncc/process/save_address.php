<?php
try {
    // Định nghĩa thời gian hiện tại
    $current_time = strtotime("now");

    $address_id = isset($_POST['address_id']) ? intval($_POST['address_id']) : 0;
    $user_id = $tach_token['user_id'];
    $username = $user_info['username'];
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    
    $province = mysqli_real_escape_string($conn, $_POST['tinh']);
    $district = mysqli_real_escape_string($conn, $_POST['huyen']);
    $ward = mysqli_real_escape_string($conn, $_POST['xa']);
    
    $address_detail = mysqli_real_escape_string($conn, $_POST['address_detail']);
    $is_default = isset($_POST['is_default']) ? 1 : 0;
    $is_pickup = isset($_POST['is_pickup']) ? 1 : 0;
    $is_return = isset($_POST['is_return']) ? 1 : 0;

    // Kiểm tra address_detail không rỗng
    if (empty($address_detail)) {
        echo json_encode([
            'ok' => 0,
            'thongbao' => 'Địa chỉ chi tiết không được để trống'
        ]);
        exit;
    }

    // Nếu đặt làm mặc định
    if ($is_default) {
        $sql_unset_default = "UPDATE transport SET is_default = 0 WHERE user_id = $user_id";
        mysqli_query($conn, $sql_unset_default);
    }

    if ($address_id > 0) {
        // UPDATE
        $sql = "UPDATE transport SET 
            fullname = '$fullname', 
            mobile = '$mobile', 
            province = '$province', 
            district = '$district', 
            ward = '$ward', 
            address_detail = '$address_detail', 
            is_default = $is_default, 
            is_pickup = $is_pickup, 
            is_return = $is_return, 
            updated_at = $current_time
            WHERE id = $address_id AND user_id = $user_id";
    } else {
        // INSERT
        $sql = "INSERT INTO transport 
            (user_id, username, fullname, mobile, province, district, ward, 
             address_detail, is_default, is_pickup, is_return, created_at, updated_at)
            VALUES (
                $user_id, 
                '$username', 
                '$fullname', 
                '$mobile', 
                '$province', 
                '$district', 
                '$ward', 
                '$address_detail', 
                $is_default, 
                $is_pickup, 
                $is_return, 
                $current_time, 
                $current_time
            )";
    }

    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            'ok' => 1,
            'thongbao' => $address_id > 0 ? 'Cập nhật địa chỉ thành công' : 'Thêm địa chỉ mới thành công'
        ]);
    } else {
        echo json_encode([
            'ok' => 0,
            'thongbao' => 'Có lỗi xảy ra: ' . mysqli_error($conn)
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'ok' => 0,
        'thongbao' => 'Có lỗi xảy ra: ' . $e->getMessage()
    ]);
}
?>
