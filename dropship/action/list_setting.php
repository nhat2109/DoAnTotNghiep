<?php
	$thaythe['title'] = 'Danh sách cài đặt';
	$thaythe['title_action'] = 'Danh sách cài đặt';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM index_setting");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_setting' => $class_index->list_setting($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-setting'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_setting', $bien);
?>