<?php
	$limit = 50;
	$loai=addslashes(strip_tags($url_query['loai']));
	$thongtin_nhom=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
	while($r_n=mysqli_fetch_assoc($thongtin_nhom)){
		$list_id.=$r_n['user_id'].',';
	}
	if($loai=='nhaban-chuyennghiep'){
		$thaythe['title_action'] = 'Thưởng nâng cấp nhà bán hàng chuyên nghiệp';
	}else if($loai=='doanhthu-nhom'){
		$thaythe['title_action'] = 'Thưởng doanh thu nhóm quản lý';
	}else if($loai=='thunhap-nhaban'){
		$thaythe['title_action'] = 'Thưởng doanh thu nhóm nhà bán chuyên nghiệp';
	}
	$thaythe['title'] = $thaythe['title_action'];
	if($list_id==''){
		$bien = array(
			'list_donhang' => '',
			'loai'=>$loai,
			'phantrang' => '',
		);
	}else{
		$list_id=substr($list_id, 0,-1);
		if($loai=='nhaban-chuyennghiep'){
			$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM user_info WHERE user_id IN ($list_id) AND leader='1'");
		}else if($loai=='doanhthu-nhom'){
			$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM donhang_ctv WHERE user_id IN ($list_id) AND status='$st'");
		}else if($loai=='thunhap-nhaban'){
			$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM donhang WHERE utm_source IN ($list_id) AND status='$st'");
		}
		$r_tk = mysqli_fetch_assoc($thongke);
		$total_page = ceil($r_tk['total'] / $limit);
		$bien = array(
			'list_donhang' => $class_index->list_donhang_nhom($conn, $list_id,$loai,$st,$r_tk['total'], $page, $limit),
			'loai'=>$loai,
			'phantrang' => $class_index->phantrang_timkiem($page, $total_page, '/dropship/list-thunhap-nhom?loai='.$loai),
		);
	}
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_thunhap_nhom', $bien);
?>