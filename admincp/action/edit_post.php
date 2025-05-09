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
	$thaythe['title']='Chỉnh sửa bài viết';
	$thaythe['title_action']='Chỉnh sửa bài viết';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM post WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Bài viết không tồn tại...";
		$replace=array(
			'title'=>'Bài viết không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-post'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$r_tt['option_category']=$class_index->list_div_category($conn,$r_tt['cat']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_post',$r_tt);  
?>