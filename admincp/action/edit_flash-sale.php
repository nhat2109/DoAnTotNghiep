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
$thaythe['title']='Sửa flash sale';
$thaythe['title_action']='Sửa flash sale';
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
$r_tt['date_start']=date('H:i d/m/Y',$r_tt['date_start']);
$r_tt['date_end']=date('H:i d/m/Y',$r_tt['date_end']);
$list_id=$r_tt['main_product'];
$tach_main=explode(',', $r_tt['main_product']);
$tach_sp_sub=json_decode($r_tt['sub_product'],true);
foreach ($tach_sp_sub as $key => $value) {
    $sp_id=$value['sp_id'];
    foreach ($value['list_pl'] as $k => $v) {
        $r_pl['id']=$v['pl'];
        $r_pl['ten_size']=$v['ten_size'];
        $r_pl['ten_color']=$v['ten_color'];
        $r_pl['color']=$v['color'];
        $r_pl['size']=$v['size'];
        $r_pl['ma_mau']=$v['ma_mau'];
        $r_pl['gia_cu']=$v['gia_cu'];
        $r_pl['gia_moi']=$v['gia_moi'];
        $r_pl['gia_deal']=$v['gia'];
        $r_pl['so_luong']=$v['so_luong'];
        $list_pl[$sp_id].=$skin->skin_replace('skin_cpanel/box_action/li_pl',$r_pl);
    }
}
$thongtin_sanpham=mysqli_query($conn,"SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY id DESC");
while($r_sp=mysqli_fetch_assoc($thongtin_sanpham)){
    $sp_id=$r_sp['id'];
    $r_sp['list_pl']=$list_pl[$sp_id];
    $list_sub.=$skin->skin_replace('skin_cpanel/box_action/li_product_flash_sale',$r_sp);
}
$r_tt['list_main']=$list_main;
$r_tt['list_sub']=$list_sub;
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_flash_sale',$r_tt);
?>