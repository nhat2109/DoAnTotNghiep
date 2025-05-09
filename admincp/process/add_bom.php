<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('donhang', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
        exit();
    }
    $ho_ten = addslashes(strip_tags($_REQUEST['ho_ten']));
    $dien_thoai = addslashes(strip_tags($_REQUEST['dien_thoai']));
    $dia_chi = addslashes(strip_tags($_REQUEST['dia_chi']));
    $tinh_trang = addslashes(strip_tags($_REQUEST['tinh_trang']));
    $thongbao = 'Thêm bom hàng thành công';
    $ok = 1;
    mysqli_query($conn, "INSERT INTO bom_hang(user_id,ho_ten,dien_thoai,dia_chi,tinh_trang,date_post)VALUES('0','$ho_ten','$dien_thoai','$dia_chi','$tinh_trang',".time().")");
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>