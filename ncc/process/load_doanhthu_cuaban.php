<?php
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
			if (!checkdate($month_begin, $date_begin, $year_begin)) {
				echo json_encode(array('ok' => 0, 'thongbao' => 'Ngày bắt đầu không hợp lệ'));
				exit;
			}
			if (!checkdate($month_end, $date_end, $year_end)) {
				echo json_encode(array('ok' => 0, 'thongbao' => 'Ngày kết thúc không hợp lệ'));
				exit;
			}
			if ($begin_time > $end_time) {
				echo json_encode(array('ok' => 0, 'thongbao' => 'Ngày bắt đầu không được lớn hơn ngày kết thúc'));
				exit;
			}
			$thongke = json_decode($class_index->thongke_doanhthu($conn, $user_id, $begin_time, $end_time), true);
			// $thongke_socdo = json_decode($class_index->thongke_doanhthu_socdo($conn, $user_id, $begin_time, $end_time), true);
			// $thongke_aff = json_decode($class_index->thongke_doanhthu_aff($conn, $user_id, $begin_time, $end_time), true);
			$ok = 1;
			$thongbao = 'Lấy dữ liệu thành công';
			$bien = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
				'doanhthu_hoanthanh' => $thongke['doanhthu_hoanthanh'] ,
				'doanhthu_giao' => $thongke['doanhthu_vanchuyen'] ,
				'doanhthu_huy' => $thongke['doanhthu_huy'],
				'doanhthu_hoan' => $thongke['doanhthu_hoan'] ,
				'doanhthu_cho' => $thongke['doanhthu_cho'],
				'doanhthu_tiepnhan' => $thongke['doanhthu_tiepnhan'] ,
				'donhang_hoanthanh' => $thongke['donhang_hoanthanh'],
				'donhang_giao' => $thongke['donhang_vanchuyen'],
				'donhang_huy' => $thongke['donhang_huy'],
				'donhang_hoan' => $thongke['donhang_hoan'],
				'donhang_cho' => $thongke['donhang_cho'],
				'donhang_tiepnhan' => $thongke['donhang_tiepnhan'],
				// 'doanhthu_hoanthanh_socdo' => number_format($thongke_socdo['doanhthu_hoanthanh']) . ' đ',
				// 'doanhthu_giao_socdo' => number_format($thongke_socdo['doanhthu_vanchuyen']) . ' đ',
				// 'doanhthu_huy_socdo' => number_format($thongke_socdo['doanhthu_huy']) . ' đ',
				// 'doanhthu_hoan_socdo' => number_format($thongke_socdo['doanhthu_hoan']) . ' đ',
				// 'doanhthu_cho_socdo' => number_format($thongke_socdo['doanhthu_cho']) . ' đ',
				// 'doanhthu_tiepnhan_socdo' => number_format($thongke_socdo['doanhthu_tiepnhan']) . ' đ',
				// 'donhang_hoanthanh_socdo' => 'với ' . number_format($thongke_socdo['donhang_hoanthanh']) . ' đơn hàng',
				// 'donhang_giao_socdo' => 'với ' . number_format($thongke_socdo['donhang_vanchuyen']) . ' đơn hàng',
				// 'donhang_huy_socdo' => 'với ' . number_format($thongke_socdo['donhang_huy']) . ' đơn hàng',
				// 'donhang_hoan_socdo' => 'với ' . number_format($thongke_socdo['donhang_hoan']) . ' đơn hàng',
				// 'donhang_cho_socdo' => 'với ' . number_format($thongke_socdo['donhang_cho']) . ' đơn hàng',
				// 'donhang_tiepnhan_socdo' => 'với ' . number_format($thongke_socdo['donhang_tiepnhan']) . ' đơn hàng',
                // 'doanhthu_hoanthanh_aff' => number_format($thongke_aff['doanhthu_hoanthanh']) . ' đ',
                // 'doanhthu_giao_aff' => number_format($thongke_aff['doanhthu_vanchuyen']) . ' đ',
                // 'doanhthu_huy_aff' => number_format($thongke_aff['doanhthu_huy']) . ' đ',
                // 'doanhthu_hoan_aff' => number_format($thongke_aff['doanhthu_hoan']) . ' đ',
                // 'doanhthu_cho_aff' => number_format($thongke_aff['doanhthu_cho']) . ' đ',
                // 'doanhthu_tiepnhan_aff' => number_format($thongke_aff['doanhthu_tiepnhan']) . ' đ',
                // 'donhang_hoanthanh_aff' => 'với ' . number_format($thongke_aff['donhang_hoanthanh']) . ' đơn hàng',
                // 'donhang_giao_aff' => 'với ' . number_format($thongke_aff['donhang_vanchuyen']) . ' đơn hàng',
                // 'donhang_huy_aff' => 'với ' . number_format($thongke_aff['donhang_huy']) . ' đơn hàng',
                // 'donhang_hoan_aff' => 'với ' . number_format($thongke_aff['donhang_hoan']) . ' đơn hàng',
                // 'donhang_cho_aff' => 'với ' . number_format($thongke_aff['donhang_cho']) . ' đơn hàng',
                // 'donhang_tiepnhan_aff' => 'với ' . number_format($thongke_aff['donhang_tiepnhan']) . ' đơn hàng',
			);
			echo json_encode($bien);
?>