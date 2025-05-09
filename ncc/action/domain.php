<?php
	$thongtin_dd = mysqli_query($conn, "SELECT *,count(*) AS total FROM domain WHERE user_id='$user_id'");
	$r_dd = mysqli_fetch_assoc($thongtin_dd);
	if ($r_dd['total'] == 0) {
		$thongbao = "Chuyển hướng tới thiết lập giao diện...";
		$replace = array(
			'title' => 'Thiết lập giao diện...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/list-giaodien',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	$thaythe['title'] = 'Thiết lập tên miền';
	$thaythe['title_action'] = 'Thiết lập tên miền';
	$r_tt['domain'] = $user_info['domain'];
	$r_tt['ip_server'] = $index_setting['ip_server'];
	$r_tt['list_domain'] = $class_index->list_domain($conn, 'all');
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/domain', $r_tt);
?>