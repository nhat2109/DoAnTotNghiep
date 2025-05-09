<?php
if(in_array('video', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Sửa video hướng dẫn';
$thaythe['title_action']='Sửa video hướng dẫn';
$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM video WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
    $thongbao="Video không tồn tại...";
    $replace=array(
        'title'=>'Video không tồn tại...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/admincp/list-video'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
    exit();
}
if(strpos($r_tt['loai'], ',')!==false){
    $tach_loai=explode(',', $r_tt['loai']);
    foreach ($tach_loai as $key => $value) {
        $list_loai.='$("#loai_'.$value.' input").prop(\'checked\', true);';
    }
}else{
    $list_loai.='$("#loai_'.$r_tt['loai'].' input").prop(\'checked\', true);';
}
$r_tt['list_loai']=$list_loai;
$r_tt['option_category']=$class_index->list_div_category_video($conn,$r_tt['cat']);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_video',$r_tt);
?>