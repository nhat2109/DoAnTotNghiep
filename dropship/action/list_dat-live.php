<?php
	$thaythe['title'] = 'Lịch sử đặt lịch live stream';
	$thaythe['title_action'] = 'Lịch sử đặt lịch live stream';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM dat_live WHERE user_id='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_dat_live' => $class_index->list_dat_live($conn, $user_id, $r_tk['total'], $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-dat-live'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_dat_live', $bien);
?>