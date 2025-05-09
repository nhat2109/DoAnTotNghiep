<?php
$noidung = addslashes(strip_tags($_REQUEST['noidung']));
$tgian_xingiahan = addslashes(strip_tags($_REQUEST['tgian']));
$id = intval($_REQUEST['id']);
$tgian = strtotime($tgian_xingiahan);

$sql = "SELECT noidung_xacnhan_giahan FROM giao_viec WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$baoCaoHienTai = !empty($row['noidung_xacnhan_giahan']) ? json_decode($row['noidung_xacnhan_giahan'], true) : [];

if (!empty($baoCaoHienTai)) {
    $lastIndex = count($baoCaoHienTai) - 1;
    $baoCaoHienTai[$lastIndex]['acp'] = "Đã xác nhận";
    $baoCaoHienTai[$lastIndex]['noidung_xacnhan'] = $noidung; 
    $baoCaoHienTai[$lastIndex]['tgian_xacnhan'] = $tgian;
}
$baoCaoJson = json_encode($baoCaoHienTai, JSON_UNESCAPED_UNICODE);


mysqli_query($conn, "UPDATE giao_viec SET date_line='$tgian',noidung_xacnhan_giahan='$baoCaoJson',xac_nhan_giahan='1' WHERE id='$id'");
$info = [
    'ok'=>1,
    'thongbao'=>'Đã xác nhận gia hạn'
];
echo json_encode($info);