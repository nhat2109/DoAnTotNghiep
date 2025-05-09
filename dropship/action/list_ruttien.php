<?php
	$thaythe['title'] = 'Lịch sử rút hoa hồng';
	$thaythe['title_action'] = 'Lịch sử rút hoa hồng';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM rut_tien WHERE user_id='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_ruttien' => $class_index->list_ruttien($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-ruttien'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_ruttien', $bien);
?>