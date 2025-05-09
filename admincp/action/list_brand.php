<?php
if(in_array('brand', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Danh sách thương hiệu sản phẩm';
$thaythe['title_action']='Danh sách thương hiệu sản phẩm';
$limit=100;
$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM thuong_hieu WHERE shop =0 AND id_thuonghieu_socdo IS NULL");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);

$thongke_thuonghieu_ncc = mysqli_query($conn, "SELECT COUNT(*) AS total FROM thuong_hieu WHERE shop !=0 AND id_thuonghieu_socdo IS NOT NULL");

$limit_thuonghie_ncc=10;
$r_tk_ncc=mysqli_fetch_assoc($thongke_thuonghieu_ncc);
$total_page_ncc=ceil($r_tk_ncc['total']/$limit_thuonghie_ncc);

$bien=array(
    'list_brand'=>$class_index->list_brand($conn,$page,$limit),
    'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-brand'),
    'list_brand_browse_ncc' =>$class_index->list_brand_browse_ncc($conn,$page,$limit_thuonghie_ncc),
    'phantrang_browse_ncc'=>$class_index->phantrang($page,$total_page_ncc,'/admincp/list-brand'),
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_brand',$bien);
?>