<?php
$thaythe['title']='Chương trình tuần';
$thaythe['title_action']='Chương trình tuần';
$limit=100;
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM sanpham_tuan");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
if(isset($_COOKIE['admin_kho'])){
    $kho=$_COOKIE['admin_kho'];
}else{
    $kho='kho';
}
$bien=array(
    'list_sanpham'=>$class_index->list_sanpham_tuan($conn,$kho,$page,$limit),
    'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-sanpham-tuan')
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_sanpham_tuan',$bien);
?>