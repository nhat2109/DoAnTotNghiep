<?php
	$thaythe['title'] = 'Chi tiết liên hệ';
	$thaythe['title_action'] = 'Chi tiết liên hệ';
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM contact_shop WHERE id='$id' AND shop='$user_id' ORDER BY id DESC LIMIT 1");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Liên hệ không tồn tại...";
		$replace = array(
			'title' => 'Liên hệ không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/dropship/list-contact',
		);
		echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
		exit();
	}
	mysqli_query($conn, "UPDATE contact_shop SET status='1' WHERE id='$id' AND shop='$user_id'");
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/contact_detail', $r_tt);
?>