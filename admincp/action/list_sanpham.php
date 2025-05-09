<?php
$thaythe['title']='Danh sách sản phẩm';
$thaythe['title_action']='Danh sách sản phẩm';
$limit=25;
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM sanpham");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
if(isset($_COOKIE['admin_kho'])){
    $kho=$_COOKIE['admin_kho'];
}else{
    $kho='kho';
}
$bien=array(
    'option_thuonghieu'=>$class_index->list_option_brand($conn, ''),
    'list_sanpham'=>$class_index->list_sanpham($conn,$kho,$page,$limit),
    'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-sanpham')
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_sanpham',$bien);
?>