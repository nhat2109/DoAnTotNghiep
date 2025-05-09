<?php
    if(in_array('lienhe', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
	$thaythe['title'] = 'Danh sách đăng ký nhận tin';
	$thaythe['title_action'] = 'Danh sách đăng ký nhận tin';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM dangky_nhantin WHERE shop='0'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_nhantin' => $class_index->list_nhantin($conn, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/admincp/list-nhantin'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_cpanel/box_action/list_nhantin', $bien);
?>