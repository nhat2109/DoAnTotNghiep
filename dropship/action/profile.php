<?php
	$thaythe['title'] = 'Profile';
	$thaythe['title_action'] = 'Profile';
	$user_info['user_money'] = number_format($user_info['user_money']) . ' đ';
	$user_info['option_tinh'] = $class_index->list_option_tinh($conn,$user_info['tinh']);
	$user_info['option_huyen'] = $class_index->list_option_huyen($conn,$user_info['tinh'],$user_info['huyen']);
	$user_info['option_xa'] = $class_index->list_option_xa($conn,$user_info['huyen'],$user_info['xa']);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/profile', $user_info);
?>