<?php
	$thaythe['title'] = 'Chỉnh sửa cài đặt';
	$thaythe['title_action'] = 'Chỉnh sửa cài đặt';
	$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM shop_setting WHERE name='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Mục cài đặt không tồn tại...";
		$replace = array(
			'title' => 'Mục cài đặt không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/list-setting',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	if ($r_tt['loai'] == 'img') {
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_setting_img', $r_tt);
	} else if ($r_tt['loai'] == 'html') {
		if($r_tt['name']=='home_feature')
		{
			$value = json_decode($r_tt['value'], true);
			if ($value && isset($value['features'])) {
				foreach ($value['features'] as $key => $feature) {
					$r_tt['icons_' . ($key + 1)] = $feature['icon'];
					$r_tt['titles_' . ($key + 1)] = $feature['title'];
					$r_tt['descs_' . ($key + 1)] = $feature['desc'];  
				}
			}
			$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_setting_home_feature', $r_tt);//7-4
		}else if($r_tt['name']=='feedback_shop')
		{
			$r_tt['value'] = json_decode($r_tt['value'], true);
			$r_tt['feedback_data'] = json_encode($r_tt['value']);
			unset($r_tt['value']);
			$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_setting_home_feedback', $r_tt);
		}
		else{
			$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_setting_html', $r_tt);
		}
	} else if ($r_tt['loai'] == 'css') {
		$tach_css = json_decode($r_tt['value'], true);
		if ($tach_css['background'] == '') {
			$r_tt['bg_background'] = '#fff';
		} else {
			$r_tt['bg_background'] = $tach_css['background'];
		}
		if ($tach_css['topbar'] == '') {
			$r_tt['bg_topbar'] = '#ff5722';
		} else {
			$r_tt['bg_topbar'] = $tach_css['topbar'];
		}
		if ($tach_css['header'] == '') {
			$r_tt['bg_header'] = '#ff5722';
		} else {
			$r_tt['bg_header'] = $tach_css['header'];
		}
		if ($tach_css['hotline'] == '') {
			$r_tt['bg_hotline'] = '#ee3900';
		} else {
			$r_tt['bg_hotline'] = $tach_css['hotline'];
		}
		if ($tach_css['menu'] == '') {
			$r_tt['bg_menu'] = '#191919';
		} else {
			$r_tt['bg_menu'] = $tach_css['menu'];
		}
		if ($tach_css['title_box'] == '') {
			$r_tt['bg_title_box'] = '#ff5722';
		} else {
			$r_tt['bg_title_box'] = $tach_css['title_box'];
		}
		if ($tach_css['title_menu'] == '') {
			$r_tt['bg_title_menu'] = '#ee3900';
		} else {
			$r_tt['bg_title_menu'] = $tach_css['title_menu'];
		}
		if ($tach_css['button_top'] == '') {
			$r_tt['bg_button_top'] = '#ff5722';
		} else {
			$r_tt['bg_button_top'] = $tach_css['button_top'];
		}
		if ($tach_css['subcribe'] == '') {
			$r_tt['bg_subcribe'] = '#ff5722';
		} else {
			$r_tt['bg_subcribe'] = $tach_css['subcribe'];
		}
		if ($tach_css['label_sale'] == '') {
			$r_tt['bg_label_sale'] = '#ff5722';
		} else {
			$r_tt['bg_label_sale'] = $tach_css['label_sale'];
		}
		if ($tach_css['ma_giamgia'] == '') {
			$r_tt['bg_ma_giamgia'] = '#f00';
		} else {
			$r_tt['bg_ma_giamgia'] = $tach_css['ma_giamgia'];
		}
		if ($tach_css['top_menu_mobile'] == '') {
			$r_tt['bg_top_menu_mobile'] = '#ff5722';
		} else {
			$r_tt['bg_top_menu_mobile'] = $tach_css['top_menu_mobile'];
		}
		if ($tach_css['top_footer'] == '') {
			$r_tt['bg_top_footer'] = '#191919';
		} else {
			$r_tt['bg_top_footer'] = $tach_css['top_footer'];
		}
		if ($tach_css['text_top_footer'] == '') {
			$r_tt['text_top_footer'] = '#888888';
		} else {
			$r_tt['text_top_footer'] = $tach_css['text_top_footer'];
		}
		if ($tach_css['text_title_top_footer'] == '') {
			$r_tt['text_title_top_footer'] = '#fff';
		} else {
			$r_tt['text_title_top_footer'] = $tach_css['text_title_top_footer'];
		}
		if ($tach_css['bottom_footer'] == '') {
			$r_tt['bg_bottom_footer'] = '#0f0f0f';
		} else {
			$r_tt['bg_bottom_footer'] = $tach_css['bottom_footer'];
		}
		if ($tach_css['text_bottom_footer'] == '') {
			$r_tt['text_bottom_footer'] = '#888';
		} else {
			$r_tt['text_bottom_footer'] = $tach_css['text_bottom_footer'];
		}
		if ($tach_css['timkiem'] == '') {
			$r_tt['bg_timkiem'] = '#ff5722';
		} else {
			$r_tt['bg_timkiem'] = $tach_css['timkiem'];
		}
		if ($tach_css['nhantin'] == '') {
			$r_tt['bg_nhantin'] = '#000';
		} else {
			$r_tt['bg_nhantin'] = $tach_css['nhantin'];
		}
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_setting_css', $r_tt);
	} else {
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_setting', $r_tt);
	}
?>