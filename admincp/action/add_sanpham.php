<?php
if(in_array('sanpham', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Thêm sản phẩm mới';
$thaythe['title_action']='Thêm sản phẩm mới';
$tach_main_category=json_decode($class_index->list_div_main_category_sanpham($conn,''),true);
$r_tt['option_main_category']=$tach_main_category['list'];
$r_tt['option_sub_category']='';
$r_tt['option_sub_sub_category']='';
$r_tt['option_brand']=$class_index->list_option_brand($conn,'');
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_sanpham',$r_tt);
?>