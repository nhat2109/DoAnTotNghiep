<?php
if(in_array('naptien', explode(',', $user_info['emin_group']))==false AND in_array('xem_naptien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Lịch sử nạp tiền';
$thaythe['title_action']='Lịch sử nạp tiền';
$limit=100;
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM naptien");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$bien=array(
    'list_naptien'=>$class_index->list_naptien($conn,$r_tk['total'],$page,$limit),
    'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-naptien')
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_naptien',$bien);
?>