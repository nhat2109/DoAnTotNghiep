<?php

$id= intval($_REQUEST['id']);
$noi_dung = addslashes(strip_tags($_REQUEST['noidung']));
$thongtingiaoviec = mysqli_query($conn,"SELECT * FROM giao_viec WHERE id='$id'");
$r_thongtingiaoviec = mysqli_fetch_assoc($thongtingiaoviec);
$baoCaoHienTai = !empty($r_thongtingiaoviec['lydo_tuchoi']) ? json_decode($r_thongtingiaoviec['lydo_tuchoi'], true) : [];
$baoCaoHienTai[] = [
    "lydo_tuchoi" => $noi_dung,
];
$baoCaoJson = json_encode($baoCaoHienTai, JSON_UNESCAPED_UNICODE);
    $sql = "UPDATE giao_viec SET status='4', lydo_tuchoi='$baoCaoJson' WHERE id='$id'";
    mysqli_query($conn, $sql);
    $thongbao = 'Đã từ chối!';

$info = array(
    'ok' => 1,
    'thongbao' => $thongbao,
);
echo json_encode($info);