<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('brand', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
        exit();
    }
    $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
    $thu_tu = intval($_REQUEST['thu_tu']);
    $link_anh = addslashes(strip_tags($_REQUEST['link_anh']));
    $status = intval($_REQUEST['trang_thai']);
    $duoi = $check->duoi_file($_FILES['file']['name']);
    if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
        $anh_thuong_hieu = '/uploads/thuong-hieu/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
        move_uploaded_file($_FILES['file']['tmp_name'], '..' . $anh_thuong_hieu);
        @unlink('..' . $index_setting[$name]);
        mysqli_query($conn, "INSERT INTO thuong_hieu(shop,tieu_de,thu_tu,anh_thuong_hieu,link_anh,status)VALUES(0,'$tieu_de','$thu_tu','$anh_thuong_hieu','$link_anh','$status')");
        $thongbao = 'Thêm thương hiệu thành công';
        $ok = 1;
    } else {
        $thongbao = 'Thất bại! Bạn chưa chọn hình ảnh';
        $ok = 0;
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>