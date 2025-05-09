<?php
	$thaythe['title'] = 'Danh sách menu';
	$thaythe['title_action'] = 'Danh sách menu';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM menu_shop WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_menu' => $class_index->list_menu($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-menu'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_menu', $bien);
?>