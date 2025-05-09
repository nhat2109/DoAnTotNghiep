<?php 
$id = $_REQUEST['id'];
$sql = "SELECT baocao FROM dexuat WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$baoCaoJson = $row['baocao'];
$data = json_decode($baoCaoJson, true);
$data[0]['acp'] = "Phê duyệt";
            $data[0]['noidung_xacnhan'] = "Đã phê duyệt";
            $baoCaoJsonMoi = mysqli_real_escape_string($conn, json_encode($data, JSON_UNESCAPED_UNICODE));
mysqli_query($conn,"UPDATE dexuat SET trangthai='1', baocao='$baoCaoJsonMoi' WHERE id = '{$id}'");
$info = array('ok'=>1,'thongbao'=>'Đã phê duyệt','noti'=>1);
echo json_encode($info);