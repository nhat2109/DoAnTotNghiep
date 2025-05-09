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
$thaythe['title']='Sửa banner';
$thaythe['title_action']='Sửa banner';
$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM banner WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
    $thongbao="Banner không tồn tại...";
    $replace=array(
        'title'=>'Banner không tồn tại...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/admincp/list-banner'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
    exit();
}
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_banner',$r_tt);  
?>