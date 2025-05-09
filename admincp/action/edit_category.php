<?php 
    if(in_array('category', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
	$thaythe['title']='Chỉnh sửa danh mục sản phẩm';
	$thaythe['title_action']='Chỉnh sửa danh mục sản phẩm';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM category_sanpham WHERE cat_id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Danh mục không tồn tại...";
		$replace=array(
			'title'=>'Danh mục không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-category'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$r_tt['option_main']=$class_index->list_option_main_sanpham($conn,$r_tt['cat_main']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_category',$r_tt);
?>