<?php 
if (!isset($_COOKIE['user_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    $user_id = (int)$user_id;
    $noidung = addslashes($_REQUEST['noidung']);
    $duoi = $check->duoi_file($_FILES['file']['name']);
    $filename = $_FILES['file']['name'][$i];
    $anh=addslashes(strip_tags($_REQUEST['anh']));
    $sp_id=intval($_REQUEST['sp_id']);
    if (strlen($anh)>5) {
        $thongbao = 'Thêm nội dung bán hàng thành công';
        $ok = 1;
        $hientai=time();
        mysqli_query($conn, "INSERT INTO list_share_sanpham(sp_id,minh_hoa,noi_dung,date_post,shop_id)VALUES('$sp_id','$anh','$noidung','$hientai','$user_id')");
    } else {
        $thongbao = 'Vui lòng chọn ảnh minh họa';
        $ok = 0;
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);
?>