<?php
// Lấy dữ liệu từ POST
$time_begin = $_POST['time_begin'] ?? '';
$time_end = $_POST['time_end'] ?? '';
$filter_type = $_POST['filter_type'] ?? 'month'; // Mặc định là tháng
$page_banchay = isset($_POST['page_banchay']) ? (int)$_POST['page_banchay'] : 1;
$page_banchay = max(1, $page_banchay);
$limit = 10; // Số sản phẩm mỗi trang

// Xác định thời gian dựa trên filter_type nếu không có time_begin/time_end
if (empty($time_begin) || empty($time_end)) {
    $end_time = strtotime('today 23:59:59'); // 25/05/2025 23:59:59
    switch ($filter_type) {
        case 'week':
            $begin_time = strtotime('monday this week 00:00:00'); // Thứ 2 của tuần hiện tại: 19/05/2025
            break;
        case 'month':
            $begin_time = strtotime('first day of this month 00:00:00'); // 01/05/2025
            break;
        case 'quarter':
            // Xác định quý hiện tại (tháng 5 thuộc quý 2: tháng 4-6)
            $current_month = date('n', $end_time); // 5 (tháng 5)
            $quarter = ceil($current_month / 3); // Quý 2 (tháng 4-6)
            $start_month_of_quarter = ($quarter - 1) * 3 + 1; // Tháng bắt đầu của quý: 4
            $begin_time = strtotime("first day of $start_month_of_quarter 00:00:00", strtotime('first day of January this year')); // 01/04/2025
            break;
        case 'year':
            $begin_time = strtotime('first day of January this year 00:00:00'); // 01/01/2025
            break;
        default:
            $begin_time = $end_time - 31 * 24 * 3600; // Mặc định 31 ngày: 24/04/2025
    }
    $time_begin = date('d/m/Y', $begin_time);
    $time_end = date('d/m/Y', $end_time);
} else {
    $begin_time = strtotime(str_replace('/', '-', $time_begin) . ' 00:00:00');
    $end_time = strtotime(str_replace('/', '-', $time_end) . ' 23:59:59');
    if ($begin_time === false || $end_time === false) {
        echo json_encode(['ok' => 0, 'thongbao' => 'Định dạng thời gian không hợp lệ']);
        exit;
    }
}

// Tính tổng số sản phẩm bán chạy từ sanpham_shop
$sql_count_banchay = "SELECT COUNT(*) as total FROM sanpham_shop 
                     WHERE shop='$user_id' AND date_post BETWEEN '$begin_time' AND '$end_time'";
$rs_count_banchay = mysqli_query($conn, $sql_count_banchay);
if (!$rs_count_banchay) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi truy vấn cơ sở dữ liệu']);
    exit;
}
$total_banchay = mysqli_fetch_assoc($rs_count_banchay)['total'];
$total_page_banchay = ceil($total_banchay / $limit);

// Tính offset cho phân trang
$offset_banchay = ($page_banchay - 1) * $limit;

// Lấy danh sách sản phẩm bán chạy từ sanpham_shop
$sql_banchay = "SELECT id, tieu_de, ban, gia_moi, date_post FROM sanpham_shop 
                WHERE shop='$user_id' AND date_post BETWEEN '$begin_time' AND '$end_time' 
                ORDER BY ban DESC, id DESC LIMIT $limit OFFSET $offset_banchay";
$rs_banchay = mysqli_query($conn, $sql_banchay);
if (!$rs_banchay) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi truy vấn cơ sở dữ liệu']);
    exit;
}
$list_banchay = [];
while ($row = mysqli_fetch_assoc($rs_banchay)) {
    $row['gia_moi'] = number_format($row['gia_moi'], 0, ',', '.') . ' đ';
    $row['date_post'] = date('d/m/Y', $row['date_post']);
    $list_banchay[] = $row;
}

// Tính toán dữ liệu tổng quan lượt mua từ donhang_shop (status = 5)
$group_by_format = '%Y-%m-%d';
if ($filter_type === 'week') {
    $group_by_format = '%Y-%U'; // Nhóm theo tuần
} elseif ($filter_type === 'month') {
    $group_by_format = '%Y-%m'; // Nhóm theo tháng
} elseif ($filter_type === 'quarter') {
    $group_by_format = '%Y-%m'; // Nhóm theo tháng trong quý
} elseif ($filter_type === 'year') {
    $group_by_format = '%Y-%m'; // Nhóm theo tháng trong năm
}

$sql_summary = "SELECT DATE_FORMAT(FROM_UNIXTIME(date_post), '$group_by_format') as date, COUNT(*) as total_sold 
                FROM donhang_shop 
                WHERE shop='$user_id' AND status = 5 AND date_post BETWEEN '$begin_time' AND '$end_time' 
                GROUP BY DATE_FORMAT(FROM_UNIXTIME(date_post), '$group_by_format')";
$rs_summary = mysqli_query($conn, $sql_summary);
if (!$rs_summary) {
    echo json_encode(['ok' => 0, 'thongbao' => 'Lỗi truy vấn cơ sở dữ liệu']);
    exit;
}
$summary_data = [];
while ($row = mysqli_fetch_assoc($rs_summary)) {
    $summary_data[] = [
        'date' => $row['date'],
        'total_sold' => (int)$row['total_sold']
    ];
}

// Chuẩn bị dữ liệu cho biểu đồ và danh sách
$labels_banchay = array_map(fn($sp) => $sp['tieu_de'], $list_banchay);
$data_banchay = array_map(fn($sp) => (int)$sp['ban'], $list_banchay);

$response = [
    'ok' => 1,
    'thongbao' => 'Dữ liệu đã được cập nhật',
    'list_banchay' => $list_banchay,
    'labels_banchay' => $labels_banchay,
    'data_banchay' => $data_banchay,
    'summary_labels' => array_column($summary_data, 'date'),
    'summary_data' => array_column($summary_data, 'total_sold'),
    'phantrang_banchay' => $class_index->phantrang_timkiem($page_banchay, $total_page_banchay, '/ncc/thongke-chung-hieu-suat?filter_type=' . $filter_type, 'page_banchay'),
    'time_begin' => $time_begin,
    'time_end' => $time_end,
    'filter_type' => $filter_type
];

echo json_encode($response);
exit;
?>