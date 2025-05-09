<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('color', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
        exit();
    }
    $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
    $ma_mau = addslashes($_REQUEST['ma_mau']);
    $thu_tu = intval($_REQUEST['thu_tu']);
    $thongbao = 'Thêm màu sản phẩm thành công';
    $ok = 1;
    mysqli_query($conn, "INSERT INTO mau_sanpham(tieu_de,ma_mau,thu_tu)VALUES('$tieu_de','$ma_mau','$thu_tu')");
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>