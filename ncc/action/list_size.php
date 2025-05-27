<?php
	$thaythe['title'] = 'Danh sách kích cỡ';
	$thaythe['title_action'] = 'Danh sách kích cỡ';
	$limit = 10;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM kich_co WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_size' => $class_index->list_size($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-size'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_size', $bien);
?>