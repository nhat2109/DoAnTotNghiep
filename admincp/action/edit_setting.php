<?php
    if(in_array('caidat', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
	$thaythe['title']='Chỉnh sửa cài đặt';
	$thaythe['title_action']='Chỉnh sửa cài đặt';
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM index_setting WHERE name='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Mục cài đặt không tồn tại...";
		$replace=array(
			'title'=>'Mục cài đặt không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-setting'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	if($r_tt['loai']=='img'){
		$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_setting_img',$r_tt);
	}else if($r_tt['loai']=='html'){
		$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_setting_html',$r_tt);
	}else{
		$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_setting',$r_tt);
	}
?>