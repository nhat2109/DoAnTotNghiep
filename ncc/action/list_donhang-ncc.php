<?php
$thaythe['title'] = 'Danh sách đơn hàng shop';
$thaythe['title_action'] = 'Danh sách đơn hàng shop';
$limit = 50;

// Lấy tất cả đơn hàng từ bảng donhang
$thongtin = mysqli_query($conn, "SELECT id, sanpham FROM donhang ORDER BY id DESC");

$count = 0; // Đếm số đơn hàng hợp lệ
$valid_order_ids = []; // Lưu ID của các đơn hàng hợp lệ

while ($r_tt = mysqli_fetch_assoc($thongtin)) {
    $tach_sanpham = json_decode($r_tt['sanpham'], true);
    $order_id = $r_tt['id'];
    $has_valid_product = false;

    foreach ($tach_sanpham as $variant_id => $value) {
        $sp_id = intval($variant_id); // Đảm bảo variant_id là số nguyên

        // Truy vấn bảng phanloai_sanpham để lấy user_id của sản phẩm
        $query = "SELECT user_id FROM phanloai_sanpham WHERE sp_id = '$sp_id'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $sp_user_id = $row['user_id'];

            // Nếu user_id của sản phẩm trùng với user_id hiện tại
            if ($sp_user_id == $user_id) {
                $has_valid_product = true;
                break; // Thoát vòng lặp nếu tìm thấy ít nhất 1 sản phẩm hợp lệ
            }
        }
    }

    // Nếu đơn hàng có ít nhất 1 sản phẩm hợp lệ, thêm vào danh sách
    if ($has_valid_product) {
        $valid_order_ids[] = $order_id;
        $count++;
    }
}

// Tính tổng số trang dựa trên số đơn hàng hợp lệ
$total_page = ceil($count / $limit);

// Truyền danh sách đơn hàng hợp lệ vào hàm list_donhang_ncc
$bien = array(
    'list_donhang_ncc' => $class_index->list_donhang_ncc($conn, $user_id, $search, $status, $date_from, $date_to, $page, $limit, $valid_order_ids),
    'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-donhang-ncc'),
);
$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_donhang_ncc', $bien);
?>