<?php
// Pagination settings
$limit = 100;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

// Page titles
$thaythe['title'] = 'Danh sách bán hàng';
$thaythe['title_action'] = 'Danh sách bán hàng';

// Get and sanitize filters
$status = isset($_GET['status']) ? addslashes(strip_tags($_GET['status'])) : '';
$key = isset($_GET['key']) ? addslashes(strip_tags($_GET['key'])) : '';

// Build WHERE clause
$where = [];
if ($status) {
    $where[] = "u.status_cre = '$status'";
}
if ($key) {
    $where[] = "(k.ho_ten LIKE '%$key%' OR k.dien_thoai LIKE '%$key%')";
}
$where_clause = $where ? "WHERE " . implode(" AND ", $where) : "";

// Get total records for pagination
$count_query = mysqli_query($conn, "SELECT COUNT(*) as total 
    FROM khach_hang k 
    INNER JOIN user_info u ON u.user_id = k.user_socdo 
    $where_clause");

if (!$count_query) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

$total_count = mysqli_fetch_assoc($count_query)['total'];
$total_pages = ceil($total_count / $limit);

// Main query to get customer data
$query = mysqli_query($conn, "
    SELECT 
        k.*,
        u.name as nguoi_them_name,
        u.user_id as user_socdo_id,
        u.user_money as tk_chinh,
        u.status_cre,
        k.date_post,
        k.date_modified,
        u.aff,
        (SELECT name FROM user_info WHERE user_id = k.nhan_su) as nguoi_lienhe_name,
        (SELECT name FROM user_info WHERE user_id = u.aff) as nguoi_quanly_name
        /* Tạm thời bỏ phần tính tổng số tiền
        COALESCE(SUM(d.so_tien), 0) as total_sotien
        */
    FROM khach_hang k
    INNER JOIN user_info u ON u.user_id = k.user_socdo
    /* Tạm thời bỏ JOIN với bảng donhang
    LEFT JOIN donhang d ON k.id = d.khachhang_id
    */
    $where_clause
    GROUP BY k.id
    ORDER BY k.id DESC
    LIMIT $start, $limit
");

if (!$query) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

// Get statistics for chart
$stats_query = mysqli_query($conn, "
    SELECT 
        COALESCE(u.status_cre, '3') as status_cre,
        COUNT(*) as count
    FROM khach_hang k
    INNER JOIN user_info u ON u.user_id = k.user_socdo
    $where_clause
    GROUP BY u.status_cre
");

if (!$stats_query) {
    die("Lỗi truy vấn thống kê: " . mysqli_error($conn));
}

// Initialize statistics array
$stats = [
    '1' => 0, // Hot (Đỏ)
    '2' => 0, // Warm (Vàng)
    '3' => 0  // Cool (Xanh)
];

// Update statistics from query results
while ($row = mysqli_fetch_assoc($stats_query)) {
    if (isset($row['status_cre']) && isset($stats[$row['status_cre']])) {
        $stats[$row['status_cre']] = (int)$row['count'];
    }
}

$data_json = json_encode(array_values($stats));

// Generate HTML list
$list = '';
$stt = $total_count - ($page - 1) * $limit;

while ($row = mysqli_fetch_assoc($query)) {
    $status = $row['status_cre'] ?? '3';
    $date_post = !empty($row['date_post']) ? date('d/m/Y', $row['date_post']) : '';
    $date_contact = !empty($row['date_modified']) ? date('d/m/Y', $row['date_modified']) : 'Chưa chăm sóc';

    $list .= "<tr>
    <td style='vertical-align: middle; text-align: center;'>{$stt}</td>
    <td style='vertical-align: middle; text-align: center;'>" . ($row['nguoi_quanly_name'] ?: 'Chưa có quản lý') . "</td>
    <td style='vertical-align: middle; text-align: center;'>" . htmlspecialchars($row['ho_ten']) . "</td>
    <td style='vertical-align: middle; text-align: center;'>" . htmlspecialchars($row['dien_thoai']) . "</td>
    <td style='vertical-align: middle; text-align: center;'>{$date_post}</td>
    <td style='vertical-align: middle; text-align: center;'>{$date_contact}</td>
    <td style='vertical-align: middle; text-align: center;'>" . htmlspecialchars($row['nguoi_lienhe_name']) . "</td>
    <td style='vertical-align: middle; text-align: center;'>" . number_format($row['tk_chinh'], 0, ',', '.') . " đ</td>
    <td style='vertical-align: middle; text-align: center;'>0 đ</td>
    <td style='vertical-align: middle; text-align: center;'>
        <select class='status-select status-{$status}' data-user-id='{$row['user_socdo_id']}'>
            <option value='1'" . ($status == '1' ? ' selected' : '') . ">Hot</option>
            <option value='2'" . ($status == '2' ? ' selected' : '') . ">Warm</option>
            <option value='3'" . ($status == '3' ? ' selected' : '') . ">Cool</option>
        </select>
    </td>
</tr>";
    $stt--;
}

// Generate pagination
$pagination = $class_index->phantrang($page, $total_pages, '/admincp/list-thanhvien-banhang');

// Set template variables
$thaythe['box_right'] = $skin->skin_replace('skin_cpanel/box_action/list_thanhvien_banhang', [
    'list_thanhvien_banhang' => $list,
    'phantrang' => $pagination,
    'data_json' => $data_json
]);
?>