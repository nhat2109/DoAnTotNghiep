<?php
$thaythe['title']='Danh sách nhiệm vụ';
$thaythe['title_action']='Danh sách nhiệm vụ';
$limit=100;
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM nhiem_vu");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$bien=array(
    'list_nhiemvu'=>$class_index->list_nhiemvu($conn,$r_tk['total'],$page,$limit),
    'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-nhiemvu')
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_nhiemvu',$bien);
?>