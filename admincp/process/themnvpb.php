<?php
$id = intval($_REQUEST['id']);
$nhanvien = addslashes(strip_tags($_REQUEST['nhanvien']));
$truongphong = addslashes(strip_tags($_REQUEST['truongphong']));
$nhanvien_cl = explode(',', $nhanvien);
foreach ($nhanvien_cl as $key => $value) {
    mysqli_query($conn, "UPDATE emin_info SET id_phongban = '$id',chuc_vu = 'Nhân viên' WHERE id = '$value'");
}
$chucvu = 'Trưởng phòng';
if ($truongphong != '' || $truongphong != "") {
    mysqli_query($conn, "UPDATE emin_info SET chuc_vu = 'Trưởng phòng', id_phongban = '$id' WHERE id = '$truongphong'");
}
$info = array(
    'ok' => 1,
    'thongbao' => 'Thêm thành công',
);
echo json_encode($info);
