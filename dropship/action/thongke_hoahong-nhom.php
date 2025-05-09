<?php
	$thaythe['title'] = 'Báo cáo hoa hồng nhóm';
	$thaythe['title_action'] = 'Báo cáo hoa hồng nhóm';
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
		$list_id='';
		$list_leader='';
		$list_all='';
		$thongtin_nhom=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
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
		$thongke = json_decode($class_index->thongke_hoahong($conn,$list_leader, $list_id,$list_all, $begin_time, $end_time), true);
		$bien = array(
			'footer' => $skin->skin_normal('skin_admin/footer'),
			'end' => $end,
			'begin' => $begin,
			'doanhthu_nangcap' => number_format($thongke['doanhthu_nangcap']),
			'doanhthu_nhom' => number_format($thongke['doanhthu_nhom']),
			'doanhthu_nhom_gioithieu' => number_format($thongke['doanhthu_nhom_gioithieu']),
			'doanhthu_tong' => number_format($thongke['doanhthu_tong']),
			'donhang_nangcap' => number_format($thongke['donhang_nangcap']),
			'donhang_nhom' => number_format($thongke['donhang_nhom']),
			'donhang_nhom_gioithieu' => number_format($thongke['donhang_nhom_gioithieu']),
			'donhang_tong' => number_format($thongke['donhang_tong']),
		);
		$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/thongke_hoahong_nhom', $bien);
	}
?>