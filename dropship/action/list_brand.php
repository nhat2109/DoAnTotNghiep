<?php
	$thaythe['title'] = 'Danh sách thương hiệu sản phẩm';
	$thaythe['title_action'] = 'Danh sách thương hiệu sản phẩm';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM thuong_hieu WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_brand' => $class_index->list_brand($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-brand'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_brand', $bien);
?>