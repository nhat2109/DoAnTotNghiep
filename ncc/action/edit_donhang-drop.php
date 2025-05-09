<?php
	$thaythe['title'] = 'Chi tiết đơn hàng';
	$thaythe['title_action'] = 'Chi tiết đơn hàng';
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM donhang WHERE id='$id' AND user_id='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Đơn hàng không tồn tại...";
		$replace = array(
			'title' => 'Đơn hàng không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/list-donhang-ncc',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
	$tach_sanpham = json_decode($r_tt['sanpham'], true);
	foreach ($tach_sanpham as $key => $value) {
		if ($value['size'] != '') {
			$value['size'] = ' - Size: ' . $value['size'];
		}
		if ($value['color'] != '') {
			$value['color'] = ' - Màu: ' . $value['color'];
		}
		if ($value['ma_sanpham'] != '') {
			$value['ma_sanpham'] = $value['ma_sanpham'];
		} else {
			$value['ma_sanpham'] = '';
		}
		if ($value['gia_nhap'] != '') {
			$value['gia_ncc'] = $value['gia_nhap'];
		} else {
			$value['gia_ncc'] = '';
		}
		if($value['giam']!=''){
			$value['giam']=$value['giam'];
		}else{
			$value['giam']='0';
		}
		$list_sanpham .= $skin->skin_replace('skin_ncc/box_action/li_sanpham_order', $value);
	}
	if ($r_tt['phi_ship'] > 0) {
		$r_tt['phi_ship'] = number_format($r_tt['phi_ship']) . 'đ';
	} else {
		$r_tt['phi_ship'] = 'Miễn phí';
	}
	$r_tt['list_sanpham'] = $list_sanpham;
	$r_tt['tamtinh'] = number_format($r_tt['tamtinh']);
	$r_tt['giam'] = number_format($r_tt['giam']);
	$r_tt['tongtien'] = number_format($r_tt['tongtien']);
	if ($r_tt['id'] < 107) {
		$thongtin_huyen = mysqli_query($conn, "SELECT huyen.*,tinh.tieu_de AS ten_tinh FROM huyen INNER JOIN tinh ON tinh.id=huyen.tinh WHERE huyen.id='{$r_tt['huyen']}'");
		$r_h = mysqli_fetch_assoc($thongtin_huyen);
		$r_tt['tinh'] = $r_h['ten_tinh'];
		$r_tt['huyen'] = $r_h['tieu_de'];
	} else if($r_tt['id']<10489) {
		$thongtin_huyen = mysqli_query($conn, "SELECT huyen_moi.*,tinh_moi.tieu_de AS ten_tinh FROM huyen_moi INNER JOIN tinh_moi ON tinh_moi.id=huyen_moi.tinh WHERE huyen_moi.id='{$r_tt['huyen']}'");
		$r_h = mysqli_fetch_assoc($thongtin_huyen);
		$r_tt['tinh'] = $r_h['ten_tinh'];
		$r_tt['huyen'] = $r_h['tieu_de'];
	} else {
		$thongtin_huyen = mysqli_query($conn, "SELECT huyen_viettel.*,tinh_viettel.PROVINCE_NAME AS ten_tinh FROM huyen_viettel INNER JOIN tinh_viettel ON tinh_viettel.PROVINCE_ID=huyen_viettel.PROVINCE_ID WHERE huyen_viettel.DISTRICT_ID='{$r_tt['huyen']}'");
		$r_h = mysqli_fetch_assoc($thongtin_huyen);
		$r_tt['tinh'] = $r_h['ten_tinh'];
		$r_tt['huyen'] = $r_h['DISTRICT_NAME'];
	}
	if ($r_tt['status'] == 1) {
		$r_tt['status'] = 'Đã tiếp nhận đơn';
	} else if ($r_tt['status'] == 2) {
		$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
	} else if ($r_tt['status'] == 3) {
		$r_tt['status'] = 'Đã yêu cầu hủy đơn';
	} else if ($r_tt['status'] == 4) {
		$r_tt['status'] = 'Đã hủy đơn';
	} else if ($r_tt['status'] == 5) {
		$r_tt['status'] = 'Giao thành công';
	} else if ($r_tt['status'] == 6) {
		$r_tt['status'] = 'Đã hoàn đơn';
	} else {
		$r_tt['status'] = 'Chờ xử lý';
	}
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_donhang_drop', $r_tt);
?>