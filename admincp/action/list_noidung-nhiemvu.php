<?php
$thaythe['title']='Danh sách nội dung nhiệm vụ';
$thaythe['title_action']='Danh sách nội dung nhiệm vụ';
$limit=25;
$id=preg_replace('/[^0-9]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT * FROM nhiem_vu WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM noidung_nhiemvu WHERE nhiem_vu='$id'");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$bien=array(
    'tieu_de'=>$r_tt['tieu_de'],
    'id'=>$id,
    'list_noidung'=>$class_index->list_noidung_nhiemvu($conn,$id,$page,$limit),
    'phantrang'=>$class_index->phantrang_timkiem($page,$total_page,'/admincp/list-noidung-nhiemvu?id='.$id)
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_noidung_nhiemvu',$bien);
?>