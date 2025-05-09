<?php
	$thaythe['title'] = 'Báo cáo doanh thu';
	$thaythe['title_action'] = 'Báo cáo doanh thu';
	if ($user_info['leader'] == 0) {
		$thongbao = "Bạn không có quyền truy cập...";
		$replace = array(
			'title' => 'Bạn không có quyền truy cập...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/ncc/dangky-leader',
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	} else {
		$thongtin_nhom=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
		while($r_n=mysqli_fetch_assoc($thongtin_nhom)){
			$list_id.=$r_n['user_id'].',';
		}
		if($list_id==''){

		}else{
			$list_id=substr($list_id, 0,-1);
		}
		$end = date('d/m/Y');
		$date_end = date('d');
		$month_end = date('m');
		$year_end = date('Y');
		$end_time = mktime(23, 59, 59, $month_end, $date_end, $year_end);
		$begin_time = $end_time - 31 * 24 * 3600;
		$begin = date('d/m/Y', $begin_time);
		$thongke_san = json_decode($class_index->thongke_doanhthu($conn, $list_id, $begin_time, $end_time), true);
		$thongke_socdo = json_decode($class_index->thongke_doanhthu_socdo($conn, $list_id, $begin_time, $end_time), true);
		$thongke_aff = json_decode($class_index->thongke_doanhthu_aff($conn, $list_id, $begin_time, $end_time), true);
		$doanhthu_cho = $thongke_san['doanhthu_cho'] + $thongke_socdo['doanhthu_cho']+ $thongke_aff['doanhthu_cho'];
		$doanhthu_tiepnhan = $thongke_san['doanhthu_tiepnhan'] + $thongke_socdo['doanhthu_tiepnhan'] + $thongke_aff['doanhthu_tiepnhan'];
		$doanhthu_hoanthanh = $thongke_san['doanhthu_hoanthanh'] + $thongke_socdo['doanhthu_hoanthanh'] + $thongke_aff['doanhthu_hoanthanh'];
		$doanhthu_giao = $thongke_san['doanhthu_vanchuyen'] + $thongke_socdo['doanhthu_vanchuyen'] + $thongke_aff['doanhthu_vanchuyen'];
		$doanhthu_huy = $thongke_san['doanhthu_huy'] + $thongke_socdo['doanhthu_huy'] + $thongke_aff['doanhthu_huy'];
		$doanhthu_hoan = $thongke_san['doanhthu_hoan'] + $thongke_socdo['doanhthu_hoan'] + $thongke_aff['doanhthu_hoan'];
		$donhang_cho = $thongke_san['donhang_cho'] + $thongke_socdo['donhang_cho'] + $thongke_aff['donhang_cho'];
		$donhang_tiepnhan = $thongke_san['donhang_tiepnhan'] + $thongke_socdo['donhang_tiepnhan'] + $thongke_aff['donhang_tiepnhan'];
		$donhang_hoanthanh = $thongke_san['donhang_hoanthanh'] + $thongke_socdo['donhang_hoanthanh'] + $thongke_aff['donhang_hoanthanh'];
		$donhang_giao = $thongke_san['donhang_vanchuyen'] + $thongke_socdo['donhang_vanchuyen'] + $thongke_aff['donhang_vanchuyen'];
		$donhang_huy = $thongke_san['donhang_huy'] + $thongke_socdo['donhang_huy'] + $thongke_aff['donhang_huy'];
		$donhang_hoan = $thongke_san['donhang_hoan'] + $thongke_socdo['donhang_hoan'] + $thongke_aff['donhang_hoan'];
		$bien = array(
			'footer' => $skin->skin_normal('skin_admin/footer'),
			'end' => $end,
			'begin' => $begin,
			'doanhthu_cho' => number_format($doanhthu_cho),
			'doanhthu_tiepnhan' => number_format($doanhthu_tiepnhan),
			'doanhthu_hoanthanh' => number_format($doanhthu_hoanthanh),
			'doanhthu_giao' => number_format($doanhthu_vanchuyen),
			'doanhthu_huy' => number_format($doanhthu_huy),
			'doanhthu_hoan' => number_format($doanhthu_hoan),
			'donhang_cho' => number_format($donhang_cho),
			'donhang_tiepnhan' => number_format($donhang_tiepnhan),
			'donhang_hoanthanh' => number_format($donhang_hoanthanh),
			'donhang_giao' => number_format($donhang_vanchuyen),
			'donhang_huy' => number_format($donhang_huy),
			'donhang_hoan' => number_format($donhang_hoan),
			'doanhthu_cho_socdo' => number_format($thongke_socdo['doanhthu_cho']),
			'doanhthu_tiepnhan_socdo' => number_format($thongke_socdo['doanhthu_tiepnhan']),
			'doanhthu_hoanthanh_socdo' => number_format($thongke_socdo['doanhthu_hoanthanh']),
			'doanhthu_giao_socdo' => number_format($thongke_socdo['doanhthu_vanchuyen']),
			'doanhthu_huy_socdo' => number_format($thongke_socdo['doanhthu_huy']),
			'doanhthu_hoan_socdo' => number_format($thongke_socdo['doanhthu_hoan']),
			'donhang_cho_socdo' => number_format($thongke_socdo['donhang_cho']),
			'donhang_tiepnhan_socdo' => number_format($thongke_socdo['donhang_tiepnhan']),
			'donhang_hoanthanh_socdo' => number_format($thongke_socdo['donhang_hoanthanh']),
			'donhang_giao_socdo' => number_format($thongke_socdo['donhang_vanchuyen']),
			'donhang_huy_socdo' => number_format($thongke_socdo['donhang_huy']),
			'donhang_hoan_socdo' => number_format($thongke_socdo['donhang_hoan']),
			'doanhthu_cho_aff' => number_format($thongke_aff['doanhthu_cho']),
			'doanhthu_tiepnhan_aff' => number_format($thongke_aff['doanhthu_tiepnhan']),
			'doanhthu_hoanthanh_aff' => number_format($thongke_aff['doanhthu_hoanthanh']),
			'doanhthu_giao_aff' => number_format($thongke_aff['doanhthu_vanchuyen']),
			'doanhthu_huy_aff' => number_format($thongke_aff['doanhthu_huy']),
			'doanhthu_hoan_aff' => number_format($thongke_aff['doanhthu_hoan']),
			'donhang_cho_aff' => number_format($thongke_aff['donhang_cho']),
			'donhang_tiepnhan_aff' => number_format($thongke_aff['donhang_tiepnhan']),
			'donhang_hoanthanh_aff' => number_format($thongke_aff['donhang_hoanthanh']),
			'donhang_giao_aff' => number_format($thongke_aff['donhang_vanchuyen']),
			'donhang_huy_aff' => number_format($thongke_aff['donhang_huy']),
			'donhang_hoan_aff' => number_format($thongke_aff['donhang_hoan']),
			'doanhthu_cho_san' => number_format($thongke_san['doanhthu_cho']),
			'doanhthu_tiepnhan_san' => number_format($thongke_san['doanhthu_tiepnhan']),
			'doanhthu_hoanthanh_san' => number_format($thongke_san['doanhthu_hoanthanh']),
			'doanhthu_giao_san' => number_format($thongke_san['doanhthu_vanchuyen']),
			'doanhthu_huy_san' => number_format($thongke_san['doanhthu_huy']),
			'doanhthu_hoan_san' => number_format($thongke_san['doanhthu_hoan']),
			'donhang_cho_san' => number_format($thongke_san['donhang_cho']),
			'donhang_tiepnhan_san' => number_format($thongke_san['donhang_tiepnhan']),
			'donhang_hoanthanh_san' => number_format($thongke_san['donhang_hoanthanh']),
			'donhang_giao_san' => number_format($thongke_san['donhang_vanchuyen']),
			'donhang_huy_san' => number_format($thongke_san['donhang_huy']),
			'donhang_hoan_san' => number_format($thongke_san['donhang_hoan']),
		);
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/thongke_doanhthu_nhom', $bien);
	}
?>