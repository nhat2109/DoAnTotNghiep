<?php
include '../includes/tlca_world.php';
include_once "../class.phpmailer.php";
$check = $tlca_do->load('class_check');
$action = addslashes($_REQUEST['action']);
$class_index = $tlca_do->load('class_cpanel');
$class_viettel = $tlca_do->load('class_viettel');
$class_ninja_van = $tlca_do->load('class_ninja_van');
$skin = $tlca_do->load('class_skin_cpanel');
$class_e_member = $tlca_do->load('class_e_member');
$user_info=$class_e_member->user_info($conn,$_COOKIE['emin_id']);
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
$hientai=time();

while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
$file_action='process/'.$action.'.php';
if(file_exists($file_action)){
    include($file_action);
} else if ($action == 'filter_date') {
    header('Content-Type: application/json');
    
    try {
        $from_date = isset($_POST['from_date']) ? strtotime($_POST['from_date']) : '';
        $to_date = isset($_POST['to_date']) ? strtotime($_POST['to_date']) : '';
        $status = isset($_POST['status']) ? addslashes($_POST['status']) : '';

        // Build WHERE clause
        $where = [];
        if ($from_date && $to_date) {
            $where[] = "k.date_post BETWEEN '$from_date' AND '$to_date'";
        }
        if ($status) {
            $where[] = "u.status_cre = '$status'";
        }

        $where_clause = $where ? "WHERE " . implode(' AND ', $where) : "";

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
            FROM khach_hang k
            LEFT JOIN user_info u ON u.user_id = k.user_socdo
            $where_clause
            ORDER BY k.id DESC
        ");

        if (!$query) {
            throw new Exception(mysqli_error($conn));
        }

        $list = '';
        $stt = 1;

        while ($row = mysqli_fetch_assoc($query)) {
            $status = $row['status_cre'] ?? '3';
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
                <td class='text-center'>0 đ</td>
                <td class='text-center'>
                    <select class='status-select status-{$status}' data-user-id='{$row['user_socdo_id']}'>
                        <option value='1'" . ($status == '1' ? ' selected' : '') . ">Hot</option>
                        <option value='2'" . ($status == '2' ? ' selected' : '') . ">Warm</option>
                        <option value='3'" . ($status == '3' ? ' selected' : '') . ">Cool</option>
                    </select>
                </td>
            </tr>";
            $stt++;
        }

        echo json_encode([
            'ok' => true,
            'list' => $list ?: '<tr><td colspan="10" class="text-center">Không tìm thấy dữ liệu</td></tr>'
        ]);

    } catch (Exception $e) {
        echo json_encode([
            'ok' => false,
            'error' => $e->getMessage()
        ]);
    }
    exit;
} else {
    echo "Không có hành động nào được xử lý";
}
?>