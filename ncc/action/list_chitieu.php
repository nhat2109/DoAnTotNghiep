<?php
	$thaythe['title'] = 'Lịch sử chi tiêu';
	$thaythe['title_action'] = 'Lịch sử chi tiêu';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM lichsu_chitieu WHERE user_id='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_chitieu' => $class_index->list_chitieu($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-chitieu'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_chitieu', $bien);
?>