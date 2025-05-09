<?php
$diem = intval($_REQUEST['diem']);
$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM caidat_tichdiem WHERE shop='0'");
$r_tt = mysqli_fetch_assoc($thongtin);
if ($r_tt['total'] > 0) {
    mysqli_query($conn, "UPDATE caidat_tichdiem SET diem='$diem' WHERE shop='0'");
} else {
    mysqli_query($conn, "INSERT INTO caidat_tichdiem(shop,diem)VALUES('0','$diem')");
}
$info = array(
    'thongbao' => 'Lưu thay đổi thành công',
    'ok' => 1,
);
echo json_encode($info);
