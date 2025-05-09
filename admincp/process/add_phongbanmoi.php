<?php
$tenphongban= addslashes(strip_tags($_REQUEST['ten_phongban']));
$phongbancha = intval($_REQUEST['phongbancha']) ? intval($_REQUEST['phongbancha']) : null;
if($tenphongban == ''){
    $ok = 0;
    $thongbao = 'Vui lòng nhập tên phòng ban';
}elseif (empty($phongbancha)) {
    $ok = 1;
    $thongbao = 'Thêm phòng ban thành công';
    mysqli_query($conn, "INSERT INTO phong_ban(tieu_de_phongban)VALUES('$tenphongban')");
}else{
    $ok = 1;
    $thongbao = 'Thêm phòng ban thành công';
    mysqli_query($conn, "INSERT INTO phong_ban(tieu_de_phongban,parent_id)VALUES('$tenphongban','$phongbancha')");
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
