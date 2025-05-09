<?php
	$thaythe['title'] = 'Book lịch livestream';
	$thaythe['title_action'] = 'Book lịch livestream';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM idol");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_idol' => $class_index->list_idol($conn, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-idol'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_idol', $bien);
?>