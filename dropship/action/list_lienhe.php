<?php
	$thaythe['title'] = 'Danh sách liên hệ';
	$thaythe['title_action'] = 'Danh sách liên hệ';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM contact_shop WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_lienhe' => $class_index->list_lienhe($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-lienhe'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_lienhe', $bien);
?>