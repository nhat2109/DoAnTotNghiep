<?php
			$thongtin_nhom=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
			while($r_n=mysqli_fetch_assoc($thongtin_nhom)){
				$list_id.=$r_n['user_id'].',';
			}
			if($list_id==''){

			}else{
				$list_id=substr($list_id, 0,-1);
			}
			$end = addslashes(strip_tags($_REQUEST['time_end']));
			$tach_end = explode('/', $end);
			$date_end = $tach_end[0];
			$month_end = $tach_end[1];
			$year_end = $tach_end[2];
			$end_time = mktime(23, 59, 59, $month_end, $date_end, $year_end);
			$begin = addslashes(strip_tags($_REQUEST['time_begin']));
			$tach_begin = explode('/', $begin);
			$date_begin = $tach_begin[0];
			$month_begin = $tach_begin[1];
			$year_begin = $tach_begin[2];
			$begin_time = mktime(0, 0, 0, $month_begin, $date_begin, $year_begin);
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
			$ok = 1;
			$thongbao = 'Lấy dữ liệu thành công';
			$bien = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
				'doanhthu_hoanthanh' => number_format($doanhthu_hoanthanh) . ' đ',
				'doanhthu_giao' => number_format($doanhthu_vanchuyen) . ' đ',
				'doanhthu_huy' => number_format($doanhthu_huy) . ' đ',
				'doanhthu_hoan' => number_format($doanhthu_hoan) . ' đ',
				'doanhthu_cho' => number_format($doanhthu_cho) . ' đ',
				'doanhthu_tiepnhan' => number_format($doanhthu_tiepnhan) . ' đ',
				'donhang_hoanthanh' => 'với <b>' . number_format($donhang_hoanthanh) . ' đơn hàng</b>',
				'donhang_giao' => 'với <b>' . number_format($donhang_vanchuyen) . ' đơn hàng</b>',
				'donhang_huy' => 'với <b>' . number_format($donhang_huy) . ' đơn hàng</b>',
				'donhang_hoan' => 'với <b>' . number_format($donhang_hoan) . ' đơn hàng</b>',
				'donhang_cho' => 'với <b>' . number_format($donhang_cho) . ' đơn hàng</b>',
				'donhang_tiepnhan' => 'với <b>' . number_format($donhang_tiepnhan) . ' đơn hàng</b>',
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
			echo json_encode($bien);
?>