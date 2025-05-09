<?php 
    if(in_array('menu', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
	$thaythe['title']='Chỉnh sửa menu';
	$thaythe['title_action']='Chỉnh sửa menu';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM menu WHERE menu_id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Menu này không tồn tại...";
		$replace=array(
			'title'=>'Menu không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-menu'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$r_tt['option_category']=$class_index->list_option_category($conn,'');
	$r_tt['option_post']=$class_index->list_option_post($conn,$r_tt['menu_link']);
	$r_tt['option_main']=$class_index->list_option_main_menu($conn,$r_tt['menu_main']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_menu',$r_tt);
?>