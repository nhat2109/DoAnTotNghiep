<?php
	$thaythe['title'] = 'Danh sách đăng ký nhận tin';
	$thaythe['title_action'] = 'Danh sách đăng ký nhận tin';
	$limit = 100;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM dangky_nhantin WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_nhantin' => $class_index->list_nhantin($conn, $user_id, $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/dropship/list-nhantin'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_nhantin', $bien);
?>