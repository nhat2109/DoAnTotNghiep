<?php
	$thaythe['title'] = 'Danh sách sản phẩm';
	$thaythe['title_action'] = 'Danh sách sản phẩm';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM sanpham_shop WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_sanpham' => $class_index->list_sanpham_shop($conn,$user_info['leader'],$user_info['gia_leader'], $domain, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-sanpham'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_sanpham', $bien);
?>