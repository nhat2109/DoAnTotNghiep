<?php 
	$step = intval($url_query['step']);
	$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM domain WHERE user_id='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($step == 2) {
		$thaythe['title'] = 'Thiết lập giao diện';
		$thaythe['title_action'] = 'Thiết lập giao diện';
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_giaodien_step2', $r_tt);
	} else {
		$thaythe['title'] = 'Thiết lập giao diện';
		$thaythe['title_action'] = 'Thiết lập giao diện';
		$r_tt['domain'] = $user_info['domain'];
		$r_tt['ip_server'] = $index_setting['ip_server'];
		$limit = 10;
		$r_tt['list_giaodien'] = $class_index->list_giaodien($conn, $page, $limit);
		if ($r_tt['total'] == 0) {
			$r_tt['skin'] = 'Chưa thiết lập';
		} else {
			$r_tt['skin'] = $r_tt['skin_tieude'];
		}
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_giaodien', $r_tt);
	}
?>