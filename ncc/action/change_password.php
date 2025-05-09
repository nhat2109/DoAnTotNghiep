<?php
	$thaythe['title'] = 'Change Password';
	$thaythe['title_action'] = 'Change Password';
	$bien = array(
		'phantrang' => $class_index->phantrang($page, $total, 10, '/ncc/list-nhac'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/change_password', $bien);
?>