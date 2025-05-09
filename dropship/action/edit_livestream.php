<?php
	$thaythe['title'] = 'Sửa trạng thái đặt lịch live stream';
	$thaythe['title_action'] = 'Sửa trạng thái đặt lịch live stream';
	$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM dat_live WHERE id='$id' AND user_id='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Giao dịch không tồn tại...";
		$replace = array(
			'title' => 'Giao dịch không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/dropship/list-dat-live',
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong', $replace);
		exit();
	}
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/edit_livestream', $r_tt);
?>