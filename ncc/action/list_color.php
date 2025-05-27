<?php
	$thaythe['title'] = 'Danh sách màu sắc';
	$thaythe['title_action'] = 'Danh sách màu sắc';
	$limit = 10;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM mau_sanpham WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_color' => $class_index->list_color($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-color'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_color', $bien);
?>