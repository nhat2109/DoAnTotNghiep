<?php
$thaythe['title']='Danh sách bảo hành';
$thaythe['title_action']='Danh sách bảo hành';
$limit=100;
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM kichhoat_baohanh");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$bien=array(
    'list_baohanh'=>$class_index->list_baohanh($conn,$r_tk['total'],$page,$limit),
    'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-baohanh')
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_baohanh',$bien);
?>