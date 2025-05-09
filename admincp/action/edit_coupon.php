<?php
if(in_array('coupon', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Sửa mã khuyến mại';
$thaythe['title_action']='Sửa mã khuyến mại';
$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM coupon WHERE id='$id' AND shop='0'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
    $thongbao="Mã khuyến mại không tồn tại...";
    $replace=array(
        'title'=>'Mã khuyến mại không tồn tại...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/admincp/list-coupon'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
    exit();
}
if($r_tt['kieu']=='sanpham'){
    $list_id=$r_tt['sanpham'];
    $thongtin_sanpham=mysqli_query($conn,"SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY id DESC");
    while($r_sp=mysqli_fetch_assoc($thongtin_sanpham)){
        $r_sp['gia_cu']=number_format($r_sp['gia_cu']).'đ';
        $r_sp['gia_moi']=number_format($r_sp['gia_moi']).'đ';
        $list_main.=$skin->skin_replace('skin_cpanel/box_action/li_product_main_deal',$r_sp);
    }
    $r_tt['list_sanpham']=$list_main;
}else{
    $r_tt['list_sanpham']='';
}
if($r_tt['kieu']=='sanpham'){
    $r_tt['display']='';
}else{
    $r_tt['display']='display: none;';
}
$r_tt['time_start']=date('H:i:s',$r_tt['start']);
$r_tt['date_start']=date('d/m/Y',$r_tt['start']);
$r_tt['time_expired']=date('H:i:s',$r_tt['expired']);
$r_tt['date_expired']=date('d/m/Y',$r_tt['expired']);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_coupon',$r_tt);
?>