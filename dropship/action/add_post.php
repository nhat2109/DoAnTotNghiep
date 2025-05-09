<?php
	$thaythe['title'] = 'Thêm bài viết mới';
	$thaythe['title_action'] = 'Thêm bài viết mới';
	$r_tt['option_category'] = $class_index->list_div_category($conn, $user_id, '');
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/add_post', $r_tt);
?>