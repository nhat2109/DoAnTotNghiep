<?php
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
	}
	$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thaythe['title'] = 'Thống kê đơn hàng nhóm';
	$thaythe['title_action'] = 'Thống kê đơn hàng nhóm';
	$limit = 10;
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
	$thongtin_nhom=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
	while($r_n=mysqli_fetch_assoc($thongtin_nhom)){
		$list_id.=$r_n['user_id'].',';
	}
	if($list_id==''){

	}else{
		$list_id=substr($list_id, 0,-1);
	}
	$bien = array(
		'tieu_de' => $r_cn['tieu_de'],
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
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/thongke_donhang_nhom', $bien);
?>