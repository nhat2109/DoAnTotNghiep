<?php
$id = intval($_REQUEST['id']);
$noi_dung = addslashes(strip_tags($_REQUEST['noi_dung']));
$sql = "SELECT lydo_tuchoi FROM giao_viec WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$baoCaoHienTai = !empty($row['lydo_tuchoi']) ? json_decode($row['lydo_tuchoi'], true) : [];
$baoCaoHienTai[] = [
    "tuchoi" => $noi_dung
];
$baoCaoJson = json_encode($baoCaoHienTai, JSON_UNESCAPED_UNICODE);
$sql = "UPDATE giao_viec SET xac_nhan='1', lydo_tuchoi='$baoCaoJson', phantram = '90',status='1' WHERE id='$id'";
mysqli_query($conn, $sql);
$info = array(
    'ok' => 1,
    'thongbao' => 'Đã từ chối',
);
echo json_encode($info);
