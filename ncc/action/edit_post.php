<?php
	$thaythe['title'] = 'Chỉnh sửa bài viết';
	$thaythe['title_action'] = 'Chỉnh sửa bài viết';
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM post_shop WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Bài viết không tồn tại...";
		$replace = array(
			'title' => 'Bài viết không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/list-post',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	$r_tt['option_category'] = $class_index->list_div_category($conn, $user_id, $r_tt['cat']);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_post', $r_tt);
?>