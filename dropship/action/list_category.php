<?php
	$thaythe['title'] = 'Danh mục sản phẩm';
	$thaythe['title_action'] = 'Danh mục sản phẩm';
	$limit = 50;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM category_sanpham_shop WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_theloai' => $class_index->list_category_sanpham($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-category'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_category', $bien);
?>