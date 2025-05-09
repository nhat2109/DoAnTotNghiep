<?php
$id = (int)$_REQUEST['id'];
$user_id = (int)$user_info['user_id'];

// Lấy thông tin sản phẩm từ sanpham_shop
$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id='$id' AND shop='$user_id'");
if (mysqli_num_rows($thongtin) == 0) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Sản phẩm không tồn tại hoặc bạn không có quyền!']);
    exit();
}

$r_sp = mysqli_fetch_assoc($thongtin);

// Kiểm tra trạng thái của sản phẩm trong sanpham_shop
if ($r_sp['status'] != 2) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Sản phẩm không ở trạng thái chờ đăng (status phải là 2)!']);
    exit();
}

// Cập nhật status trong sanpham_shop từ 2 thành 0
$query_update = "UPDATE sanpham_shop SET status=0 WHERE id='$id'";
if (!mysqli_query($conn, $query_update)) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi khi cập nhật status: ' . mysqli_error($conn)]);
    exit();
}

echo json_encode(['ok' => 1, 'thongbao' => 'Đã gửi sản phẩm lên Sóc Đỏ để chờ duyệt!']);
exit();
    ?>




