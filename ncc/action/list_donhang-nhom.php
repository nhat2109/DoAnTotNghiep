<?php
	$limit = 50;
	$loai=addslashes(strip_tags($url_query['loai']));
	$status=addslashes(strip_tags($url_query['status']));
	$thongtin_nhom=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
	while($r_n=mysqli_fetch_assoc($thongtin_nhom)){
		$list_id.=$r_n['user_id'].',';
	}
	if($list_id==''){
		if($loai=='drop'){
			$tit='Danh sách đơn sàn TMĐT ';
		}else if($loai=='socdo'){
			$tit='Danh sách đơn SÓC ĐỎ ';
		}else if($loai=='affiliate'){
			$tit='Danh sách đơn Affilate ';
		}
		if($status=='wait'){
			$st=0;
			$thaythe['title_action'] = $tit.'chờ xử lý';
		}else if($status=='tiepnhan'){
			$st=1;
			$thaythe['title_action'] = $tit.'đã tiếp nhận';
		}else if($status=='vanchuyen'){
			$st=2;
			$thaythe['title_action'] = $tit.'đang vận chuyển';
		}else if($status=='huy'){
			$st=4;
			$thaythe['title_action'] = $tit.'đã hủy';
		}else if($status=='hoan'){
			$st=6;
			$thaythe['title_action'] = $tit.'hoàn đơn';
		}else if($status=='dagiao'){
			$st=5;
			$thaythe['title_action'] = $tit.'giao thành công';
		}
		$thaythe['title'] = $thaythe['title_action'];
		$bien = array(
			'list_donhang' => '',
			'loai'=>$loai,
			'phantrang' => '',
		);
	}else{
		$list_id=substr($list_id, 0,-1);
		if($loai=='drop'){
			$tit='Danh sách đơn sàn TMĐT ';
		}else if($loai=='socdo'){
			$tit='Danh sách đơn SÓC ĐỎ ';
		}else if($loai=='affiliate'){
			$tit='Danh sách đơn Affilate ';
		}
		if($status=='wait'){
			$st=0;
			$thaythe['title_action'] = $tit.'chờ xử lý';
		}else if($status=='tiepnhan'){
			$st=1;
			$thaythe['title_action'] = $tit.'đã tiếp nhận';
		}else if($status=='vanchuyen'){
			$st=2;
			$thaythe['title_action'] = $tit.'đang vận chuyển';
		}else if($status=='huy'){
			$st=4;
			$thaythe['title_action'] = $tit.'đã hủy';
		}else if($status=='hoan'){
			$st=6;
			$thaythe['title_action'] = $tit.'hoàn đơn';
		}else if($status=='dagiao'){
			$st=5;
			$thaythe['title_action'] = $tit.'giao thành công';
		}
		$thaythe['title'] = $thaythe['title_action'];
		if($loai=='drop'){
			$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM donhang WHERE user_id IN ($list_id) AND status='$st'");
		}else if($loai=='socdo'){
			$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM donhang_ncc WHERE user_id IN ($list_id) AND status='$st'");
		}else if($loai=='affiliate'){
			$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM donhang WHERE utm_source IN ($list_id) AND status='$st'");
		}
		$r_tk = mysqli_fetch_assoc($thongke);
		$total_page = ceil($r_tk['total'] / $limit);
		$bien = array(
			'list_donhang' => $class_index->list_donhang_nhom($conn, $list_id,$loai,$st,$r_tk['total'], $page, $limit),
			'loai'=>$loai,
			'status'=>$status,
			'phantrang' => $class_index->phantrang_timkiem($page, $total_page, '/ncc/list-donhang-nhom?loai='.$loai.'&status='.$status),
		);
	}
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_donhang_nhom', $bien);
?>