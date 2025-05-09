<?php
	$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM thongbao WHERE id='$id' AND (noi_dang LIKE '%all%' OR noi_dang LIKE '%drop%')");
	$r_tt = mysqli_fetch_assoc($thongtin);
	$thaythe['title'] = $r_tt['tieu_de'];
	$thaythe['title_action'] = 'Đọc thông báo';
	if ($r_tt['total'] == 0) {
		$thongbao = "Thông báo không tồn tại...";
		$replace = array(
			'title' => 'Thông báo không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/dropship/list-thongbao',
		);
		echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
		exit();
	}
	$tach_doc = explode(',', $r_tt['doc']);
	if (in_array($user_id, $tach_doc) == true) {

	} else {
		if ($r_tt['doc'] == '') {
			mysqli_query($conn, "UPDATE thongbao SET doc='$user_id' WHERE id='$id'");
		} else {
			$doc = $r_tt['doc'] . ',' . $user_id;
			mysqli_query($conn, "UPDATE thongbao SET doc='$doc' WHERE id='$id'");
		}
	}
	$r_tt['list_thongbao_right'] = $class_index->list_thongbao_right($conn, $id, 10);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/view_thongbao', $r_tt);
?>