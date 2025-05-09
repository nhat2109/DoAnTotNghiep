<?php
$userid=preg_replace('/[^0-9]/', '', $url_query['id']);
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
$thaythe['title']='Danh sách hoa hồng';
$thaythe['title_action']='Danh sách hoa hồng';
$limit=50;
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM hoahong_nhom WHERE nhom='$userid'");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$bien=array(
    'list_hoahong'=>$class_index->list_hoahong($conn,$userid,$r_tk['total'],$page,$limit),
    'phantrang'=>$class_index->phantrang_timkiem($page,$total_page,'/admincp/list-hoahong?id='.$userid)
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_hoahong',$bien);
?>