<?php
	$thaythe['title'] = 'Sửa thương hiệu sản phẩm';
	$thaythe['title_action'] = 'Sửa thương hiệu sản phẩm';
	$id = preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM thuong_hieu WHERE id='$id' AND shop='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Thương hiệu sản phẩm không tồn tại...";
		$replace = array(
			'title' => 'Thương hiệu sản phẩm không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/dropship/list-brand',
		);
		echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
		exit();
	}
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/edit_brand', $r_tt);
?>