<?php 
  	if(in_array('seeding', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
	$thaythe['title']='Thêm gói dịch vụ seeding NCC';
	$thaythe['title_action']='Thêm gói dịch vụ seeding NCC';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_seeding_shopee_ncc',$r_tt);  
?>