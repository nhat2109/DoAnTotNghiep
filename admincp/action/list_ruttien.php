<?php
if(in_array('ruttien', explode(',', $user_info['emin_group']))==false AND in_array('xem_ruttien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Lịch sử rút tiền';
$thaythe['title_action']='Lịch sử rút tiền';
$limit=100;
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM rut_tien");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$bien=array(
    'list_ruttien'=>$class_index->list_ruttien($conn,$r_tk['total'],$page,$limit),
    'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-ruttien')
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_ruttien',$bien);
?>