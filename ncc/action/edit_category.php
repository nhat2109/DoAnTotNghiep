<?php
	$thaythe['title'] = 'Chỉnh sửa danh mục sản phẩm';
	$thaythe['title_action'] = 'Chỉnh sửa danh mục sản phẩm';
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);

	$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);

	if (!$r_tt) {
		$thongbao = "Danh mục không tồn tại...";
		$replace = [
			'title' => 'Danh mục không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/list-category',
		];
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}

	$r_tt['option_main'] = $class_index->list_option_main($conn, $user_id, $r_tt['cat_main']);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_category', $r_tt);
?>