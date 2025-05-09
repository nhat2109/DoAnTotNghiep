<?php
	$thaythe['title'] = 'Danh sách mã khuyến mại';
	$thaythe['title_action'] = 'Danh sách mã khuyến mại';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM coupon WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_coupon' => $class_index->list_coupon($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-coupon'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_coupon', $bien);
?>