<?php
	$thaythe['title'] = 'Sửa khách bom hàng';
	$thaythe['title_action'] = 'Sửa khách bom hàng';
	$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM bom_hang WHERE id='$id' AND user_id='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Dữ liệu không tồn tại...";
		$replace = array(
			'title' => 'Dữ liệu không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/dropship/list-bom-hang',
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong', $replace);
		exit();
	}
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/edit_bom', $r_tt);
?>