<?php
	$thaythe['title'] = 'Thống kê chung';
	$thaythe['title_action'] = 'Thống kê chung';
	$end = date('d/m/Y');
	$date_end = date('d');
	$month_end = date('m');
	$year_end = date('Y');
	$end_time = mktime(23, 59, 59, $month_end, $date_end, $year_end);
	$begin_time = $end_time - 31 * 24 * 3600;
	$begin = date('d/m/Y', $begin_time);
	$thongke = json_decode($class_index->thongke_doanhthu($conn,$user_id, $begin_time, $end_time), true);
	$list_donhang_cuaban=json_decode($class_index->list_donhang_moi($conn, $user_id, 1, 30),true);
	$bien = array(
		'footer' => $skin->skin_normal('skin_admin/footer'),
		'end' => $end,
		'begin' => $begin,
		'doanhthu_cho' => $thongke['doanhthu_cho'],
		'doanhthu_tiepnhan' => $thongke['doanhthu_tiepnhan'],
		'doanhthu_hoanthanh' => $thongke['doanhthu_hoanthanh'],
		'doanhthu_giao' => $thongke['doanhthu_vanchuyen'],
		'doanhthu_huy' => $thongke['doanhthu_huy'],
		'doanhthu_hoan' => $thongke['doanhthu_hoan'],
		'donhang_cho' => $thongke['donhang_cho'],
		'donhang_tiepnhan' => $thongke['donhang_tiepnhan'],
		'donhang_hoanthanh' => $thongke['donhang_hoanthanh'],
		'donhang_giao' => $thongke['donhang_vanchuyen'],
		'donhang_huy' => $thongke['donhang_huy'],
		'donhang_hoan' => $thongke['donhang_hoan'],
		'list_donhang'=>$list_donhang['list'],
		'list_donhang_cuaban'=>$list_donhang_cuaban['list']
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/dashboard', $bien);
?>