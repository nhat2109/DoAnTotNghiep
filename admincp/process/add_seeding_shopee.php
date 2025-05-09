<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('seeding_shopee', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
        exit();
    }
    $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
    $gia_cu = addslashes(preg_replace('/[^0-9]/', '', $_REQUEST['gia_cu']));
    $gia = addslashes(preg_replace('/[^0-9]/', '', $_REQUEST['gia']));
    $thoi_gian = addslashes(strip_tags($_REQUEST['thoi_gian']));
    $uu_dai = addslashes(strip_tags($_REQUEST['uu_dai']));
    $loai = addslashes(strip_tags($_REQUEST['loai']));
    $thu_tu=intval($_REQUEST['thu_tu']);
    if(strlen($tieu_de)<2){
        $ok=0;
        $thongbao='Vui lòng nhập tên gói';
    }else{
        mysqli_query($conn,"INSERT INTO seeding_shopee(tieu_de,loai,thoi_gian,gia,gia_cu,uu_dai,thu_tu)VALUES('$tieu_de','$loai','$thoi_gian','$gia','$gia_cu','$uu_dai','$thu_tu')");
        $ok=1;
        $thongbao='Thêm gói dịch vụ thành công';

    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>