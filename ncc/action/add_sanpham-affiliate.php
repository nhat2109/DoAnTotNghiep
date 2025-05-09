<?php
	$thaythe['title'] = 'Thêm sản phẩm affiliate';
	$thaythe['title_action'] = 'Thêm sản phẩm affiliate';
	$id = intval($url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	$r_tt['option_category'] = $class_index->list_div_category_sanpham($conn, $user_id, '');
	$tach_main_category = json_decode($class_index->list_div_main_category_sanpham($conn, $user_id, $r_tt['cat']), true);
	$tach_sub_category = json_decode($class_index->list_div_sub_category_sanpham($conn, $user_id, $tach_main_category['list_id'], $r_tt['cat']), true);
	$tach_sub_sub_category = json_decode($class_index->list_div_sub_sub_category_sanpham($conn, $user_id, $tach_sub_category['list_id'], $r_tt['cat']), true);
	$r_tt['option_main_category'] = $tach_main_category['list'];
	$r_tt['option_sub_category'] = $tach_sub_category['list'];
	$r_tt['option_sub_sub_category'] = $tach_sub_sub_category['list'];
	if (strlen($r_tt['anh']) > 3) {
		$tach_anh = explode(",", $r_tt['anh']);
		foreach ($tach_anh as $key => $value) {
			$pt['src'] = $value;
			$list_anh .= $skin->skin_replace('skin_ncc/box_action/li_photo', $pt);
		}
	}
	$r_tt['list_photo'] = $list_anh;
	$r_tt['option_color'] = $class_index->list_div_color_sanpham($conn, $r_tt['mau']);
	$r_tt['option_size'] = $class_index->list_option_size($conn, $user_id, $r_tt['size']);
	$r_tt['option_brand'] = $class_index->list_option_brand($conn, $user_id, $r_tt['thuong_hieu']);
	if (strlen($r_tt['thongtin']) > 2) {
		$tach_info = explode('|', $r_tt['thongtin']);
		foreach ($tach_info as $key => $value) {
			$tach_value = explode('&&', $value);
			$list_info .= $skin->skin_replace('skin_cpanel/box_action/li_info', $tach_value);
		}
		$r_tt['list_info'] = $list_info;
	} else {
		$r_tt['list_info'] = '';
	}
	$r_tt['drop_min'] = number_format($r_tt['drop_min']);
	$r_tt['drop_max'] = number_format($r_tt['drop_max']);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/add_sanpham_affiliate', $r_tt);
?>