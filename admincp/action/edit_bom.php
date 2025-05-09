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
$thaythe['title']='Sửa bom hàng';
$thaythe['title_action']='Sửa bom hàng';
$id=preg_replace('/[^0-9]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM bom_hang WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
    $thongbao="Dữ liệu không tồn tại...";
    $replace=array(
        'title'=>'Dữ liệu không tồn tại...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/admincp/list-bom-hang'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
    exit();
}
$r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_bom',$r_tt);
?>