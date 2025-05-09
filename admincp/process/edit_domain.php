<?php  
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('domain', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
        exit();
    }
    $domain = addslashes(strip_tags($_REQUEST['domain']));
    $loai = addslashes(strip_tags($_REQUEST['loai']));
    $gia=preg_replace('/[^0-9]/', '', $_REQUEST['gia']);
    $phi_caidat=preg_replace('/[^0-9]/', '', $_REQUEST['phi_caidat']);
    $gia_han=preg_replace('/[^0-9]/', '', $_REQUEST['gia_han']);
    $thu_tu = intval($_REQUEST['thu_tu']);
    $id=intval($_REQUEST['id']);
    $thongbao = 'Sửa tên miền thành công';
    $ok = 1;
    mysqli_query($conn, "UPDATE domain_price SET domain='$domain',gia='$gia',phi_caidat='$phi_caidat',gia_han='$gia_han',loai='$loai',thu_tu='$thu_tu' WHERE id='$id'");
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>