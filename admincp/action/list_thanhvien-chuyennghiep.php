<?php
if(in_array('thanhvien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Danh sách nhà bán chuyên nghiệp';
$thaythe['title_action']='Danh sách nhà bán chuyên nghiệp';
$limit=100;
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE leader='1'");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$bien=array(
    'tieu_de'=>$r_tt['tieu_de'],
    'id'=>$id,
    'list_thanhvien_chuyennghiep'=>$class_index->list_thanhvien_chuyennghiep($conn,$r_tk['total'],$page,$limit),
    'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-thanhvien-chuyennghiep')
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_thanhvien_chuyennghiep',$bien);
?>