<?php
$thaythe['title']='Sản phẩm sắp hết hàng';
$thaythe['title_action']='Sản phẩm sắp hết hàng';
$limit=100;
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM sanpham WHERE kho<='10'");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
if(isset($_COOKIE['admin_kho'])){
    $kho=$_COOKIE['admin_kho'];
}else{
    $kho='kho';
}
$bien=array(
    'list_sanpham'=>$class_index->list_sanpham_hethang($conn,$kho,$page,$limit),
    'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-sanpham-hethang')
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_sanpham_hethang',$bien);
?>