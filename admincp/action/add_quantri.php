<?php
    if(in_array('quantri', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
    $thaythe['title']='Thêm quản trị viên';
    $thaythe['title_action']='Thêm quản trị viên';
    $thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_quantri',$r_tt);
?>