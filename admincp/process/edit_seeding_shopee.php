<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('seeding_shopee', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
        exit();
    }
    $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
    $gia = addslashes(preg_replace('/[^0-9]/', '', $_REQUEST['gia']));
    $gia_cu = addslashes(preg_replace('/[^0-9]/', '', $_REQUEST['gia_cu']));
    $thoi_gian = addslashes(strip_tags($_REQUEST['thoi_gian']));
    $uu_dai = addslashes(strip_tags($_REQUEST['uu_dai']));
    $thu_tu=intval($_REQUEST['thu_tu']);
    $loai = addslashes(strip_tags($_REQUEST['loai']));
    $id=intval($_REQUEST['id']);
    if(strlen($tieu_de)<2){
        $ok=0;
        $thongbao='Vui lòng nhập tên gói';
    }else{
        mysqli_query($conn,"UPDATE seeding_shopee SET tieu_de='$tieu_de',thoi_gian='$thoi_gian',gia='$gia',gia_cu='$gia_cu',uu_dai='$uu_dai',loai='$loai',thu_tu='$thu_tu' WHERE id='$id'");
        $ok=1;
        $thongbao='Lưu thay đổi thành công';

    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>