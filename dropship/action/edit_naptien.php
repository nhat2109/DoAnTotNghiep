<?php
	$thaythe['title'] = 'Nạp tiền vào tài khoản';
	$thaythe['title_action'] = 'Nạp tiền vào tài khoản';
	$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$step = addslashes(strip_tags($url_query['step']));
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM naptien WHERE id='$id' AND user_id='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Giao dịch không tồn tại...";
		$replace = array(
			'title' => 'Giao dịch không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/dropship/list-naptien',
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong', $replace);
		exit();
	}
	$r_tt['sotien'] = number_format($r_tt['sotien']);
	$r_tt['nganhang'] = $index_setting['nganhang'];
	$r_tt['username'] = $user_info['username'];
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/add_naptien_step2', $r_tt);
?>