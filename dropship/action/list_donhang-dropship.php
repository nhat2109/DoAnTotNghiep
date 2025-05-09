<?php
	$thaythe['title'] = 'Danh sách đơn hàng';
	$thaythe['title_action'] = 'Danh sách đơn hàng';
	$limit = 50;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM donhang WHERE user_id='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_donhang' => $class_index->list_donhang_drop($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-donhang-dropship'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_donhang_dropship', $bien);
?>