<?php
	$thaythe['title'] = 'Danh sách cài đặt';
	$thaythe['title_action'] = 'Danh sách cài đặt';
	$limit = 10;
	$bien = array(
		'list_setting' => $class_index->list_setting($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-setting'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_setting', $bien);
?>