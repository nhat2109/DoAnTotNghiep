<?php
	$thaythe['title'] = 'Danh sách bom hàng';
	$thaythe['title_action'] = 'Danh sách bom hàng';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM bom_hang");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_bom' => $class_index->list_bom($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-bom-hang'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_bom_hang', $bien);
?>