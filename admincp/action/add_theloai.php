<?php 
    	if(in_array('theloai', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
        $thaythe['title']='Thêm thể loại';
        $thaythe['title_action']='Thêm thể loại';
        $r_tt['option_main']=$class_index->list_option_main($conn,'');
        $thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_theloai',$r_tt);
?>