<?php
	$thaythe['title'] = 'Danh sách slide';
	$thaythe['title_action'] = 'Danh sách slide';
	$limit = 50;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM slide WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_slide' => $class_index->list_slide($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-slide'),
		 'list_banner'=>$class_index->list_banner($conn , $user_id)
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_slide', $bien);
?>