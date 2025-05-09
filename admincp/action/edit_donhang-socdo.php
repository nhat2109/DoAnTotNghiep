<?php
if(in_array('donhang', explode(',', $user_info['emin_group']))==false AND in_array('xem_donhang', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
    $thongbao="Bạn không có quyền truy cập...";
    $replace=array(
        'title'=>'Bạn không có quyền truy cập...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/admincp/dashboard'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
    exit();		
}
$thaythe['title']='Chi tiết đơn hàng';
$thaythe['title_action']='Chi tiết đơn hàng';
$id=preg_replace('/[^0-9]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM donhang WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
    $thongbao="Đơn hàng không tồn tại...";
    $replace=array(
        'title'=>'Đơn hàng không tồn tại...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/admincp/list-donhang'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
    exit();
}
$r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
$tach_sanpham=json_decode($r_tt['sanpham'],true);
foreach ($tach_sanpham as $key => $value) {
    if($value['size']!=''){
        $value['size']=' - Size: '.strtoupper($value['size']);
    }
    if($value['color']!=''){
        $value['color']=' - Màu: '.$value['color'];
    }
    $value['giam_sp']=number_format($value['giam']);
    $list_sanpham.=$skin->skin_replace('skin_cpanel/box_action/li_sanpham_socdo_order',$value);
}
$r_tt['list_sanpham']=$list_sanpham;
$r_tt['tamtinh']=number_format($r_tt['tamtinh']);
$r_tt['giam']=number_format($r_tt['giam']);
$r_tt['tongtien']=number_format($r_tt['tongtien']);
if($r_tt['id']<107){
    $thontin_huyen=mysqli_query($conn,"SELECT huyen.*,tinh.tieu_de AS ten_tinh FROM huyen INNER JOIN tinh ON tinh.id=huyen.tinh WHERE huyen.id='{$r_tt['huyen']}'");
}else{
    $thontin_huyen=mysqli_query($conn,"SELECT huyen_moi.*,tinh_moi.tieu_de AS ten_tinh FROM huyen_moi INNER JOIN tinh_moi ON tinh_moi.id=huyen_moi.tinh WHERE huyen_moi.id='{$r_tt['huyen']}'");
}
$r_h=mysqli_fetch_assoc($thontin_huyen);
$r_tt['tinh']=$r_h['ten_tinh'];
$r_tt['huyen']=$r_h['tieu_de'];
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_donhang_socdo',$r_tt);
?>