<?php
	$thaythe['title'] = 'Danh sách thành viên';
	$thaythe['title_action'] = 'Danh sách thành viên';
	$limit = 10;
	$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM user_info WHERE shop='$user_id'");
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	$bien = array(
		'list_thanhvien' => $class_index->list_thanhvien($conn, $user_id, 'all', $page, $limit),
		'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-thanhvien'),
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_thanhvien', $bien);
?>