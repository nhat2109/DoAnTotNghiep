<?php
$id = intval($_POST['id']);
$user_id = $tach_token['user_id'];

$sql = "SELECT t.*, p.tieu_de as province_name, d.tieu_de as district_name, w.tieu_de as ward_name 
        FROM transport t
        LEFT JOIN tinh_moi p ON t.province = p.id 
        LEFT JOIN huyen_moi d ON t.district = d.id
        LEFT JOIN xa_moi w ON t.ward = w.id
        WHERE t.id = '$id' AND t.user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode(['status' => 'success', 'data' => $row]);
} else {
    echo json_encode(['status' => 'error']);
}
?> 