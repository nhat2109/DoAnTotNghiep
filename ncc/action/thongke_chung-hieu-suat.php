<?php
$thaythe['title'] = 'Thống kê chung top sản phẩm bán chạy';
$thaythe['title_action'] = 'Thống kê chung top sản phẩm bán chạy';

// Lấy tham số từ URL
$page_banchay = isset($_GET['page_banchay']) ? (int)$_GET['page_banchay'] : 1;
$page_banchay = max(1, $page_banchay);
$limit = 10; // Số sản phẩm mỗi trang
$filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : 'week'; // Mặc định là tuần


// Xử lý logic cho select options
$week_selected = $filter_type === 'week' ? 'selected' : '';
$month_selected = $filter_type === 'month' ? 'selected' : '';
$quarter_selected = $filter_type === 'quarter' ? 'selected' : '';
$year_selected = $filter_type === 'year' ? 'selected' : '';
$custom_selected = $filter_type === 'custom' ? 'selected' : '';

// Xử lý logic hiển thị/ẩn thời gian tùy chỉnh
$custom_style = $filter_type !== 'custom' ? 'style="display: none;"' : '';

// Xác định thời gian dựa trên filter_type
$end_time = strtotime('today 23:59:59'); // 25/05/2025 23:59:59
$end = date('d/m/Y', $end_time);

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
$begin = date('d/m/Y', $begin_time);

// Tính tổng số sản phẩm bán chạy từ sanpham_shop
$sql_count_banchay = "SELECT COUNT(*) as total FROM sanpham_shop 
                     WHERE shop='$user_id' AND date_post BETWEEN '$begin_time' AND '$end_time'";
$rs_count_banchay = mysqli_query($conn, $sql_count_banchay);
$total_banchay = mysqli_fetch_assoc($rs_count_banchay)['total'];
$total_page_banchay = ceil($total_banchay / $limit);

// Tính offset cho phân trang
$offset_banchay = ($page_banchay - 1) * $limit;

// Lấy danh sách sản phẩm bán chạy với phân trang từ sanpham_shop
$sql_banchay = "SELECT id, tieu_de, ban, gia_moi, date_post FROM sanpham_shop 
                WHERE shop='$user_id' AND date_post BETWEEN '$begin_time' AND '$end_time' 
                ORDER BY ban DESC, id DESC LIMIT $limit OFFSET $offset_banchay";
$rs_banchay = mysqli_query($conn, $sql_banchay);
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
$summary_data = [];
while ($row = mysqli_fetch_assoc($rs_summary)) {
    $summary_data[] = [
        'date' => $row['date'],
        'total_sold' => (int)$row['total_sold']
    ];
}

function hien_bang_sanpham($list) {
    $html = '';
    foreach ($list as $sp) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($sp['tieu_de']) . '</td>';
        $html .= '<td style="text-align:center;">' . (int)$sp['ban'] . '</td>';
        $html .= '<td style="text-align:center;" class="hide_mobile">' . $sp['gia_moi'] . '</td>';
        $html .= '<td style="text-align:center;" class="hide_mobile">' . $sp['date_post'] . '</td>';
        $html .= '</tr>';
    }
    return $html;
}

$labels_banchay = array_map(fn($sp) => $sp['tieu_de'], $list_banchay);
$data_banchay = array_map(fn($sp) => (int)$sp['ban'], $list_banchay);

$bien = [
    'footer' => $skin->skin_normal('skin_admin/footer'),
    'end' => $end,
    'begin' => $begin,
    'filter_type' => $filter_type,
    'week_selected' => $week_selected,
    'month_selected' => $month_selected,
    'quarter_selected' => $quarter_selected,
    'year_selected' => $year_selected,
    'custom_selected' => $custom_selected,
    'custom_style' => $custom_style,
    'list_banchay' => hien_bang_sanpham($list_banchay),
    'labels_banchay' => json_encode($labels_banchay),
    'data_banchay' => json_encode($data_banchay),
    'summary_labels' => json_encode(array_column($summary_data, 'date')),
    'summary_data' => json_encode(array_column($summary_data, 'total_sold')),
    'phantrang_banchay' => $class_index->phantrang_timkiem($page_banchay, $total_page_banchay, '/ncc/thongke-chung-hieu-suat?filter_type=' . $filter_type, 'page_banchay'),
];

$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/thongke_chung_hieu_suat', $bien);
?>