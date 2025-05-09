<?php 
    if(in_array('thanhvien', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
	$thaythe['title']='Danh sách đăng ký drop';
	$thaythe['title_action']='Danh sách đăng ký drop';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE dropship>'0'");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_thanhvien'=>$class_index->list_thanhvien_drop($conn,$r_tk['total'],$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-thanhvien-drop')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_thanhvien_drop',$bien);
?>