<?php
	$thaythe['title'] = 'Danh sách thành viên nhóm';
	$thaythe['title_action'] = 'Danh sách thành viên nhóm';
	$limit = 100;
	$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	if ($user_info['leader'] == 0) {
		$thongbao = "Bạn không có quyền truy cập...";
		$replace = array(
			'title' => 'Bạn không có quyền truy cập...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/dropship/dangky-leader',
		);
		echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
		exit();
	} else {
	$thongtin_nhom=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
	// while($r_n=mysqli_fetch_assoc($thongtin_nhom)){
	// 	$list_id.=$r_n['user_id'].',';
	// }
	// if($list_id==''){

	// }else{
	// 	$list_id=substr($list_id, 0,-1);
	// }
	while($r_n=mysqli_fetch_assoc($thongtin_nhom)){
		if($r_n['leader']==1){
			$list_leader.=$r_n['user_id'].',';
		}else{
			$list_id.=$r_n['user_id'].',';
		}
		$list_all.=$r_n['user_id'].',';
	}
	if($list_id==''){

	}else{
		$list_id=substr($list_id, 0,-1);
	}
	if($list_leader==''){

	}else{
		$list_leader=substr($list_leader, 0,-1);
	}
	if($list_all==''){

	}else{
		$list_all=substr($list_all, 0,-1);
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
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM user_info WHERE aff='$user_id'");
	$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
	
	//$thongke_hoahong = json_decode($class_index->thongke_hoahong($conn,$list_leader, $list_id,$list_all, $begin_time, $end_time), true);
	$thongke_hoahong = json_decode($class_index->thongke_hoahong($conn,$list_leader, $list_id,$list_all, $begin_time, $end_time), true);
	
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	// thongke_donhang-nhom
	$homnay = date('d');
	$thangnay = intval(date('m'));
	$namnay = date('Y');
	$date = mktime(0, 0, 0, $thangnay, $homnay, $namnay);
	$week = (int) date('W', $date);
	$ngay_dau = mktime(0, 0, 0, 01, 01, date('Y'));
	$ngay_cuoi = mktime(0, 0, 0, 12, 31, date('Y'));
	if ($thangnay == 2) {
		if (checkdate(02, 29, $namnay) == true) {
			$ngay_dau_thang = mktime(0, 0, 0, $thangnay, 1, $namnay);
			$ngay_cuoi_thang = mktime(0, 0, 0, $thangnay, 29, $namnay);
			for ($i = 1; $i <= 29; $i++) {
				if ($i < 10) {
					$list_ngay .= '0' . $i . ',';
				} else {
					$list_ngay .= $i . ',';
				}
			}
		} else {
			$ngay_dau_thang = mktime(0, 0, 0, $thangnay, 1, $namnay);
			$ngay_cuoi_thang = mktime(0, 0, 0, $thangnay, 28, $namnay);
			for ($i = 1; $i <= 20; $i++) {
				if ($i < 10) {
					$list_ngay .= '0' . $i . ',';
				} else {
					$list_ngay .= $i . ',';
				}
			}

		}
	} else if (in_array($thangnay, array('1', '3', '5', '7', '8', '10', '12')) == true) {
		$ngay_dau_thang = mktime(0, 0, 0, $thangnay, 1, $namnay);
		$ngay_cuoi_thang = mktime(0, 0, 0, $thangnay, 31, $namnay);
		for ($i = 1; $i <= 31; $i++) {
			if ($i < 10) {
				$list_ngay .= '0' . $i . ',';
			} else {
				$list_ngay .= $i . ',';
			}
		}
	} else {
		$ngay_dau_thang = mktime(0, 0, 0, $thangnay, 1, $namnay);
		$ngay_cuoi_thang = mktime(0, 0, 0, $thangnay, 30, $namnay);
		for ($i = 1; $i <= 30; $i++) {
			if ($i < 10) {
				$list_ngay .= '0' . $i . ',';
			} else {
				$list_ngay .= $i . ',';
			}
		}
	}
	$list_ngay = substr($list_ngay, 0, -1);
	$ngay_tuan = $check->day_from_monday(date('d-m-Y'));
	$ngay_dau_tuan = mktime(0, 0, 0, $thangnay, $ngay_tuan[0], $namnay);
	$ngay_cuoi_tuan = mktime(0, 0, 0, $thangnay, $ngay_tuan[6], $namnay);
	$bien = array(
		'doanhthu_nangcap' => number_format($thongke_hoahong['doanhthu_nangcap']),
		'doanhthu_nhom' => number_format($thongke_hoahong['doanhthu_nhom']),
		'doanhthu_nhom_gioithieu' => number_format($thongke_hoahong['doanhthu_nhom_gioithieu']),
		'doanhthu_tong' => number_format($thongke_hoahong['doanhthu_tong']),
		'donhang_nangcap' => number_format($thongke_hoahong['donhang_nangcap']),
		'donhang_nhom' => number_format($thongke_hoahong['donhang_nhom']),
		'donhang_nhom_gioithieu' => number_format($thongke_hoahong['donhang_nhom_gioithieu']),
		'donhang_tong' => number_format($thongke_hoahong['donhang_tong']),
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
		'tieu_de' => $r_cn['tieu_de'],
		'list_thanhvien' => $class_index->list_thanhvien_nhom($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-thanhvien-nhom'),
		// thongke_donhang-nhom
		'tuan' => $week,
		'thang' => date('m'),
		'nam' => date('Y'),
		'ngay' => date('d'),
		'ngay_dau_tuan' => $ngay_tuan[0] . '/' . $thangnay . '/' . $namnay,
		'ngay_cuoi_tuan' => $ngay_tuan[6] . '/' . $thangnay . '/' . $namnay,
		'data_nam' => $class_index->thongke_donhang_nhom_nam($conn,$list_id, $ngay_dau, $ngay_cuoi),
		'list_ngay' => $list_ngay,
		'data_thang' => $class_index->thongke_donhang_nhom_thang($conn,$list_id, $thangnay, $namnay, $ngay_dau_thang, $ngay_cuoi_thang),
		'data_tuan' => $class_index->thongke_donhang_nhom_tuan($conn,$list_id, $ngay_dau_tuan, $ngay_cuoi_tuan),
	);
		$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_thanhvien_nhom', $bien);
	}	
?>