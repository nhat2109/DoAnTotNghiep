<?php
$thaythe['title']='Danh sách đăng ký nhận hỗ trợ';
$thaythe['title_action']='Danh sách đăng ký nhận hỗ trợ';
$limit=100;
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM pop_hotro");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$bien=array(
    'list_hotro'=>$class_index->list_dangky_hotro($conn,$r_tk['total'],$page,$limit),
    'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-dangky-hotro')
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_dangky_hotro',$bien);
?>