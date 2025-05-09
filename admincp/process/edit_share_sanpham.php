<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    $noidung = addslashes($_REQUEST['noidung']);
    $duoi = $check->duoi_file($_FILES['file']['name']);
    $anh=addslashes(strip_tags($_REQUEST['anh']));
    $id=intval($_REQUEST['id']);
    $thongtin=mysqli_query($conn,"SELECT * FROM list_share_sanpham WHERE id='$id'");
    $r_tt=mysqli_fetch_assoc($thongtin);
    if (strlen($anh)>5) {
        $thongbao = 'Sửa nội dung bán hàng thành công';
        $ok = 1;
        $hientai=time();
        mysqli_query($conn, "UPDATE list_share_sanpham SET minh_hoa='$anh',noi_dung='$noidung' WHERE id='$id'");
    } else {
        $thongbao = 'Sửa nội dung bán hàng thành công';
        $ok = 1;
        $hientai=time();
        mysqli_query($conn, "UPDATE list_share_sanpham SET noi_dung='$noidung' WHERE id='$id'");
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>