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
$thaythe['title']='Sửa deal sốc';
$thaythe['title_action']='Sửa deal sốc';
$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM deal WHERE id='$id' AND shop='0'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
    $thongbao="Dữ liệu không tồn tại...";
    $replace=array(
        'title'=>'Dữ liệu không tồn tại...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/admincp/list-deal'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
    exit();
}
$r_tt['date_start']=date('H:i d/m/Y',(int)$r_tt['date_start']);
$r_tt['date_end']=date('H:i d/m/Y',(int)$r_tt['date_end']);
$list_id=$r_tt['main_product'].','.$r_tt['sub_id'];
$tach_main=explode(',', $r_tt['main_product']);
$tach_product=json_decode($r_tt['sub_product'],true);
foreach ($tach_product as $key => $value) {
    $sp_id=$value['sp_id'];
    foreach ($value['list_pl'] as $k => $v) {
        $r_pl['id']=$v['pl'];
        $r_pl['ten_size']=$v['ten_size'];
        $r_pl['ten_color']=$v['ten_color'];
        $r_pl['gia_cu']=$v['gia_cu'];
        $r_pl['gia_moi']=$v['gia_moi'];
        $r_pl['gia_deal']=$v['gia'];
        $list_pl[$sp_id].=$skin->skin_replace('skin_cpanel/box_action/li_pl_deal',$r_pl);
    }
}
$tach_sub=explode(',', $r_tt['sub_id']);
$thongtin_sanpham=mysqli_query($conn,"SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY id DESC");
while($r_sp=mysqli_fetch_assoc($thongtin_sanpham)){
    $r_sp['gia_cu']=number_format($r_sp['gia_cu']).'đ';
    $r_sp['gia_moi']=number_format($r_sp['gia_moi']).'đ';
    if(in_array($r_sp['id'], $tach_main)==true){
        $list_main.=$skin->skin_replace('skin_cpanel/box_action/li_product_main_deal',$r_sp);
    }else if(in_array($r_sp['id'], $tach_sub)==true){
        $sp_id=$r_sp['id'];
        $r_sp['list_pl']=$list_pl[$sp_id];
        $list_sub.=$skin->skin_replace('skin_cpanel/box_action/li_product_sub_deal',$r_sp);
    }
}
$r_tt['list_main']=$list_main;
$r_tt['list_sub']=$list_sub;
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_deal',$r_tt);
?>