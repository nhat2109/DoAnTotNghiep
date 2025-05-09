<?php  
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    $tieu_de = addslashes($_REQUEST['tieu_de']);
    $noidung = addslashes($_REQUEST['noidung']);
    $id=intval($_REQUEST['id']);
    $anh=addslashes(strip_tags($_REQUEST['anh']));
    $thongtin=mysqli_query($conn,"SELECT * FROM noidung_nhiemvu WHERE id='$id'");
    $r_tt=mysqli_fetch_assoc($thongtin);
    if (strlen($anh)>5) {
        $thongbao = 'Sửa nội dung nhiệm vu thành công';
        $ok = 1;
        $hientai=time();
        mysqli_query($conn, "UPDATE noidung_nhiemvu SET tieu_de='$tieu_de',hinh_anh='$anh',noi_dung='$noidung' WHERE id='$id'");
    } else {
        $thongbao = 'Sửa nội dung nhiệm vụ thành công';
        $ok = 1;
        $hientai=time();
        mysqli_query($conn, "UPDATE noidung_nhiemvu SET tieu_de='$tieu_de',noi_dung='$noidung' WHERE id='$id'");
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>