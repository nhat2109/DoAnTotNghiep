<?php
	$thaythe['title'] = 'Chỉnh sửa kích cỡ';
	$thaythe['title_action'] = 'Chỉnh sửa kích cỡ';
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM kich_co WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Dữ liệu này không tồn tại...";
		$replace = array(
			'title' => 'Dữ liệu này không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/dropship/list-size',
		);
		echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
		exit();
	}
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/edit_size', $r_tt);
?>