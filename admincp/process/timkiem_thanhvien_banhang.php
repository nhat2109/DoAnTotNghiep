<?php
header('Content-Type: application/json; charset=utf-8');
try {
    // Lấy tham số tìm kiếm
    $status = isset($_POST['status']) ? addslashes(strip_tags($_POST['status'])) : '';
    $key = isset($_POST['key']) ? addslashes(strip_tags($_POST['key'])) : '';
    
    // Tạo WHERE clause
    $where = [];
    if ($status) {
        $where[] = "u.status_cre = '$status'";
    }
    if ($key) {
        $where[] = "(k.ho_ten LIKE '%$key%' OR k.dien_thoai LIKE '%$key%')";
    }
    $where_clause = $where ? "WHERE " . implode(" AND ", $where) : "";

    // Query chính
    $query = mysqli_query($conn, "SELECT k.*, u.status_cre, k.date_post,
        k.date_modified, u.user_id as user_socdo_id,
        u.user_money as tk_chinh,
        (SELECT name FROM user_info WHERE user_id = k.nhan_su) as nguoi_lienhe_name,
        (SELECT name FROM user_info WHERE user_id = u.aff) as nguoi_quanly_name,
        (SELECT SUM(sotien) FROM lichsu_chitieu WHERE user_id = k.user_socdo) as total_sotien
        FROM khach_hang k
        LEFT JOIN user_info u ON u.user_id = k.user_socdo 
        $where_clause 
        ORDER BY k.id DESC");

    if (!$query) {
        throw new Exception(mysqli_error($conn));
    }

    // Tạo header bảng
    $table_header = "<tr>
        <th class='hide_mobile'>STT</th>
        <th>Người quản lí</th>
        <th>Tên khách hàng</th>
        <th class='hide_mobile'>ĐT</th>
        <th class='hide_mobile'>Ngày thêm</th>
        <th class='hide_mobile'>Lần chăm sóc gần nhất</th>
        <th class='hide_mobile'>Người chăm sóc</th>
        <th class='hide_mobile'>TK chính</th>
        <th class='hide_mobile'>Doanh số</th>
        <th class='hide_mobile'>Tình trạng</th>
    </tr>";

    $list = '';
    $stt = 1;
    while ($row = mysqli_fetch_assoc($query)) {
        $status = $row['status_cre'];
        $date_post = !empty($row['date_post']) ? date('d/m/Y', $row['date_post']) : '';
        $date_contact = !empty($row['date_modified']) ? date('d/m/Y', $row['date_modified']) : 'Chưa chăm sóc';

        $list .= "<tr>
            <td class='text-center'>{$stt}</td>
            <td class='text-center'>" . ($row['nguoi_quanly_name'] ?: 'Chưa có quản lý') . "</td>
            <td class='text-center'>" . htmlspecialchars($row['ho_ten']) . "</td>
            <td class='text-center'>" . htmlspecialchars($row['dien_thoai']) . "</td>
            <td class='text-center'>{$date_post}</td>
            <td class='text-center'>{$date_contact}</td>
            <td class='text-center'>" . htmlspecialchars($row['nguoi_lienhe_name']) . "</td>
            <td class='text-center'>" . number_format($row['tk_chinh'], 0, ',', '.') . " đ</td>
            <td class='text-center'>" . ($row['total_sotien'] ? number_format($row['total_sotien'], 0, ',', '.') . " đ" : "0 đ") . "</td>
            <td class='text-center'>
                <select class='status-select status-{$status}' data-user-id='{$row['user_socdo_id']}'>
                    <option value='3' " . ($status == '3' ? 'selected' : '') . ">Cool</option>
                    <option value='2' " . ($status == '2' ? 'selected' : '') . ">Warm</option>
                    <option value='1' " . ($status == '1' ? 'selected' : '') . ">Hot</option>
                </select>
            </td>
        </tr>";
        $stt--;
    }

    $final_list = $table_header . $list;

    echo json_encode([
        'ok' => true,
        'list' => $final_list
    ]);

} catch (Exception $e) {
    echo json_encode([
        'ok' => false,
        'error' => $e->getMessage()
    ]);
}
exit;
?>