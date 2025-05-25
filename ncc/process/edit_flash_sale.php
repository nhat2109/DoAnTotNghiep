<?php
session_start();


$tieu_de = mysqli_real_escape_string($conn, strip_tags($_REQUEST['tieu_de']));
$date_start = mysqli_real_escape_string($conn, strip_tags($_REQUEST['date_start']));
$date_end = mysqli_real_escape_string($conn, strip_tags($_REQUEST['date_end']));
$sub_product = $_REQUEST['sub_product'];
$sub_id = mysqli_real_escape_string($conn, strip_tags($_REQUEST['sub_id']));
$list_product_sub = $_REQUEST['list_product_sub'];
$quantities = json_decode($_REQUEST['quantities'], true);
$id = intval($_REQUEST['id']);
$shop = $user_id;

// Kiểm tra và giải mã JSON
$sub_product_data = json_decode($sub_product, true);
if (json_last_error() !== JSON_ERROR_NONE || $sub_product_data === null) {
    $info = array(
        'ok' => 0,
        'thongbao' => 'Dữ liệu sub_product không hợp lệ: ' . json_last_error_msg()
    );
    echo json_encode($info);
    exit;
}

// Thêm số lượng (so_luong) vào sub_product_data từ quantities
foreach ($quantities as $sp_id => $variant_quantities) {
    foreach ($variant_quantities as $index => $variant) {
        $variant_id = $variant['variant_id'];
        $quantity = $variant['quantity'];

        // Tìm biến thể tương ứng trong sub_product_data và cập nhật so_luong
        foreach ($sub_product_data[$sp_id] as &$sub_variant) {
            if ($sub_variant['variant_id'] == $variant_id) {
                $sub_variant['so_luong'] = $quantity;
                break;
            }
        }
    }
}

// Chuyển sub_product_data trở lại JSON để lưu vào database
$sub_product_updated = json_encode($sub_product_data);

if ($tieu_de == '') {
    $ok = 0;
    $thongbao = 'Vui lòng nhập tên chương trình';
} elseif ($date_start == '') {
    $ok = 0;
    $thongbao = 'Vui lòng nhập thời gian bắt đầu';
} elseif ($date_end == '') {
    $ok = 0;
    $thongbao = 'Vui lòng chọn thời gian kết thúc';
} elseif (empty($sub_id)) {
    $ok = 0;
    $thongbao = 'Vui lòng chọn sản phẩm';
} else {
    $ok = 1;
    $thongbao = 'Sửa flash sale thành công';

    // Chuyển đổi thời gian
    $tach_start = explode(' ', $date_start);
    $tach_time_start = explode(':', $tach_start[0]);
    $tach_date_start = explode('/', $tach_start[1]);
    $start = mktime($tach_time_start[0], $tach_time_start[1], 0, $tach_date_start[1], $tach_date_start[0], $tach_date_start[2]);

    $tach_end = explode(' ', $date_end);
    $tach_time_end = explode(':', $tach_end[0]);
    $tach_date_end = explode('/', $tach_end[1]);
    $end = mktime($tach_time_end[0], $tach_time_end[1], 0, $tach_date_end[1], $tach_date_end[0], $tach_date_end[2]);

    // Lấy danh sách ID sản phẩm từ sub_product
    $main_product_ids = implode(',', array_keys($sub_product_data));

    // Thoát các chuỗi JSON để lưu vào database
    $sub_product_escaped = mysqli_real_escape_string($conn, $sub_product_updated);
    $list_product_sub_escaped = mysqli_real_escape_string($conn, $list_product_sub);

    // Cập nhật bảng deal
    $query = "UPDATE deal SET 
              tieu_de = '$tieu_de', 
              main_product = '$main_product_ids', 
              sub_product = '$sub_product_escaped', 
              sub_id = '$sub_id', 
              date_start = '$start', 
              date_end = '$end', 
              loai = 'flash_sale' 
              WHERE id = '$id' AND shop = '$shop'";
    if (mysqli_query($conn, $query)) {
        $ok = 1;
        $thongbao = 'Sửa flash sale thành công';
        
        // Xóa session sau khi lưu thành công
        unset($_SESSION['selected_products_edit']);
    } else {
        $ok = 0;
        $thongbao = 'Lỗi khi cập nhật dữ liệu: ' . mysqli_error($conn);
    }
}

$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
?>