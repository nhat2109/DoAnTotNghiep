<?php
if(in_array('donhang', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Danh sách bom hàng';
$thaythe['title_action']='Danh sách bom hàng';
$limit=50;
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM bom_hang");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$bien=array(
    'list_bom'=>$class_index->list_bom($conn,$page,$limit),
    'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-bom-hang')
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_bom_hang',$bien);
?>