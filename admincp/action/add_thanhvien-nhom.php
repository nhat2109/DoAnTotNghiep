<?php
if(in_array('nhom', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Thêm thành viên nhóm';
$thaythe['title_action']='Thêm thành viên nhóm';
$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM nhom WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_thanhvien_nhom',$r_tt);
?>