<?php
	$thaythe['title'] = 'Chỉnh sửa sản phẩm';
	$thaythe['title_action'] = 'Chỉnh sửa sản phẩm';
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM sanpham_shop WHERE id='$id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Sản phẩm không tồn tại...";
		$replace = array(
			'title' => 'Sản phẩm không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/admincp/list-sanpham',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	if ($r_tt['sp_id'] > 0) {
		if (strlen($r_tt['anh']) > 3) {
			$tach_anh = explode(",", $r_tt['anh']);
			foreach ($tach_anh as $key => $value) {
				$pt['src'] = $value;
				$list_anh .= $skin->skin_replace('skin_ncc/box_action/li_photo', $pt);
			}
		}
	} else {
		if (strlen($r_tt['anh']) > 3) {
			$tach_anh = explode(",", $r_tt['anh']);
			foreach ($tach_anh as $key => $value) {
				$pt['src'] = $value;
				$list_anh .= $skin->skin_replace('skin_ncc/box_action/li_photo', $pt);
			}
		}
	}
	if (strlen($r_tt['thongtin']) > 2) {
		$tach_info = explode('|', $r_tt['thongtin']);
		foreach ($tach_info as $key => $value) {
			$tach_value = explode('&&', $value);
			$list_info .= $skin->skin_replace('skin_ncc/box_action/li_info', $tach_value);
		}
		$r_tt['list_info'] = $list_info;
	} else {
		$r_tt['list_info'] = '';
	}
	$list_phanloai = '';
	$thongtin_phanloai = mysqli_query($conn, "SELECT * FROM phanloai_sanpham_shop WHERE sp_id='$id' ORDER BY id ASC");
	while ($pl = mysqli_fetch_assoc($thongtin_phanloai)) {
		$pl['gia_cu'] = number_format($pl['gia_cu']);
		$pl['gia_moi'] = number_format($pl['gia_moi']);
		$pl['can_nang'] = number_format($pl['can_nang'], 2);
		$pl['kho_sanpham_shop'] = number_format($pl['kho_sanpham_shop']);
		$pl['can_nang_tinhship'] = number_format($pl['can_nang_tinhship'], 2);
		$list_phanloai .= $skin->skin_replace('skin_ncc/box_action/li_phanloai', $pl);
	}
	$r_tt['list_phanloai'] = $list_phanloai ? $list_phanloai : '<div class="li_phanloai"><p>Chưa có phân loại nào</p></div>';
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/add_sanpham_ngoai', $r_tt);
	$r_tt['list_photo'] = $list_anh;
	$r_tt['option_category'] = $class_index->list_div_category_sanpham($conn, $user_id, $r_tt['cat']);
	$tach_main_category = json_decode($class_index->list_div_main_category_sanpham($conn, $user_id, $r_tt['cat']), true);
	if($tach_main_category['list_id']){
		$tach_sub_category = json_decode($class_index->list_div_sub_category_sanpham($conn, $user_id, $tach_main_category['list_id'], $r_tt['cat']), true);
	}
	if($tach_sub_category['list_id']){
		$tach_sub_sub_category = json_decode($class_index->list_div_sub_sub_category_sanpham($conn, $user_id, $tach_sub_category['list_id'], $r_tt['cat']), true);
	}
	// 
	$r_tt['option_main_category'] = $tach_main_category['list'];
	$r_tt['option_sub_category'] = $tach_sub_category['list'];
	$r_tt['option_sub_sub_category'] = $tach_sub_sub_category['list'];
	$r_tt['option_color'] = $class_index->list_div_color_sanpham($conn, $r_tt['mau']);
	$r_tt['option_brand'] = $class_index->list_option_brand($conn, $user_id, $r_tt['thuong_hieu']);
	if ($r_tt['sp_id'] > 0) {
		$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE id='{$r_tt['sp_id']}'");
		$r_sp = mysqli_fetch_assoc($thongtin_sanpham);
		$r_tt['drop_min'] = number_format($r_sp['drop_min']);
		$r_tt['drop_max'] = number_format($r_sp['drop_max']);
		$r_tt['option_size'] = $class_index->list_div_size_sanpham($conn, $user_id, $r_tt['size']);
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_sanpham_ngoai', $r_tt);
	} else if ($r_tt['link_aff'] != '') {
		$r_tt['option_size'] = $class_index->list_option_size($conn, $user_id, $r_tt['size']);
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_sanpham_affiliate', $r_tt);
	} else {
		$r_tt['option_size'] = $class_index->list_option_size($conn, $user_id, $r_tt['size']);
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_sanpham_ngoai', $r_tt);
	}
?>