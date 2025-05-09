<?php
	$thaythe['title'] = 'Thêm danh mục sản phẩm';
	$thaythe['title_action'] = 'Thêm danh mục sản phẩm';
	$r_tt['option_main'] = $class_index->list_option_main($conn, $user_id, '');
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/add_category', $r_tt);
?>