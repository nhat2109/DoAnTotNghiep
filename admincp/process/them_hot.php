<?php
$user_id = intval($_POST['user_id']);

// Kiểm tra xem user_id có tồn tại không
$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id = '$user_id'");
if (mysqli_num_rows($thongtin) > 0) {
    // Cập nhật trạng thái status_cre lên 1
    mysqli_query($conn, "UPDATE user_info SET status_cre = 1 WHERE user_id = '$user_id'");
    $info = array(
        'ok' => 1,
        'thongbao' => 'Đã thêm HOT thành công'
    );
} else {
    $info = array(
        'ok' => 0,
        'thongbao' => 'User không tồn tại'
    );
}
echo json_encode($info);
?>