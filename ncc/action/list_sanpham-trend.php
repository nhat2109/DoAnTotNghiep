<?php
	$thaythe['title'] = 'Danh sách sản phẩm Trend';
	$thaythe['title_action'] = 'Danh sách sản phẩm Trend';
	$limit = 10;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM sanpham_trend");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	if (isset($_COOKIE['drop_kho'])) {
		$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
	} else {
		$kho = 'kho';
	}
	if($check->is_mobile()==true){
		$bien = array(
			'list_sanpham' => $class_index->list_sanpham_trend($conn,$user_info['leader'],$user_info['gia_leader'],'mobile', $kho, $user_id, $page, $limit),
			'option_thuonghieu' => $class_index->list_option_brand($conn, 0, ''),
			'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-sanpham-trend'),
		);
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_sanpham_trend_mobile', $bien);
	}else{
		$bien = array(
			'list_sanpham' => $class_index->list_sanpham_trend($conn,$user_info['leader'],$user_info['gia_leader'],'laptop', $kho, $user_id, $page, $limit),
			'option_thuonghieu' => $class_index->list_option_brand($conn, 0, ''),
			'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-sanpham-trend'),
		);
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_sanpham_trend', $bien);
	}
?>