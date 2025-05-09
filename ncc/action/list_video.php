<?php
	$thaythe['title'] = 'Học viện socdo.vn';
	$thaythe['title_action'] = 'Danh sách video hướng dẫn';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM video WHERE loai LIKE '%all%' OR loai LIKE '%drop%'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_video' => $class_index->list_video($conn, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-video'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_video', $bien);
?>