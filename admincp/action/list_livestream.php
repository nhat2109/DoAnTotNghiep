<?php
if(in_array('live_stream', explode(',', $user_info['emin_group']))==false AND in_array('quanly_live', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Danh sách đặt lịch live stream';
$thaythe['title_action']='Danh sách đặt lịch live stream';
$limit=50;
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM dat_live");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
if(in_array('quanly_live', explode(',', $user_info['emin_group']))==true){
    $bien=array(
        'list_livestream'=>$class_index->list_quanly_livestream($conn,$r_tk['total'],$page,$limit),
        'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-livestream')
    );
    $thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_quanly_livestream',$bien);
}else{
    $bien=array(
        'list_livestream'=>$class_index->list_livestream($conn,$r_tk['total'],$page,$limit),
        'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-livestream')
    );
    $thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_livestream',$bien);
}
?>