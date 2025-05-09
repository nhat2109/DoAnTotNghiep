<?php
	$thaythe['title'] = 'Danh sách flash sale';
	$thaythe['title_action'] = 'Danh sách flash sale';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM deal WHERE shop='$user_id' AND loai='flash_sale'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_flash_sale' => $class_index->list_flash_sale($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-flash-sale'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_flash_sale', $bien);
?>