<?php
	$thaythe['title'] = 'Danh sách đơn hàng Sóc Đỏ';
	$thaythe['title_action'] = 'Danh sách đơn hàng';
	$limit = 50;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM donhang_ctv WHERE user_id='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_donhang' => $class_index->list_donhang_socdo($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-donhang-socdo'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_donhang_socdo', $bien);
?>