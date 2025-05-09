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
    $thongbao = 'Thêm domain thành công';
    $ok = 1;
    mysqli_query($conn, "INSERT INTO domain_price(domain,loai,gia,phi_caidat,gia_han,thu_tu)VALUES('$domain','$loai','$gia','$phi_caidat','$gia_han','$thu_tu')");
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>