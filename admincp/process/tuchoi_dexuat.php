<?php 
$id = $_REQUEST['id'];
$noidung= $_REQUEST['noidung_dexuat'];
$sql = "SELECT baocao FROM dexuat WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$baoCaoJson = $row['baocao'];
$data = json_decode($baoCaoJson, true);
$data[0]['acp'] = "Từ chối";
            $data[0]['noidung_xacnhan'] = $noidung;
            $baoCaoJsonMoi = mysqli_real_escape_string($conn, json_encode($data, JSON_UNESCAPED_UNICODE));
mysqli_query($conn,"UPDATE dexuat SET trangthai='2', baocao='$baoCaoJsonMoi' WHERE id = '{$id}'");
$info = array('ok'=>1,'thongbao'=>'Đã từ chối đề xuất','noti'=>1);
echo json_encode($info);