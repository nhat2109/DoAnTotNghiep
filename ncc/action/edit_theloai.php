<?php
	$thaythe['title'] = 'Chỉnh sửa danh mục bài viết';
	$thaythe['title_action'] = 'Chỉnh sửa danh mục bài viết';
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM category_shop WHERE cat_id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Danh mục không tồn tại...";
		$replace = array(
			'title' => 'Danh mục không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/list-theloai',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	$r_tt['option_main'] = $class_index->list_option_main($conn, $r_tt['cat_main'],$id);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_theloai', $r_tt);
?>