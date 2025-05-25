<?php
$thaythe['title'] = 'Lịch sử nạp tiền';
$thaythe['title_action'] = 'Lịch sử nạp tiền';
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;

$where = "n.user_id='$user_id' AND n.date_post > 0";

if (isset($_POST['status']) && $_POST['status'] !== 'all') {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $where .= " AND n.status = '$status'";
}

if (!empty($_POST['from_date']) && !empty($_POST['to_date'])) {
    $from_date = mysqli_real_escape_string($conn, $_POST['from_date']);
    $to_date = mysqli_real_escape_string($conn, $_POST['to_date']);
    $where .= " AND DATE(FROM_UNIXTIME(n.date_post)) BETWEEN '$from_date' AND '$to_date'";
}

$thongke = mysqli_query($conn, "SELECT COUNT(*) AS total FROM naptien n WHERE $where");
if (!$thongke) {
    exit;
}

$r_tk = mysqli_fetch_assoc($thongke);
$total_page = ceil($r_tk['total'] / $limit);

$query = "SELECT n.id, n.date_post, n.sotien, n.status, l.noidung
          FROM naptien n
          LEFT JOIN lichsu_chitieu l 
          ON (n.user_id = l.user_id AND CAST(n.date_post AS SIGNED) = CAST(l.date_post AS SIGNED))
          WHERE $where
          ORDER BY n.id DESC  
          LIMIT $start, $limit";

$result = mysqli_query($conn, $query);
if (!$result) {
    exit;
}

$list_naptien = "";
$data = []; // Initialize data array for chart
$stt = mysqli_num_rows($result);

while ($row = mysqli_fetch_assoc($result)) {
    // Format data for table display
    $date = date('d/m/Y H:i', $row['date_post']);
    $sotien = number_format($row['sotien'], 0, ',', '.') . " VNĐ";
    $noidung = !empty($row['noidung']) ? htmlspecialchars($row['noidung']) : 'Không có';

    // Add data for chart
    $data[] = [
        'date' => date('d/m/Y', $row['date_post']), // Format date for chart
        'sotien' => (int)$row['sotien'] // Convert to integer for chart
    ];

    switch ($row['status']) {
        case '0':
            $statusClass = 'status-pending';
            $statusText = 'Chờ xử lý';
            break;
        case '1':
            $statusClass = 'status-approved'; 
            $statusText = 'Đã duyệt';
            break;
        case '2':
            $statusClass = 'status-cancelled';
            $statusText = 'Đã hủy';
            break;
        default:
            $statusClass = 'status-unknown';
            $statusText = 'Không xác định';
    }

    $list_naptien .= "
    <tr>
        <td style='text-align: center;'>{$stt}</td>
        <td style='text-align: left;'>{$date}</td>
        <td style='text-align: right;'>{$sotien}</td>
        <td style='text-align: left;'>{$noidung}</td>
        <td style='text-align: center;'>
            <span class='{$statusClass}'>{$statusText}</span>
        </td>
    </tr>";

    $stt--;
}

$phantrang = $class_index->phantrang($page, $total_page, '/ncc/list-naptien');
// Debug data
error_log('Chart data: ' . print_r($data, true));

$bien = array(
    'list_naptien' => $list_naptien,
    'phantrang' => $phantrang,
    'list_thongke' => $list_thongke,
    'chart_data' => json_encode($data, JSON_UNESCAPED_UNICODE)
);

$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_naptien', $bien);
?>