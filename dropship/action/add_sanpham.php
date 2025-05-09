<?php
	$thaythe['title'] = 'Thêm sản phẩm mới';
	$step = $url_query['step'];
	$step = addslashes(strip_tags($step));
	if ($step == 2) {
		$thaythe['title_action'] = 'Thêm sản phẩm mới';
		$id = intval($url_query['id']);
		$thongtin_check = mysqli_query($conn, "SELECT count(*) AS total FROM sanpham_shop WHERE sp_id='$id' AND shop='$user_id' ORDER BY id DESC LIMIT 1");
		$r_check = mysqli_fetch_assoc($thongtin_check);
		if ($r_check['total'] == 0) {
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			$r_tt['option_category'] = $class_index->list_div_category_sanpham($conn, $user_id, '');
			$tach_main_category = json_decode($class_index->list_div_main_category_sanpham($conn, $user_id, ''), true);
			$r_tt['option_main_category'] = $tach_main_category['list'];
			$r_tt['option_sub_category'] = '';
			$r_tt['option_sub_sub_category'] = '';
			if (strlen($r_tt['anh']) > 3) {
				$tach_anh = explode(",", $r_tt['anh']);
				foreach ($tach_anh as $key => $value) {
					$pt['src'] = $value;
					$list_anh .= $skin->skin_replace('skin_dropship/box_action/li_photo', $pt);
				}
			}
			$r_tt['list_photo'] = $list_anh;
			$r_tt['option_color'] = $class_index->list_div_color_sanpham($conn, $r_tt['mau']);
			$r_tt['option_size'] = $class_index->list_div_size_sanpham($conn, $user_id, $r_tt['size']);
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
			$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/add_sanpham_step2', $r_tt);
		} else {
			$thongbao = "Sản phẩm đã có trên shop của bạn...";
			$replace = array(
				'title' => 'Sản phẩm đã có trên shop của bạn...',
				'description' => $index_setting['description'],
				'thongbao' => $thongbao,
				'link_chuyen' => '/dropship/add-sanpham',
			);
			echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
			exit();
		}

	} else {
		$limit = 25;
		$list_dang='';
		$thongtin_dang=mysqli_query($conn,"SELECT * FROM sanpham_shop WHERE shop='$user_id' AND sp_id>'0'");
		while($r_dang=mysqli_fetch_assoc($thongtin_dang)){
			$list_dang.=$r_dang['sp_id'].',';
		}
		if($list_dang==''){
			$thongke = mysqli_query($conn, "SELECT *, count(*) AS total FROM sanpham WHERE noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%'");
		}else{
			$list_dang=substr($list_dang, 0,-1);
			$thongke = mysqli_query($conn, "SELECT *, count(*) AS total FROM sanpham WHERE id NOT IN ($list_dang) AND (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%')");
		}
		if (isset($_COOKIE['drop_kho'])) {
			$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
		} else {
			$kho = 'kho';
		}
		$r_tk = mysqli_fetch_assoc($thongke);
		$total_page = ceil($r_tk['total'] / $limit);
		//$r_tt['phantrang'] = $class_index->phantrang($page, $total_page, '/dropship/add-sanpham');
		$r_tt['option_thuonghieu'] = $class_index->list_option_brand($conn, 0, '');
		$r_tt['list_banner_qc'] = $class_index->list_banner_qc($conn, 5);
		$thaythe['title_action'] = 'Nhà cung cấp nổi bật';
		if($check->is_mobile()==true){
			$r_tt['list_sanpham'] = $class_index->list_sanpham($conn,$user_info['leader'],$user_info['gia_leader'],'mobile', $kho,$list_dang, $user_id, $page, $limit);
			$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/add_sanpham_step1_mobile', $r_tt);
		}else{
			$r_tt['list_sanpham'] = $class_index->list_sanpham($conn,$user_info['leader'],$user_info['gia_leader'],'laptop', $kho,$list_dang, $user_id, $page, $limit);
			$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/add_sanpham_step1', $r_tt);
		}
	}
?>