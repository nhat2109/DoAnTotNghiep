<?php 
    if(in_array('baiviet', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
	$thaythe['title']='Thêm bài viết mới';
	$thaythe['title_action']='Thêm bài viết mới';
	$r_tt['option_category']=$class_index->list_div_category($conn,'');
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_post',$r_tt);
?>