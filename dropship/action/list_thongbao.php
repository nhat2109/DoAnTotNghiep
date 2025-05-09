<?php
	$thaythe['title'] = 'Danh sách Remarketing';
	$thaythe['title_action'] = 'Danh sách Remarketing';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM thongbao_shop WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_remarketing' => $class_index->list_remarketing($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-remarketing'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_remarketing', $bien);
?>