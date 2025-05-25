<?php
	$thaythe['title'] = 'Lộ trình cho nhà bán mới';
	$thaythe['title_action'] = 'Lộ trình cho nhà bán mới';
	$limit = 10;
	$bien = array(
		'user_id' => $user_id,
		'gioithieu_nhiemvu'=>$index_setting['gioithieu_nhiemvu'],
		'list_nhiemvu'=>$class_index->list_nhiemvu($conn,$user_id)
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/nhiemvu', $bien);
?>