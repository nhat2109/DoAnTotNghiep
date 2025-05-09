<?php
$thaythe['title']='Danh sách sản phẩm gợi ý';
$thaythe['title_action']='Danh sách sản phẩm gợi ý';
$limit=100;
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM sanpham_trend");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
if(isset($_COOKIE['admin_kho'])){
    $kho=$_COOKIE['admin_kho'];
}else{
    $kho='kho';
}
$bien=array(
    'list_sanpham'=>$class_index->list_sanpham_trend($conn,$kho,$page,$limit),
    'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-sanpham-trend')
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_sanpham_trend',$bien);
?>