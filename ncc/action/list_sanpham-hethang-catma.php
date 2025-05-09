<?php
	$thaythe['title'] = 'Sản phẩm hết hàng cắt mã';
	$thaythe['title_action'] = 'Sản phẩm hết hàng cắt mã';
	$limit = 100;
	if (isset($_COOKIE['drop_kho'])) {
		$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
	} else {
		$kho = 'kho';
	}
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM sanpham WHERE cat_ma='1'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_sanpham' => $class_index->list_sanpham_hethang_catma($conn,$user_info['leader'],$user_info['gia_leader'], $kho, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-sanpham-hethang-catma'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_sanpham_hethang_catma', $bien);
?>