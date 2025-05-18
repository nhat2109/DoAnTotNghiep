<?php
	$thaythe['title'] = 'Chi tiết đơn hàng';
	$thaythe['title_action'] = 'Chi tiết đơn hàng';
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM donhang_shop WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Đơn hàng không tồn tại...";
		$replace = array(
			'title' => 'Đơn hàng không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/list-donhang',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
	$tach_sanpham = json_decode($r_tt['sanpham'], true);
	foreach ($tach_sanpham as $key => $value) {
		if ($value['size'] != '') {
			$value['size'] = ' - Size: ' . strtoupper($value['size']);
		}
		if ($value['color'] != '') {
			$value['color'] = ' - Màu: ' . $value['color'];
		}
		if ($value['ma_sanpham'] != '') {
			$value['ma_sanpham'] = $value['ma_sanpham'];
		} else {
			$value['ma_sanpham'] = '';
		}
		if ($value['gia_drop'] != '') {
			$value['gia_drop'] = $value['gia_drop'];
		} else {
			$value['gia_drop'] = '';
		}
		if ($value['gia_nhap'] != '') {
			$value['gia_nhap'] = $value['gia_nhap'];
		} else {
			$value['gia_nhap'] = '';
		}
		if ($value['gia_moi'] != '') {
			$value['gia_moi'] = $value['gia_moi'];
		} else {
			$value['gia_moi'] = '';
		}
		$list_sanpham .= $skin->skin_replace('skin_ncc/box_action/li_sanpham_order_shop', $value);
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
	if ($r_tt['id'] < 11) {
		$thontin_huyen = mysqli_query($conn, "SELECT huyen.*,tinh.tieu_de AS ten_tinh FROM huyen INNER JOIN tinh ON tinh.id=huyen.tinh WHERE huyen.id='{$r_tt['huyen']}'");
	} else {
		$thontin_huyen = mysqli_query($conn, "SELECT huyen_moi.*,tinh_moi.tieu_de AS ten_tinh FROM huyen_moi INNER JOIN tinh_moi ON tinh_moi.id=huyen_moi.tinh WHERE huyen_moi.id='{$r_tt['huyen']}'");
	}
	$r_h = mysqli_fetch_assoc($thontin_huyen);
	$r_tt['tinh'] = $r_h['ten_tinh'];
	$r_tt['huyen'] = $r_h['tieu_de'];
	//
	$thongtin_payments = mysqli_query($conn, "SELECT * FROM order_payments WHERE order_id='$r_tt[ma_don]'");
	$r_payments = mysqli_fetch_assoc($thongtin_payments);
	if ($r_payments['payment_status'] == 'completed') {
		$tinhtrang = 'Đã thanh toán';
		$tinhtrang_class = 'status-completed';
	} elseif ($r_payments['payment_status'] == 'failed') {
		$tinhtrang = 'Thanh toán thất bại';
		$tinhtrang_class = 'status-failed';
	} else {
		$tinhtrang = 'Chưa thanh toán';
		$tinhtrang_class = 'status-pending';
	}
	$transaction_id = $r_payments['transaction_id'];
	$ngaythanhtoan=$r_payments['created_at'];
	$r_tt['phuongthuc'] =$r_tt['thanhtoan'];
	$r_tt['tinhtrang'] = $tinhtrang;
	$r_tt['tinhtrang_class'] = $tinhtrang_class;
	$r_tt['transaction_id']=$transaction_id;
	$r_tt['ngaythanhtoan'] =$ngaythanhtoan;

	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/edit_donhang', $r_tt);
?>