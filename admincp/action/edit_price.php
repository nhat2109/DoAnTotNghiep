<?php 
  if(in_array('size', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Sửa khoảng giá sản phẩm';
$thaythe['title_action']='Sửa khoảng giá sản phẩm';
$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM khoang_gia WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
    $thongbao="Khoảng giá không tồn tại...";
    $replace=array(
        'title'=>'Khoảng giá không tồn tại...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/admincp/list-size'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
    exit();
}
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_price',$r_tt);  
?>