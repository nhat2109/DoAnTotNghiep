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
	$thaythe['title']='Danh sách cài đặt';
	$thaythe['title_action']='Danh sách cài đặt';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM index_setting");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_setting'=>$class_index->list_setting($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-setting')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_setting',$bien);
?>