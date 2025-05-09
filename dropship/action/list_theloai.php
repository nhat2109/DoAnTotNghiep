<?php
	$thaythe['title'] = 'Danh mục bài viết';
	$thaythe['title_action'] = 'Danh mục bài viết';
	$limit = 50;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM category_shop WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_theloai' => $class_index->list_category($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-theloai'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_theloai', $bien);
?>