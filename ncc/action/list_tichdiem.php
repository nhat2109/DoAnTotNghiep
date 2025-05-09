<?php
	$thaythe['title'] = 'Danh sách cộng điểm';
	$thaythe['title_action'] = 'Danh sách cộng điểm';
	$limit = 10;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM tich_diem WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_tichdiem' => $class_index->list_tichdiem($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-tichdiem'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_tichdiem', $bien);
?>