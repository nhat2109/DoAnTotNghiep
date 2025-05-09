<?php
header('Content-Type: application/json; charset=utf-8');

try {
    $customer_id = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : 0;
    $care_content = isset($_POST['care_content']) ? addslashes(strip_tags($_POST['care_content'])) : '';

    if (!$customer_id || empty($care_content)) {
        throw new Exception('Vui lòng nhập đầy đủ thông tin');
    }
    $date_contact = !empty($row['date_contact']) ?
        '<span class="care-date" data-id="' . $row['id'] . '">' . date('d/m/Y', $row['date_contact']) . '</span>' :
        '<span class="care-date" data-id="' . $row['id'] . '">Chưa liên hệ</span>';
    // Cập nhật thông tin chăm sóc
    $current_time = time();
    $update = mysqli_query($conn, "UPDATE khach_hang SET 
            noi_dung_cham_soc = '$care_content',
            date_contact = '$current_time',
            nhan_su = '{$user_info['id']}'
            WHERE id = $customer_id");

    if ($update) {
        echo json_encode([
            'ok' => true,
            'message' => 'Cập nhật thông tin chăm sóc thành công'
        ]);
    } else {
        throw new Exception('Lỗi cập nhật dữ liệu');
    }
} catch (Exception $e) {
    echo json_encode([
        'ok' => false,
        'error' => $e->getMessage()
    ]);
}
?>