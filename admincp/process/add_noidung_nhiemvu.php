<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    $tieu_de = addslashes($_REQUEST['tieu_de']);
    $noidung = addslashes($_REQUEST['noidung']);
    $anh=addslashes(strip_tags($_REQUEST['anh']));
    $nhiemvu_id=intval($_REQUEST['nhiemvu_id']);
    if (strlen($anh)>5) {
        $thongbao = 'Thêm nội dung nhiệm vụ thành công';
        $ok = 1;
        $hientai=time();
        mysqli_query($conn, "INSERT INTO noidung_nhiemvu(nhiem_vu,tieu_de,hinh_anh,noi_dung,date_post)VALUES('$nhiemvu_id','$tieu_de','$anh','$noidung','$hientai')");
    } else {
        $thongbao = 'Vui lòng chọn ảnh minh họa';
        $ok = 0;
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>