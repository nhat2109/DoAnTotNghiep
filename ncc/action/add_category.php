<?php
	$thaythe['title'] = 'Thêm danh mục sản phẩm';
	$thaythe['title_action'] = 'Thêm danh mục sản phẩm';
	$r_tt['option_main'] = $class_index->list_option_main($conn, $user_id, '');
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/add_category', $r_tt);

	$tach_main_category_ncc=json_decode($class_index->list_div_main_category_sanpham_ncc($conn,''),true);
	$r_tt['option_main_category_ncc']=$tach_main_category_ncc['list'];
	$r_tt['option_sub_category_ncc']='';
	$r_tt['option_sub_sub_category_ncc']='';
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/add_category', $r_tt);
?>