<?php 
  if(in_array('banner', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Sửa marketing thương hiệu';
$thaythe['title_action']='Sửa marketing thương hiệu';
$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM banner_qc WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
    $thongbao="Dữ liệu không tồn tại...";
    $replace=array(
        'title'=>'Dữ liệu không tồn tại...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/admincp/list-marketing-brand'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
    exit();
}
$r_tt['option_brand']=$class_index->list_option_brand($conn,$r_tt['thuong_hieu']);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_brand_marketing',$r_tt);  
?>