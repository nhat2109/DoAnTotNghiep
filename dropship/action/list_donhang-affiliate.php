<?php
	$thaythe['title'] = 'Danh sách đơn hàng affiliate';
	$thaythe['title_action'] = 'Danh sách đơn hàng affiliate';
	$limit = 50;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM donhang WHERE utm_source='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	if($check->is_mobile()==true){
		$kieu='mobile';
	}else{
		$kieu='laptop';
	}
	$bien = array(
		'list_donhang_aff' => $class_index->list_donhang_affiliate($conn,$user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-donhang-affiliate'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_donhang_affiliate', $bien);
?>