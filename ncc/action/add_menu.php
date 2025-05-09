<?php
	$thaythe['title'] = 'Thêm menu mới';
	$thaythe['title_action'] = 'Thêm menu mới';
	$r_tt['option_category_sanpham'] = $class_index->list_option_category_sanpham($conn, $user_id, '');
	$r_tt['option_category'] = $class_index->list_option_category($conn, $user_id, '');

	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/add_menu', $r_tt);
?>