<?php
	$thaythe['title'] = 'Chỉnh sửa slide';
	$thaythe['title_action'] = 'Chỉnh sửa slide';
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM slide WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Slide không tồn tại...";
		$replace = array(
			'title' => 'Slide không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/dropship/list-slide',
		);
		echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
		exit();
	}
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/edit_slide', $r_tt);
?>