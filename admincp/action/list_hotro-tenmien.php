<?php 
    if(in_array('domain', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
	$thaythe['title']='Danh sách yêu cầu hỗ trợ tên miền';
	$thaythe['title_action']='Danh sách yêu cầu hỗ trợ tên miền';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM hotro_domain");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_hotro_domain'=>$class_index->list_hotro_domain($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-hotro-tenmien')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_hotro_domain',$bien);
?>