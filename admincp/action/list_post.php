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
	$thaythe['title']='Danh sách bài viết';
	$thaythe['title_action']='Danh sách bài viết';
	$limit=10;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM post");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_baiviet'=>$class_index->list_baiviet($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-post')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_post',$bien);
?>