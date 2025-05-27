<?php
	$thaythe['title'] = 'Chỉnh sửa màu sắc';
	$thaythe['title_action'] = 'Chỉnh sửa màu sắc';
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM mau_sanpham WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Dữ liệu này không tồn tại...";
		$replace = array(
			'title' => 'Dữ liệu này không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/list-color',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_color', $r_tt);
?>