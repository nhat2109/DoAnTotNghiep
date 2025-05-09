<?php
	$cat_id = intval($_REQUEST['cat_id']);
	$main = intval($_REQUEST['main']);
	$tach_list = json_decode($class_index->list_div_sub_sub_category_sanpham($conn, $user_id, $cat_id, ''), true);
	if ($tach_list['total'] > 0) {
		$ok = 1;
		$thongbao = 'Lấy dữ liệu thành công';
	} else {
		$ok = 0;
		$thongbao = 'Danh mục này không có danh mục con';
	}
	$bien = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list' => $tach_list['list'],
	);
	echo json_encode($bien);
?>