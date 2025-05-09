<?php
	$thaythe['title'] = 'Sản phẩm sắp hết hàng';
	$thaythe['title_action'] = 'Sản phẩm sắp hết hàng';
	$limit = 100;
	if (isset($_COOKIE['drop_kho'])) {
		$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
	} else {
		$kho = 'kho';
	}
	if ($kho == 'kho_hcm') {
		$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM sanpham WHERE kho_hcm<='10'");
	} else {
		$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM sanpham WHERE kho<='10'");
	}
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_sanpham' => $class_index->list_sanpham_hethang($conn,$user_info['leader'],$user_info['gia_leader'], $kho, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-sanpham-hethang'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_sanpham_hethang', $bien);
?>