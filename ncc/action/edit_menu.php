<?php
	$thaythe['title'] = 'Chỉnh sửa menu';
	$thaythe['title_action'] = 'Chỉnh sửa menu';
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM menu_shop WHERE menu_id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Menu này không tồn tại...";
		$replace = array(
			'title' => 'Menu không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/list-menu',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	$r_tt['option_category'] = $class_index->list_option_category($conn, $user_id, '');
	$r_tt['option_category_sanpham'] = $class_index->list_option_category_sanpham($conn, $user_id, '');
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_menu', $r_tt);
?>