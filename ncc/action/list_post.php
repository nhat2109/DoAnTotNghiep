<?php
	$thaythe['title'] = 'Danh sách bài viết';
	$thaythe['title_action'] = 'Danh sách bài viết';
	$limit = 10;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM post_shop WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_baiviet' => $class_index->list_baiviet($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-post'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_post', $bien);
?>