<?php
	$thaythe['title'] = 'Chương trình tuần';
	$thaythe['title_action'] = 'Chương trình tuần';
	$limit = 25;
	$hientai = time();
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM sanpham_tuan WHERE time_end>'$hientai'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	if (isset($_COOKIE['drop_kho'])) {
		$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
	} else {
		$kho = 'kho';
	}
	$bien = array(
		'list_sanpham' => $class_index->list_sanpham_tuan($conn,$user_info['leader'],$user_info['gia_leader'], $kho, $user_id, $page, $limit),
		'option_thuonghieu' => $class_index->list_option_brand($conn, 0, ''),
		'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-sanpham-tuan'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_sanpham_tuan', $bien);
?>